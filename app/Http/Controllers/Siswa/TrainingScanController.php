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
    | AMBIL DATA SISWA LOGIN
    |--------------------------------------------------------------------------
    */

    private function getStudent(): Student
    {
        $student = Student::where(
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
    | JADWAL LATIHAN KKO SISWA
    |--------------------------------------------------------------------------
    |
    | Halaman:
    |
    | /siswa/latihan
    |
    | Menampilkan jadwal latihan mulai hari ini dan seterusnya.
    | Presensi siswa untuk setiap sesi juga ikut dimuat.
    |
    */

    public function index(): View
    {
        $student = $this->getStudent();

        $today = Carbon::now(
            'Asia/Jakarta'
        )->toDateString();

        $sessions = TrainingSession::query()
            ->with([
                'attendances' => function ($query) use ($student) {
                    $query->where(
                        'student_id',
                        $student->id
                    );
                },
            ])
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
    |
    | Scanner dapat dibuka dari salah satu jadwal latihan.
    |
    | Contoh:
    |
    | /siswa/latihan/scan?session=3
    |
    */

    public function scanner(
        Request $request
    ): View {
        $student = $this->getStudent();

        $trainingSession = null;

        if ($request->filled('session')) {
            $trainingSession = TrainingSession::findOrFail(
                $request->integer('session')
            );
        }

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
    | PROSES SCAN QR LATIHAN
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

            /*
            |--------------------------------------------------------------------------
            | SESSION DARI HALAMAN JADWAL
            |--------------------------------------------------------------------------
            |
            | Dibuat nullable dulu agar scanner yang sekarang tetap kompatibel.
            | Setelah view scanner kita perbarui, ID sesi akan ikut dikirim.
            |
            */

            'training_session_id' => [
                'nullable',
                'integer',
                'exists:training_sessions,id',
            ],
        ]);

        $student = Student::where(
            'user_id',
            auth()->id()
        )->first();

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan.',
            ], 404);
        }

        $now = Carbon::now(
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
                    | KUNCI TOKEN QR
                    |--------------------------------------------------------------------------
                    |
                    | Satu token QR hanya boleh berhasil digunakan
                    | oleh satu siswa.
                    |
                    */

                    $barcode = TrainingBarcode::where(
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
                            'success' => false,
                            'message' => 'QR latihan tidak valid.',
                        ], 422);
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | QR SUDAH DIGUNAKAN
                    |--------------------------------------------------------------------------
                    */

                    if (
                        !$barcode->is_active
                        || !is_null($barcode->used_at)
                    ) {
                        return response()->json([
                            'success' => false,
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
                            'is_active' => false,
                        ]);

                        return response()->json([
                            'success' => false,
                            'message' =>
                                'QR sudah kedaluwarsa. Scan QR terbaru.',
                        ], 422);
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | AMBIL SESI DARI QR
                    |--------------------------------------------------------------------------
                    */

                    $session =
                        $barcode->trainingSession;

                    if (!$session) {
                        return response()->json([
                            'success' => false,
                            'message' =>
                                'Sesi latihan tidak ditemukan.',
                        ], 404);
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | COCOKKAN DENGAN SESI YANG DIPILIH SISWA
                    |--------------------------------------------------------------------------
                    |
                    | Jika siswa membuka scanner dari jadwal Basket,
                    | QR Sepak Bola tidak boleh diterima pada halaman tersebut.
                    |
                    */

                    if (
                        $request->filled(
                            'training_session_id'
                        )
                        &&
                        (int) $request->training_session_id
                            !== (int) $session->id
                    ) {
                        return response()->json([
                            'success' => false,
                            'message' =>
                                'QR ini bukan untuk sesi latihan yang kamu pilih.',
                        ], 422);
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | VALIDASI JADWAL SESI
                    |--------------------------------------------------------------------------
                    */

                    if (
                        !$session->training_date
                        || !$session->start_time
                        || !$session->end_time
                    ) {
                        return response()->json([
                            'success' => false,
                            'message' =>
                                'Jadwal latihan belum lengkap.',
                        ], 422);
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | BENTUK TANGGAL & JAM SESI
                    |--------------------------------------------------------------------------
                    */

                    $date = $session
                        ->training_date
                        ->format('Y-m-d');

                    $startTime = Carbon::parse(
                        $session->start_time,
                        'Asia/Jakarta'
                    )->format('H:i:s');

                    $endTime = Carbon::parse(
                        $session->end_time,
                        'Asia/Jakarta'
                    )->format('H:i:s');

                    $startsAt =
                        Carbon::createFromFormat(
                            'Y-m-d H:i:s',
                            $date . ' ' . $startTime,
                            'Asia/Jakarta'
                        );

                    $endsAt =
                        Carbon::createFromFormat(
                            'Y-m-d H:i:s',
                            $date . ' ' . $endTime,
                            'Asia/Jakarta'
                        );

                    /*
                    |--------------------------------------------------------------------------
                    | BELUM DIMULAI
                    |--------------------------------------------------------------------------
                    */

                    if ($now->lt($startsAt)) {
                        return response()->json([
                            'success' => false,
                            'message' =>
                                'Presensi latihan belum dibuka.',
                        ], 422);
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | SUDAH SELESAI
                    |--------------------------------------------------------------------------
                    |
                    | Tepat pada jam selesai masih diperbolehkan.
                    | Setelah jam selesai baru ditutup.
                    |
                    */

                    if ($now->gt($endsAt)) {
                        $barcode->update([
                            'is_active' => false,
                        ]);

                        return response()->json([
                            'success' => false,
                            'message' =>
                                'Presensi latihan sudah ditutup.',
                        ], 422);
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | CEK SUDAH PERNAH PRESENSI
                    |--------------------------------------------------------------------------
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
                        return response()->json([
                            'success' => false,

                            'message' =>
                                'Kamu sudah melakukan presensi untuk sesi latihan ini.',

                            'attendance' => [
                                'status' =>
                                    $existingAttendance->status,

                                'status_label' =>
                                    $existingAttendance->status_label,

                                'checked_in_at' =>
                                    $existingAttendance->checked_in_at
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
                    | BATAS TERLAMBAT
                    |--------------------------------------------------------------------------
                    |
                    | Contoh sesi mulai 19:00:
                    |
                    | 19:00:00 - 19:10:00 = HADIR
                    | 19:10:01 - 20:00:00 = TERLAMBAT
                    |
                    */

                    $lateLimit = $startsAt
                        ->copy()
                        ->addMinutes(10);

                    /*
                    |--------------------------------------------------------------------------
                    | TENTUKAN STATUS
                    |--------------------------------------------------------------------------
                    */

                    $status = $now->lte(
                        $lateLimit
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
                    | MATIKAN QR
                    |--------------------------------------------------------------------------
                    |
                    | Begitu berhasil digunakan:
                    |
                    | is_active = false
                    | used_by_student_id = siswa
                    | used_at = waktu scan
                    |
                    | Halaman QR Guru/Pelatih akan menghasilkan token baru.
                    |
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
                    | RESPONSE BERHASIL
                    |--------------------------------------------------------------------------
                    */

                    return response()->json([
                        'success' => true,

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
                                $session
                                    ->training_date
                                    ->format(
                                        'Y-m-d'
                                    ),

                            'start_time' =>
                                $startsAt->format(
                                    'H:i'
                                ),

                            'late_limit' =>
                                $lateLimit->format(
                                    'H:i'
                                ),

                            'end_time' =>
                                $endsAt->format(
                                    'H:i'
                                ),
                        ],
                    ]);
                }
            );

        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' =>
                    'Terjadi kesalahan saat menyimpan presensi latihan.',
            ], 500);
        }
    }
}