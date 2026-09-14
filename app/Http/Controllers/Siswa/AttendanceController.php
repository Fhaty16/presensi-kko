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
        | TIMEZONE
        |--------------------------------------------------------------------------
        */

        $timezone =
            'Asia/Jakarta';


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
                        $timezone
                    )
                        ->toDateString()
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
    | PROSES PRESENSI SEKOLAH
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
        | Format barcode sekolah:
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
        | TOKEN ASLI
        |--------------------------------------------------------------------------
        */

        $token =
            substr(
                $request->token,
                4
            );


        /*
        |--------------------------------------------------------------------------
        | SISWA LOGIN
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
        | PENGATURAN PRESENSI SEKOLAH
        |--------------------------------------------------------------------------
        |
        | Contoh:
        |
        | Jam Mulai   : 06:00
        | Jam Selesai : 07:00
        | Toleransi   : 10 menit
        |
        | Maka:
        |
        | sebelum 06:00     = belum dibuka
        | 06:00 - 07:00     = presensi utama
        | 07:01 - 07:10     = toleransi Hadir
        | mulai 07:11       = ditutup
        |
        | Tidak ada status TERLAMBAT.
        |
        | Selama scanner masih dibuka:
        |
        | status = present / HADIR
        |
        */

        $settings =
            AttendanceSetting::firstOrCreate(
                [],
                [
                    'attendance_start_time' =>
                        '06:00:00',

                    'attendance_end_time' =>
                        '07:00:00',

                    'late_after_minutes' =>
                        10,

                    'cutoff_time' =>
                        '07:11:00',

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
        | VALIDASI KONFIGURASI LOKASI
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
        | TIMEZONE
        |--------------------------------------------------------------------------
        */

        $timezone =
            'Asia/Jakarta';


        /*
        |--------------------------------------------------------------------------
        | WAKTU SEKARANG
        |--------------------------------------------------------------------------
        */

        $now =
            now(
                $timezone
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
                    $settings
                        ->attendance_start_time
                    ??
                    '06:00:00'
                );


        /*
        |--------------------------------------------------------------------------
        | JAM SELESAI PRESENSI
        |--------------------------------------------------------------------------
        */

        $attendanceEnd =
            $now
                ->copy()
                ->setTimeFromTimeString(
                    $settings
                        ->attendance_end_time
                    ??
                    '07:00:00'
                );


        /*
        |--------------------------------------------------------------------------
        | VALIDASI KONFIGURASI WAKTU
        |--------------------------------------------------------------------------
        */

        if (
            $attendanceEnd
                ->lessThanOrEqualTo(
                    $attendanceStart
                )
        ) {

            return response()->json([
                'success' =>
                    false,

                'message' =>
                    'Konfigurasi waktu presensi tidak valid. Jam selesai harus setelah jam mulai.',
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | TOLERANSI HADIR
        |--------------------------------------------------------------------------
        */

        $toleranceMinutes =
            max(
                0,
                (int) (
                    $settings
                        ->late_after_minutes
                    ??
                    0
                )
            );


        /*
        |--------------------------------------------------------------------------
        | BATAS AKHIR TOLERANSI
        |--------------------------------------------------------------------------
        |
        | Contoh:
        |
        | Jam selesai = 07:00
        | Toleransi   = 10
        |
        | 07:10:59 masih dapat presensi.
        |
        */

        $toleranceEndsAt =
            $attendanceEnd
                ->copy()
                ->addMinutes(
                    $toleranceMinutes
                )
                ->endOfMinute();


        /*
        |--------------------------------------------------------------------------
        | MULAI PRESENSI DITUTUP
        |--------------------------------------------------------------------------
        |
        | Contoh:
        |
        | 07:10:59
        | +
        | 1 detik
        |
        | = 07:11:00
        |
        */

        $attendanceClosesAt =
            $toleranceEndsAt
                ->copy()
                ->addSecond();


        /*
        |--------------------------------------------------------------------------
        | BELUM MASUK JAM PRESENSI
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
                    'Presensi belum dibuka. Presensi dapat dilakukan mulai pukul '
                    .
                    $attendanceStart
                        ->format(
                            'H:i'
                        )
                    .
                    ' WIB.',

                'attendance' => [
                    'attendance_start_time' =>
                        $attendanceStart
                            ->format(
                                'H:i'
                            ),

                    'attendance_end_time' =>
                        $attendanceEnd
                            ->format(
                                'H:i'
                            ),

                    'tolerance_minutes' =>
                        $toleranceMinutes,

                    'tolerance_end_time' =>
                        $toleranceEndsAt
                            ->format(
                                'H:i'
                            ),

                    'alpha_start_time' =>
                        $attendanceClosesAt
                            ->format(
                                'H:i'
                            ),

                    'auto_alpha' =>
                        (bool) $settings
                            ->auto_alpha,
                ],
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | PRESENSI SUDAH DITUTUP
        |--------------------------------------------------------------------------
        |
        | Tepat pada attendanceClosesAt scanner sudah ditutup.
        |
        | Contoh:
        |
        | 07:10:59 = masih boleh
        | 07:11:00 = ditolak
        |
        */

        if (
            $now->gte(
                $attendanceClosesAt
            )
        ) {

            $message =
                $settings->auto_alpha
                    ? (
                        'Presensi sudah ditutup. Mulai pukul '
                        .
                        $attendanceClosesAt
                            ->format(
                                'H:i'
                            )
                        .
                        ' WIB siswa yang belum memiliki presensi akan diproses sebagai Alfa otomatis.'
                    )
                    : (
                        'Presensi sudah ditutup mulai pukul '
                        .
                        $attendanceClosesAt
                            ->format(
                                'H:i'
                            )
                        .
                        ' WIB. Auto Alfa sedang dinonaktifkan.'
                    );


            return response()->json([
                'success' =>
                    false,

                'message' =>
                    $message,

                'attendance' => [
                    'attendance_start_time' =>
                        $attendanceStart
                            ->format(
                                'H:i'
                            ),

                    'attendance_end_time' =>
                        $attendanceEnd
                            ->format(
                                'H:i'
                            ),

                    'tolerance_minutes' =>
                        $toleranceMinutes,

                    'tolerance_end_time' =>
                        $toleranceEndsAt
                            ->format(
                                'H:i'
                            ),

                    'alpha_start_time' =>
                        $attendanceClosesAt
                            ->format(
                                'H:i'
                            ),

                    'auto_alpha' =>
                        (bool) $settings
                            ->auto_alpha,
                ],
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | HITUNG JARAK SISWA DENGAN SEKOLAH
        |--------------------------------------------------------------------------
        */

        $distance =
            $this->distanceInMeters(
                (float) $request
                    ->latitude,

                (float) $request
                    ->longitude,

                (float) $settings
                    ->school_latitude,

                (float) $settings
                    ->school_longitude
            );


        /*
        |--------------------------------------------------------------------------
        | RADIUS SEKOLAH
        |--------------------------------------------------------------------------
        */

        $locationRadius =
            max(
                1,
                (int) (
                    $settings
                        ->location_radius_meters
                    ??
                    120
                )
            );


        /*
        |--------------------------------------------------------------------------
        | VALIDASI GEOFENCE
        |--------------------------------------------------------------------------
        */

        if (
            $distance
            >
            $locationRadius
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
                    $locationRadius,
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | ATTENDANCE
        |--------------------------------------------------------------------------
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
                        $now
                    ) {

                        /*
                        |--------------------------------------------------------------------------
                        | CEK PRESENSI HARI INI
                        |--------------------------------------------------------------------------
                        */

                        $alreadyAttendance =
                            Attendance::where(
                                'student_id',
                                $student->id
                            )
                                ->whereDate(
                                    'attendance_date',
                                    $now
                                        ->toDateString()
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
                        | Lock barcode untuk mencegah dua siswa memakai
                        | token yang sama secara bersamaan.
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
                            $barcode
                                ->expired_at
                                ->lte(
                                    $now
                                )
                        ) {

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
                        |
                        | Tidak ada status late untuk scanner sekolah.
                        |
                        | Selama masih berada dalam waktu:
                        |
                        | Jam Mulai
                        | sampai
                        | Akhir Toleransi
                        |
                        | tetap tercatat HADIR.
                        |
                        */

                        $attendance =
                            Attendance::create([
                                'student_id' =>
                                    $student->id,

                                'barcode_id' =>
                                    $barcode->id,

                                'attendance_date' =>
                                    $now
                                        ->toDateString(),

                                'check_in_time' =>
                                    $now
                                        ->format(
                                            'H:i:s'
                                        ),

                                'status' =>
                                    'present',

                                'notes' =>
                                    'Presensi barcode dinamis - Hadir',

                                'wa_sent' =>
                                    false,
                            ]);


                        /*
                        |--------------------------------------------------------------------------
                        | BARCODE ONE TIME USE
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
                        | RETURN
                        |--------------------------------------------------------------------------
                        */

                        return $attendance;
                    }
                );

        } catch (
            \RuntimeException $exception
        ) {

            return response()->json([
                'success' =>
                    false,

                'message' =>
                    $exception
                        ->getMessage(),
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | GENERATE / AMBIL BARCODE SELANJUTNYA
        |--------------------------------------------------------------------------
        */

        $barcodeService
            ->current();


        /*
        |--------------------------------------------------------------------------
        | NOTIFIKASI WHATSAPP
        |--------------------------------------------------------------------------
        |
        | WhatsApp diproses setelah transaction selesai.
        |
        | Jika WhatsApp gagal, presensi tetap berhasil.
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

            } catch (
                \Throwable $exception
            ) {

                Log::error(
                    'Gagal membuat WhatsApp Notification setelah presensi.',
                    [
                        'student_id' =>
                            $student->id,

                        'nis' =>
                            $student->nis,

                        'attendance_id' =>
                            $attendance->id,

                        'error' =>
                            $exception
                                ->getMessage(),
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
                'Presensi berhasil. Kamu tercatat Hadir.',

            'student' =>
                auth()->user()
                    ->name,

            'nis' =>
                $student->nis,

            'time' =>
                $now
                    ->format(
                        'H:i'
                    ),

            'status' =>
                'HADIR',

            /*
            |--------------------------------------------------------------------------
            | DETAIL ATURAN
            |--------------------------------------------------------------------------
            |
            | Data ini dapat digunakan oleh scan.blade.php
            | untuk menampilkan aturan secara dinamis.
            |
            */

            'attendance' => [
                'id' =>
                    $attendance->id,

                'status' =>
                    'present',

                'status_label' =>
                    'Hadir',

                'check_in_time' =>
                    $now
                        ->format(
                            'H:i'
                        ),

                'attendance_start_time' =>
                    $attendanceStart
                        ->format(
                            'H:i'
                        ),

                'attendance_end_time' =>
                    $attendanceEnd
                        ->format(
                            'H:i'
                        ),

                'tolerance_minutes' =>
                    $toleranceMinutes,

                'tolerance_start_time' =>
                    $attendanceEnd
                        ->copy()
                        ->addMinute()
                        ->format(
                            'H:i'
                        ),

                'tolerance_end_time' =>
                    $toleranceEndsAt
                        ->format(
                            'H:i'
                        ),

                'alpha_start_time' =>
                    $attendanceClosesAt
                        ->format(
                            'H:i'
                        ),

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
        | KONVERSI RADIAN
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