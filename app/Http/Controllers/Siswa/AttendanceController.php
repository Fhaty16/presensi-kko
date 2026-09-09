<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceSetting;
use App\Models\Barcode;
use App\Models\Student;
use App\Services\DynamicBarcodeService;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN SCANNER SISWA
    |--------------------------------------------------------------------------
    */

    public function scanner()
    {
        /*
        |--------------------------------------------------------------------------
        | AMBIL SISWA LOGIN
        |--------------------------------------------------------------------------
        */

        $student =
            Student::where(
                'user_id',
                auth()->id()
            )
                ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | PRESENSI HARI INI
        |--------------------------------------------------------------------------
        */

        $todayAttendance =
            Attendance::where(
                'student_id',
                $student->id
            )
                ->whereDate(
                    'attendance_date',
                    now(
                        'Asia/Jakarta'
                    )->toDateString()
                )
                ->first();


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'siswa.scan',
            compact(
                'student',
                'todayAttendance'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PROSES PRESENSI
    |--------------------------------------------------------------------------
    */

    public function store(
        Request $request,
        DynamicBarcodeService $barcodeService,
        WhatsAppService $whatsAppService
    ) {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI REQUEST
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'token' => [
                'required',
                'string',
                'max:255',
            ],

            'latitude' => [
                'required',
                'numeric',
                'between:-90,90',
            ],

            'longitude' => [
                'required',
                'numeric',
                'between:-180,180',
            ],

            'accuracy' => [
                'nullable',
                'numeric',
                'min:0',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | VALIDASI PREFIX QR
        |--------------------------------------------------------------------------
        |
        | Semua QR presensi sekolah KKO harus memiliki format:
        |
        | KKO:TOKEN
        |
        */

        if (
            !str_starts_with(
                $request->token,
                'KKO:'
            )
        ) {
            return response()->json([
                'success' =>
                    false,

                'message' =>
                    'Barcode tidak dikenali.',
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | AMBIL TOKEN ASLI
        |--------------------------------------------------------------------------
        */

        $token =
            substr(
                $request->token,
                4
            );


        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA SISWA LOGIN
        |--------------------------------------------------------------------------
        */

        $student =
            Student::where(
                'user_id',
                auth()->id()
            )
                ->where(
                    'status',
                    'active'
                )
                ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | SETTING PRESENSI
        |--------------------------------------------------------------------------
        */

        $settings =
            AttendanceSetting::firstOrCreate(
                [],
                [
                    'attendance_start_time' =>
                        '06:50:00',

                    'late_after_minutes' =>
                        10,

                    'cutoff_time' =>
                        '07:01:00',

                    'auto_alpha' =>
                        true,

                    'location_radius_meters' =>
                        120,

                    'barcode_lifetime_seconds' =>
                        60,
                ]
            );


        /*
        |--------------------------------------------------------------------------
        | VALIDASI KONFIGURASI LOKASI SEKOLAH
        |--------------------------------------------------------------------------
        */

        if (
            $settings->school_latitude === null
            ||
            $settings->school_longitude === null
        ) {
            return response()->json([
                'success' =>
                    false,

                'message' =>
                    'Lokasi sekolah belum dikonfigurasi oleh admin.',
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | WAKTU SEKARANG
        |--------------------------------------------------------------------------
        */

        $now =
            now(
                'Asia/Jakarta'
            );


        /*
        |--------------------------------------------------------------------------
        | JAM MULAI PRESENSI
        |--------------------------------------------------------------------------
        */

        $attendanceStart =
            $now
                ->copy()
                ->setTimeFromTimeString(
                    $settings->attendance_start_time
                    ?? '06:50:00'
                );


        /*
        |--------------------------------------------------------------------------
        | BATAS HADIR
        |--------------------------------------------------------------------------
        |
        | Contoh:
        |
        | Jam mulai       : 06:50
        | Toleransi       : 10 menit
        |
        | 06:50:00        : Hadir
        | 07:00:00        : masih Hadir
        | 07:00:01        : Terlambat
        |
        */

        $lateLimit =
            $attendanceStart
                ->copy()
                ->addMinutes(
                    (int) (
                        $settings->late_after_minutes
                        ?? 10
                    )
                );


        /*
        |--------------------------------------------------------------------------
        | JAM BATAS ALFA / PENUTUPAN PRESENSI
        |--------------------------------------------------------------------------
        */

        $cutoff =
            $now
                ->copy()
                ->setTimeFromTimeString(
                    $settings->cutoff_time
                    ?? '07:01:00'
                );


        /*
        |--------------------------------------------------------------------------
        | VALIDASI KONFIGURASI WAKTU
        |--------------------------------------------------------------------------
        |
        | Urutan harus:
        |
        | Jam Mulai
        |     ↓
        | Batas Hadir
        |     ↓
        | Jam Batas Alfa
        |
        */

        if (
            !$cutoff->gt(
                $attendanceStart
            )
            ||
            !$lateLimit->lt(
                $cutoff
            )
        ) {
            return response()->json([
                'success' =>
                    false,

                'message' =>
                    'Pengaturan waktu presensi sekolah tidak valid. Hubungi Guru KKO.',
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | PRESENSI BELUM DIBUKA
        |--------------------------------------------------------------------------
        */

        if (
            $now->lt(
                $attendanceStart
            )
        ) {
            return response()->json([
                'success' =>
                    false,

                'message' =>
                    'Presensi belum dibuka. Presensi mulai pukul '
                    . $attendanceStart->format('H:i')
                    . ' WIB.',
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | PRESENSI SUDAH DITUTUP
        |--------------------------------------------------------------------------
        */

        if (
            $now->gte(
                $cutoff
            )
        ) {
            $message =
                $settings->auto_alpha
                    ? 'Presensi sudah ditutup. Mulai pukul '
                        . $cutoff->format('H:i')
                        . ' WIB siswa yang belum memiliki presensi diproses sebagai Alfa otomatis.'
                    : 'Presensi sudah ditutup pada pukul '
                        . $cutoff->format('H:i')
                        . ' WIB. Auto Alfa sedang dinonaktifkan.';


            return response()->json([
                'success' =>
                    false,

                'message' =>
                    $message,
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | TENTUKAN HADIR / TERLAMBAT
        |--------------------------------------------------------------------------
        |
        | Tepat pada batas toleransi masih Hadir.
        |
        | Setelah melewati batas toleransi menjadi Terlambat.
        |
        */

        $status =
            $now->lte(
                $lateLimit
            )
                ? 'present'
                : 'late';


        /*
        |--------------------------------------------------------------------------
        | HITUNG JARAK SISWA DENGAN SEKOLAH
        |--------------------------------------------------------------------------
        */

        $distance =
            $this->distanceInMeters(
                (float) $request->latitude,

                (float) $request->longitude,

                (float) $settings->school_latitude,

                (float) $settings->school_longitude
            );


        /*
        |--------------------------------------------------------------------------
        | VALIDASI GEOFENCE
        |--------------------------------------------------------------------------
        */

        if (
            $distance
            >
            $settings->location_radius_meters
        ) {
            return response()->json([
                'success' =>
                    false,

                'message' =>
                    'Presensi hanya dapat dilakukan di lingkungan SMA Negeri 2 Cilacap.',

                'distance' =>
                    round(
                        $distance
                    ),

                'radius' =>
                    $settings->location_radius_meters,

            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | VARIABLE ATTENDANCE
        |--------------------------------------------------------------------------
        |
        | Setelah transaction berhasil, object Attendance
        | akan disimpan di variable ini.
        |
        */

        $attendance =
            null;


        /*
        |--------------------------------------------------------------------------
        | DATABASE TRANSACTION
        |--------------------------------------------------------------------------
        */

        try {

            $attendance =
                DB::transaction(
                    function () use (
                        $student,
                        $token,
                        $now,
                        $status
                    ) {

                        /*
                        |--------------------------------------------------------------------------
                        | CEK SUDAH PRESENSI
                        |--------------------------------------------------------------------------
                        */

                        $alreadyAttendance =
                            Attendance::where(
                                'student_id',
                                $student->id
                            )
                                ->whereDate(
                                    'attendance_date',
                                    $now->toDateString()
                                )
                                ->lockForUpdate()
                                ->exists();


                        if (
                            $alreadyAttendance
                        ) {
                            throw new \RuntimeException(
                                'Kamu sudah melakukan presensi hari ini.'
                            );
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | AMBIL BARCODE
                        |--------------------------------------------------------------------------
                        |
                        | Barcode dikunci agar tidak dapat digunakan
                        | dua siswa secara bersamaan.
                        |
                        */

                        $barcode =
                            Barcode::where(
                                'token',
                                $token
                            )
                                ->lockForUpdate()
                                ->first();


                        /*
                        |--------------------------------------------------------------------------
                        | BARCODE TIDAK DITEMUKAN
                        |--------------------------------------------------------------------------
                        */

                        if (
                            !$barcode
                        ) {
                            throw new \RuntimeException(
                                'Barcode tidak ditemukan.'
                            );
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | BARCODE TIDAK AKTIF
                        |--------------------------------------------------------------------------
                        */

                        if (
                            !$barcode->is_active
                        ) {
                            throw new \RuntimeException(
                                'Barcode sudah digunakan. Silakan scan barcode terbaru.'
                            );
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | BARCODE SUDAH DIGUNAKAN
                        |--------------------------------------------------------------------------
                        */

                        if (
                            $barcode->used_at !== null
                        ) {
                            throw new \RuntimeException(
                                'Barcode sudah digunakan oleh siswa lain.'
                            );
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | BARCODE KEDALUWARSA
                        |--------------------------------------------------------------------------
                        */

                        if (
                            !$barcode->expired_at
                            ||
                            $barcode->expired_at->lte(
                                $now
                            )
                        ) {

                            /*
                            |--------------------------------------------------------------------------
                            | MATIKAN BARCODE
                            |--------------------------------------------------------------------------
                            */

                            $barcode->update([
                                'is_active' =>
                                    false,
                            ]);


                            throw new \RuntimeException(
                                'Barcode sudah kedaluwarsa. Silakan scan barcode terbaru.'
                            );
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | SIMPAN PRESENSI
                        |--------------------------------------------------------------------------
                        */

                        $attendance =
                            Attendance::create([
                                'student_id' =>
                                    $student->id,

                                'barcode_id' =>
                                    $barcode->id,

                                'attendance_date' =>
                                    $now->toDateString(),

                                'check_in_time' =>
                                    $now->format(
                                        'H:i:s'
                                    ),

                                'status' =>
                                    $status,

                                'notes' =>
                                    $status === 'present'
                                        ? 'Presensi barcode dinamis - Hadir'
                                        : 'Presensi barcode dinamis - Terlambat',

                                /*
                                |--------------------------------------------------------------------------
                                | WA BELUM TERKIRIM
                                |--------------------------------------------------------------------------
                                */

                                'wa_sent' =>
                                    false,
                            ]);


                        /*
                        |--------------------------------------------------------------------------
                        | MATIKAN BARCODE
                        |--------------------------------------------------------------------------
                        |
                        | Barcode hanya boleh digunakan satu kali.
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
                        | RETURN ATTENDANCE
                        |--------------------------------------------------------------------------
                        |
                        | Object ini dibawa keluar dari transaction
                        | untuk membuat WhatsApp Notification.
                        |
                        */

                        return $attendance;
                    }
                );

        } catch (\RuntimeException $e) {

            /*
            |--------------------------------------------------------------------------
            | ERROR PRESENSI
            |--------------------------------------------------------------------------
            */

            return response()->json([
                'success' =>
                    false,

                'message' =>
                    $e->getMessage(),
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | GENERATE BARCODE BERIKUTNYA
        |--------------------------------------------------------------------------
        |
        | Presensi sudah COMMIT pada tahap ini.
        |
        */

        $barcodeService
            ->current();


        /*
        |--------------------------------------------------------------------------
        | BUAT NOTIFIKASI WHATSAPP
        |--------------------------------------------------------------------------
        |
        | PENTING:
        |
        | Method ini dijalankan SETELAH transaction presensi selesai.
        |
        | Jadi:
        |
        | - Presensi tidak bergantung pada WhatsApp.
        | - Jika WhatsApp error, presensi tetap berhasil.
        |
        */

        if (
            $attendance
        ) {
            try {

                $whatsAppService
                    ->createAttendanceNotification(
                        $student,
                        $attendance
                    );

            } catch (\Throwable $e) {

                /*
                |--------------------------------------------------------------------------
                | JANGAN GAGALKAN PRESENSI
                |--------------------------------------------------------------------------
                */

                Log::error(
                    'Gagal membuat WhatsApp Notification setelah presensi.',
                    [
                        'student_id' =>
                            $student->id,

                        'nis' =>
                            $student->nis,

                        'attendance_id' =>
                            $attendance->id,

                        'attendance_status' =>
                            $attendance->status,

                        'error' =>
                            $e->getMessage(),
                    ]
                );
            }
        }


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

            'student' =>
                auth()->user()->name,

            'nis' =>
                $student->nis,

            'time' =>
                $now->format(
                    'H:i'
                ),

            'status' =>
                $status === 'present'
                    ? 'HADIR'
                    : 'TERLAMBAT',

            'attendance' => [
                'id' =>
                    $attendance->id,

                'status' =>
                    $status,

                'status_label' =>
                    $status === 'present'
                        ? 'Hadir'
                        : 'Terlambat',

                'attendance_start_time' =>
                    $attendanceStart
                        ->format('H:i'),

                'late_limit' =>
                    $lateLimit
                        ->format('H:i'),

                'cutoff_time' =>
                    $cutoff
                        ->format('H:i'),

                'auto_alpha' =>
                    (bool) $settings
                        ->auto_alpha,
            ],
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | HITUNG JARAK GPS - HAVERSINE
    |--------------------------------------------------------------------------
    */

    private function distanceInMeters(
        float $lat1,
        float $lon1,
        float $lat2,
        float $lon2
    ): float {

        /*
        |--------------------------------------------------------------------------
        | RADIUS BUMI
        |--------------------------------------------------------------------------
        */

        $earthRadius =
            6371000;


        /*
        |--------------------------------------------------------------------------
        | KONVERSI KE RADIAN
        |--------------------------------------------------------------------------
        */

        $latFrom =
            deg2rad(
                $lat1
            );


        $lonFrom =
            deg2rad(
                $lon1
            );


        $latTo =
            deg2rad(
                $lat2
            );


        $lonTo =
            deg2rad(
                $lon2
            );


        /*
        |--------------------------------------------------------------------------
        | SELISIH
        |--------------------------------------------------------------------------
        */

        $latDelta =
            $latTo
            -
            $latFrom;


        $lonDelta =
            $lonTo
            -
            $lonFrom;


        /*
        |--------------------------------------------------------------------------
        | HAVERSINE
        |--------------------------------------------------------------------------
        */

        $a =
            sin(
                $latDelta
                /
                2
            ) ** 2

            +

            cos(
                $latFrom
            )

            *

            cos(
                $latTo
            )

            *

            sin(
                $lonDelta
                /
                2
            ) ** 2;


        $c =
            2

            *

            atan2(
                sqrt(
                    $a
                ),

                sqrt(
                    1
                    -
                    $a
                )
            );


        /*
        |--------------------------------------------------------------------------
        | HASIL METER
        |--------------------------------------------------------------------------
        */

        return
            $earthRadius
            *
            $c;
    }
}