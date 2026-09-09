<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\TrainingAttendance;
use App\Models\TrainingBarcode;
use App\Models\TrainingSession;
use App\Services\TrainingAttendanceService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TrainingScanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CONSTRUCTOR
    |--------------------------------------------------------------------------
    |
    | Semua aturan waktu presensi latihan diambil dari
    | TrainingAttendanceService.
    |
    | Dengan begitu:
    |
    | - Scanner siswa
    | - Barcode latihan
    | - Auto Alfa
    |
    | menggunakan aturan waktu yang sama.
    |
    */

    public function __construct(
        protected TrainingAttendanceService $trainingAttendanceService
    ) {
    }


    /*
    |--------------------------------------------------------------------------
    | AMBIL SISWA LOGIN
    |--------------------------------------------------------------------------
    */

    private function getStudent(): Student
    {
        $student =
            Student::where(
                'user_id',
                auth()->id()
            )->first();


        abort_unless(
            $student,
            404,
            'Data siswa tidak ditemukan.'
        );


        return $student;
    }


    /*
    |--------------------------------------------------------------------------
    | NORMALISASI CABANG OLAHRAGA
    |--------------------------------------------------------------------------
    */

    private function normalizeSport(
        ?string $sport
    ): string {

        return mb_strtolower(
            trim(
                $sport ?? ''
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CEK CABANG SISWA DAN SESI
    |--------------------------------------------------------------------------
    */

    private function studentCanAccessSession(
        Student $student,
        TrainingSession $trainingSession
    ): bool {

        if (!$student->sport) {
            return false;
        }


        return $this->normalizeSport(
            $student->sport
        ) === $this->normalizeSport(
            $trainingSession->sport
        );
    }


    /*
    |--------------------------------------------------------------------------
    | JADWAL LATIHAN SISWA
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        /*
        |--------------------------------------------------------------------------
        | SISWA LOGIN
        |--------------------------------------------------------------------------
        */

        $student =
            $this->getStudent();


        /*
        |--------------------------------------------------------------------------
        | TANGGAL HARI INI
        |--------------------------------------------------------------------------
        */

        $today =
            Carbon::now(
                TrainingAttendanceService::TIMEZONE
            )->toDateString();


        /*
        |--------------------------------------------------------------------------
        | SISWA BELUM PUNYA CABANG
        |--------------------------------------------------------------------------
        */

        if (!$student->sport) {

            $sessions =
                collect();


            return view(
                'siswa.training-index',
                compact(
                    'student',
                    'sessions'
                )
            );
        }


        /*
        |--------------------------------------------------------------------------
        | JADWAL SESUAI CABANG SISWA
        |--------------------------------------------------------------------------
        */

        $sessions =
            TrainingSession::query()
                ->with([
                    'attendances' =>
                        function ($query) use (
                            $student
                        ) {

                            $query->where(
                                'student_id',
                                $student->id
                            );
                        },
                ])
                ->where(
                    'sport',
                    $student->sport
                )
                ->whereDate(
                    'training_date',
                    '>=',
                    $today
                )
                ->orderBy(
                    'training_date',
                    'asc'
                )
                ->orderBy(
                    'start_time',
                    'asc'
                )
                ->get();


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'siswa.training-index',
            compact(
                'student',
                'sessions'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | HALAMAN SCANNER LATIHAN
    |--------------------------------------------------------------------------
    */

    public function scanner(
        Request $request
    ): View {

        /*
        |--------------------------------------------------------------------------
        | SISWA LOGIN
        |--------------------------------------------------------------------------
        */

        $student =
            $this->getStudent();


        /*
        |--------------------------------------------------------------------------
        | CABANG BELUM DITENTUKAN
        |--------------------------------------------------------------------------
        */

        abort_if(
            !$student->sport,
            403,
            'Cabang olahraga siswa belum ditentukan.'
        );


        /*
        |--------------------------------------------------------------------------
        | HARUS MEMILIH SESI
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $request->filled(
                'session'
            ),
            404,
            'Sesi latihan tidak ditemukan.'
        );


        /*
        |--------------------------------------------------------------------------
        | AMBIL SESI
        |--------------------------------------------------------------------------
        */

        $trainingSession =
            TrainingSession::findOrFail(
                $request->integer(
                    'session'
                )
            );


        /*
        |--------------------------------------------------------------------------
        | VALIDASI CABANG
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $this->studentCanAccessSession(
                $student,
                $trainingSession
            ),
            403,
            'Kamu tidak terdaftar pada cabang olahraga sesi latihan ini.'
        );


        /*
        |--------------------------------------------------------------------------
        | AMBIL ATURAN WAKTU DARI SERVICE
        |--------------------------------------------------------------------------
        */

        $times =
            $this
                ->trainingAttendanceService
                ->getSessionTimes(
                    $trainingSession
                );


        /*
        |--------------------------------------------------------------------------
        | JADWAL BELUM LENGKAP
        |--------------------------------------------------------------------------
        */

        if (!$times) {

            return redirect()
                ->route(
                    'siswa.training.index'
                )
                ->with(
                    'training_info',
                    'Jadwal latihan belum lengkap.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | WAKTU SEKARANG
        |--------------------------------------------------------------------------
        */

        $now =
            Carbon::now(
                TrainingAttendanceService::TIMEZONE
            );


        /*
        |--------------------------------------------------------------------------
        | PRESENSI BELUM DIMULAI
        |--------------------------------------------------------------------------
        */

        if (
            $now->lt(
                $times['starts_at']
            )
        ) {

            return redirect()
                ->route(
                    'siswa.training.index'
                )
                ->with(
                    'training_info',
                    'Presensi latihan belum dibuka.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | PRESENSI SUDAH DITUTUP
        |--------------------------------------------------------------------------
        |
        | Tepat pada closes_at masih boleh.
        |
        | Contoh:
        |
        | closes_at = 14:30:00
        |
        | 14:30:00 -> masih boleh
        | 14:30:01 -> ditolak
        |
        */

        if (
            $now->gt(
                $times['closes_at']
            )
        ) {

            return redirect()
                ->route(
                    'siswa.training.index'
                )
                ->with(
                    'training_info',
                    'Presensi latihan sudah ditutup karena batas waktu presensi telah berakhir.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | CEK PRESENSI YANG SUDAH ADA
        |--------------------------------------------------------------------------
        */

        $existingAttendance =
            TrainingAttendance::where(
                'training_session_id',
                $trainingSession->id
            )
                ->where(
                    'student_id',
                    $student->id
                )
                ->first();


        /*
        |--------------------------------------------------------------------------
        | SUDAH PUNYA PRESENSI
        |--------------------------------------------------------------------------
        */

        if ($existingAttendance) {

            return redirect()
                ->route(
                    'siswa.training.index'
                )
                ->with(
                    'training_info',
                    'Kamu sudah memiliki data presensi untuk sesi latihan tersebut.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | BUKA SCANNER
        |--------------------------------------------------------------------------
        */

        return view(
            'siswa.training-scan',
            compact(
                'student',
                'trainingSession'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PROSES SCAN QR
    |--------------------------------------------------------------------------
    */

    public function store(
        Request $request
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | VALIDASI REQUEST
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'token' => [
                'required',
                'string',
                'size:64',
            ],

            'training_session_id' => [
                'required',
                'integer',
                'exists:training_sessions,id',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | SISWA LOGIN
        |--------------------------------------------------------------------------
        */

        $student =
            Student::where(
                'user_id',
                auth()->id()
            )->first();


        /*
        |--------------------------------------------------------------------------
        | SISWA TIDAK DITEMUKAN
        |--------------------------------------------------------------------------
        */

        if (!$student) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Data siswa tidak ditemukan.',

            ], 404);
        }


        /*
        |--------------------------------------------------------------------------
        | CABANG BELUM DITENTUKAN
        |--------------------------------------------------------------------------
        */

        if (!$student->sport) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Cabang olahraga kamu belum ditentukan.',

            ], 403);
        }


        /*
        |--------------------------------------------------------------------------
        | WAKTU SEKARANG
        |--------------------------------------------------------------------------
        */

        $now =
            Carbon::now(
                TrainingAttendanceService::TIMEZONE
            );


        /*
        |--------------------------------------------------------------------------
        | TRANSACTION
        |--------------------------------------------------------------------------
        */

        try {

            return DB::transaction(
                function () use (
                    $request,
                    $student,
                    $now
                ) {

                    /*
                    |--------------------------------------------------------------------------
                    | AMBIL DAN KUNCI QR
                    |--------------------------------------------------------------------------
                    |
                    | lockForUpdate digunakan untuk mencegah QR yang sama
                    | berhasil digunakan oleh dua request secara bersamaan.
                    |
                    */

                    $barcode =
                        TrainingBarcode::where(
                            'token',
                            $request->token
                        )
                            ->lockForUpdate()
                            ->first();


                    /*
                    |--------------------------------------------------------------------------
                    | QR TIDAK DITEMUKAN
                    |--------------------------------------------------------------------------
                    */

                    if (!$barcode) {

                        return response()->json([

                            'success' =>
                                false,

                            'message' =>
                                'QR latihan tidak valid.',

                        ], 422);
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | AMBIL SESI DARI QR
                    |--------------------------------------------------------------------------
                    */

                    $session =
                        $barcode
                            ->trainingSession;


                    /*
                    |--------------------------------------------------------------------------
                    | SESI TIDAK DITEMUKAN
                    |--------------------------------------------------------------------------
                    */

                    if (!$session) {

                        return response()->json([

                            'success' =>
                                false,

                            'message' =>
                                'Sesi latihan tidak ditemukan.',

                        ], 404);
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | COCOKKAN SESSION ID
                    |--------------------------------------------------------------------------
                    */

                    if (
                        (int) $request
                            ->training_session_id
                        !==
                        (int) $session->id
                    ) {

                        return response()->json([

                            'success' =>
                                false,

                            'message' =>
                                'QR ini bukan untuk sesi latihan yang kamu pilih.',

                        ], 422);
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | VALIDASI CABANG OLAHRAGA
                    |--------------------------------------------------------------------------
                    */

                    if (
                        !$this->studentCanAccessSession(
                            $student,
                            $session
                        )
                    ) {

                        return response()->json([

                            'success' =>
                                false,

                            'message' =>
                                'QR ini bukan untuk cabang olahraga kamu. Cabang kamu: '
                                . $student->sport
                                . '.',

                        ], 403);
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | AMBIL ATURAN WAKTU DARI SERVICE
                    |--------------------------------------------------------------------------
                    */

                    $times =
                        $this
                            ->trainingAttendanceService
                            ->getSessionTimes(
                                $session
                            );


                    /*
                    |--------------------------------------------------------------------------
                    | JADWAL TIDAK LENGKAP
                    |--------------------------------------------------------------------------
                    */

                    if (!$times) {

                        return response()->json([

                            'success' =>
                                false,

                            'message' =>
                                'Jadwal latihan belum lengkap.',

                        ], 422);
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | BELUM DIMULAI
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $now->lt(
                            $times['starts_at']
                        )
                    ) {

                        return response()->json([

                            'success' =>
                                false,

                            'message' =>
                                'Presensi latihan belum dibuka.',

                        ], 422);
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | SUDAH LEWAT BATAS PRESENSI
                    |--------------------------------------------------------------------------
                    |
                    | Backend tetap melakukan validasi meskipun QR lama
                    | masih tampil pada perangkat siswa.
                    |
                    */

                    if (
                        $now->gt(
                            $times['closes_at']
                        )
                    ) {

                        /*
                        |--------------------------------------------------------------------------
                        | NONAKTIFKAN QR
                        |--------------------------------------------------------------------------
                        */

                        $barcode->update([
                            'is_active' =>
                                false,
                        ]);


                        return response()->json([

                            'success' =>
                                false,

                            'message' =>
                                'Presensi latihan sudah ditutup karena batas waktu presensi telah berakhir.',

                        ], 422);
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | QR SUDAH DIPAKAI
                    |--------------------------------------------------------------------------
                    */

                    if (
                        !$barcode->is_active
                        ||
                        !is_null(
                            $barcode->used_at
                        )
                    ) {

                        return response()->json([

                            'success' =>
                                false,

                            'message' =>
                                'QR ini sudah digunakan. Scan QR terbaru.',

                        ], 422);
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | QR KEDALUWARSA
                    |--------------------------------------------------------------------------
                    */

                    if (
                        !$barcode->expired_at
                        ||
                        $now->gte(
                            $barcode->expired_at
                        )
                    ) {

                        /*
                        |--------------------------------------------------------------------------
                        | NONAKTIFKAN
                        |--------------------------------------------------------------------------
                        */

                        $barcode->update([
                            'is_active' =>
                                false,
                        ]);


                        return response()->json([

                            'success' =>
                                false,

                            'message' =>
                                'QR sudah kedaluwarsa. Scan QR terbaru.',

                        ], 422);
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | CEK PRESENSI YANG SUDAH ADA
                    |--------------------------------------------------------------------------
                    |
                    | Semua status dianggap sudah tercatat:
                    |
                    | present
                    | late
                    | permission
                    | sick
                    | absent
                    |
                    */

                    $existingAttendance =
                        TrainingAttendance::where(
                            'training_session_id',
                            $session->id
                        )
                            ->where(
                                'student_id',
                                $student->id
                            )
                            ->lockForUpdate()
                            ->first();


                    /*
                    |--------------------------------------------------------------------------
                    | SUDAH PUNYA PRESENSI
                    |--------------------------------------------------------------------------
                    */

                    if ($existingAttendance) {

                        /*
                        |--------------------------------------------------------------------------
                        | LABEL STATUS
                        |--------------------------------------------------------------------------
                        */

                        $statusLabel =
                            match (
                                $existingAttendance->status
                            ) {

                                'present' =>
                                    'Hadir',

                                'late' =>
                                    'Terlambat',

                                'permission' =>
                                    'Izin',

                                'sick' =>
                                    'Sakit',

                                'absent' =>
                                    'Alfa',

                                default =>
                                    ucfirst(
                                        $existingAttendance->status
                                    ),
                            };


                        return response()->json([

                            'success' =>
                                false,

                            'message' =>
                                'Kamu sudah memiliki presensi dengan status '
                                . $statusLabel
                                . '.',

                            'attendance' => [

                                'status' =>
                                    $existingAttendance
                                        ->status,

                                'status_label' =>
                                    $statusLabel,

                                'checked_in_at' =>
                                    $existingAttendance
                                        ->checked_in_at
                                        ? $existingAttendance
                                            ->checked_in_at
                                            ->timezone(
                                                TrainingAttendanceService::TIMEZONE
                                            )
                                            ->format(
                                                'H:i:s'
                                            )
                                        : null,

                            ],

                        ], 422);
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | TENTUKAN HADIR / TERLAMBAT
                    |--------------------------------------------------------------------------
                    |
                    | start_time sampai tepat late_limit:
                    |
                    | HADIR
                    |
                    | setelah late_limit sampai closes_at:
                    |
                    | TERLAMBAT
                    |
                    */

                    $status =
                        $now->lte(
                            $times['late_limit']
                        )
                            ? 'present'
                            : 'late';


                    /*
                    |--------------------------------------------------------------------------
                    | SIMPAN PRESENSI
                    |--------------------------------------------------------------------------
                    */

                    $attendance =
                        TrainingAttendance::create([

                            'training_session_id' =>
                                $session->id,

                            'student_id' =>
                                $student->id,

                            'status' =>
                                $status,

                            'checked_in_at' =>
                                $now,

                            'notes' =>
                                'Presensi melalui QR latihan.',

                        ]);


                    /*
                    |--------------------------------------------------------------------------
                    | QR SEKALI PAKAI
                    |--------------------------------------------------------------------------
                    */

                    $barcode->update([

                        'is_active' =>
                            false,

                        'used_by_student_id' =>
                            $student->id,

                        'used_at' =>
                            $now,

                    ]);


                    /*
                    |--------------------------------------------------------------------------
                    | LABEL STATUS
                    |--------------------------------------------------------------------------
                    */

                    $statusLabel =
                        $status === 'present'
                            ? 'Hadir'
                            : 'Terlambat';


                    /*
                    |--------------------------------------------------------------------------
                    | RESPONSE BERHASIL
                    |--------------------------------------------------------------------------
                    */

                    return response()->json([

                        'success' =>
                            true,

                        'message' =>
                            $status === 'present'
                                ? 'Presensi berhasil. Kamu tercatat Hadir.'
                                : 'Presensi berhasil. Kamu tercatat Terlambat.',

                        'attendance' => [

                            'id' =>
                                $attendance->id,

                            'training_session_id' =>
                                $session->id,

                            'status' =>
                                $status,

                            'status_label' =>
                                $statusLabel,

                            'checked_in_at' =>
                                $now->format(
                                    'H:i:s'
                                ),

                            'sport' =>
                                $session->sport,

                            'location' =>
                                $session->location
                                ?? '-',

                            'training_date' =>
                                Carbon::parse(
                                    $session->training_date,
                                    TrainingAttendanceService::TIMEZONE
                                )->format(
                                    'Y-m-d'
                                ),

                            'start_time' =>
                                $times['starts_at']
                                    ->format(
                                        'H:i'
                                    ),

                            'late_limit' =>
                                $times['late_limit']
                                    ->format(
                                        'H:i'
                                    ),

                            'alpha_limit' =>
                                $times['alpha_at']
                                    ->format(
                                        'H:i'
                                    ),

                            'end_time' =>
                                $times['ends_at']
                                    ->format(
                                        'H:i'
                                    ),

                            'closes_at' =>
                                $times['closes_at']
                                    ->format(
                                        'H:i:s'
                                    ),

                        ],

                    ]);
                }
            );

        } catch (\Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | LOG ERROR
            |--------------------------------------------------------------------------
            */

            report(
                $e
            );


            /*
            |--------------------------------------------------------------------------
            | RESPONSE ERROR
            |--------------------------------------------------------------------------
            */

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Terjadi kesalahan saat menyimpan presensi latihan.',

            ], 500);
        }
    }
}