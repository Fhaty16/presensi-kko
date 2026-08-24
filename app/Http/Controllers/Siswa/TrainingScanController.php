<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\TrainingAttendance;
use App\Models\TrainingBarcode;
use App\Models\TrainingSession;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TrainingScanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | KONFIGURASI PRESENSI
    |--------------------------------------------------------------------------
    */

    private const LATE_LIMIT_MINUTES = 10;

    private const ABSENT_LIMIT_MINUTES = 30;


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
    | BENTUK WAKTU SESI
    |--------------------------------------------------------------------------
    */

    private function getSessionTimes(
        TrainingSession $trainingSession
    ): ?array {
        if (
            !$trainingSession->training_date
            || !$trainingSession->start_time
            || !$trainingSession->end_time
        ) {
            return null;
        }


        $timezone =
            'Asia/Jakarta';


        $date =
            Carbon::parse(
                $trainingSession->training_date,
                $timezone
            )->format(
                'Y-m-d'
            );


        $startTime =
            Carbon::parse(
                $trainingSession->start_time,
                $timezone
            )->format(
                'H:i:s'
            );


        $endTime =
            Carbon::parse(
                $trainingSession->end_time,
                $timezone
            )->format(
                'H:i:s'
            );


        $startsAt =
            Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $date . ' ' . $startTime,
                $timezone
            );


        $endsAt =
            Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $date . ' ' . $endTime,
                $timezone
            );


        /*
        |--------------------------------------------------------------------------
        | BATAS HADIR
        |--------------------------------------------------------------------------
        */

        $lateLimit =
            $startsAt
                ->copy()
                ->addMinutes(
                    self::LATE_LIMIT_MINUTES
                );


        /*
        |--------------------------------------------------------------------------
        | BATAS ALFA
        |--------------------------------------------------------------------------
        */

        $alphaAt =
            $startsAt
                ->copy()
                ->addMinutes(
                    self::ABSENT_LIMIT_MINUTES
                );


        /*
        |--------------------------------------------------------------------------
        | BATAS AKHIR SCANNER
        |--------------------------------------------------------------------------
        |
        | Jika jam selesai lebih cepat dari +30 menit,
        | gunakan jam selesai.
        |
        */

        $closesAt =
            $endsAt->lt($alphaAt)
                ? $endsAt->copy()
                : $alphaAt->copy();


        return [
            'starts_at' =>
                $startsAt,

            'late_limit' =>
                $lateLimit,

            'alpha_at' =>
                $alphaAt,

            'ends_at' =>
                $endsAt,

            'closes_at' =>
                $closesAt,
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | JADWAL LATIHAN SISWA
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        $student =
            $this->getStudent();


        $today =
            Carbon::now(
                'Asia/Jakarta'
            )->toDateString();


        /*
        |--------------------------------------------------------------------------
        | BELUM PUNYA CABANG
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
        $student =
            $this->getStudent();


        /*
        |--------------------------------------------------------------------------
        | BELUM PUNYA CABANG
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
            $request->filled('session'),
            404,
            'Sesi latihan tidak ditemukan.'
        );


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
        | VALIDASI JADWAL
        |--------------------------------------------------------------------------
        */

        $times =
            $this->getSessionTimes(
                $trainingSession
            );


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


        $now =
            Carbon::now(
                'Asia/Jakarta'
            );


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
        | SUDAH LEWAT BATAS PRESENSI
        |--------------------------------------------------------------------------
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
                    'Presensi latihan sudah ditutup. Batas presensi adalah 30 menit setelah latihan dimulai.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | CEK SUDAH PUNYA PRESENSI
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


        $now =
            Carbon::now(
                'Asia/Jakarta'
            );


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
                    | AMBIL SESI QR
                    |--------------------------------------------------------------------------
                    */

                    $session =
                        $barcode
                            ->trainingSession;


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
                    | COCOKKAN SESI
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
                    | VALIDASI CABANG
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
                    | VALIDASI JADWAL
                    |--------------------------------------------------------------------------
                    */

                    $times =
                        $this->getSessionTimes(
                            $session
                        );


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
                    | LEWAT BATAS +30 MENIT
                    |--------------------------------------------------------------------------
                    |
                    | Ini proteksi utama backend.
                    |
                    | Walaupun QR lama masih berada di layar siswa,
                    | request tetap ditolak.
                    |
                    */

                    if (
                        $now->gt(
                            $times['closes_at']
                        )
                    ) {

                        $barcode->update([
                            'is_active' =>
                                false,
                        ]);


                        return response()->json([
                            'success' =>
                                false,

                            'message' =>
                                'Presensi latihan sudah ditutup. Kamu sudah melewati batas presensi 30 menit.',
                        ], 422);
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | QR SUDAH DIPAKAI
                    |--------------------------------------------------------------------------
                    */

                    if (
                        !$barcode->is_active
                        || !is_null(
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
                        || $now->gte(
                            $barcode->expired_at
                        )
                    ) {

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
                    | Termasuk:
                    |
                    | Hadir
                    | Terlambat
                    | Izin
                    | Sakit
                    | Alfa
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


                    if ($existingAttendance) {

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
                                                'Asia/Jakarta'
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
                    | Mulai sampai tepat +10 menit:
                    |
                    | HADIR
                    |
                    | Setelah +10 menit sampai tepat +30 menit:
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
                    | RESPONSE
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
                                $status === 'present'
                                    ? 'Hadir'
                                    : 'Terlambat',

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
                                    $session->training_date
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

                        ],

                    ]);
                }
            );

        } catch (\Throwable $e) {

            report($e);


            return response()->json([
                'success' =>
                    false,

                'message' =>
                    'Terjadi kesalahan saat menyimpan presensi latihan.',
            ], 500);
        }
    }
}