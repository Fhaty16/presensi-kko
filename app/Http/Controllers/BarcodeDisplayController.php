<?php

namespace App\Http\Controllers;

use App\Models\AttendanceSetting;
use App\Models\Barcode;
use App\Services\DynamicBarcodeService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class BarcodeDisplayController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | TIMEZONE
    |--------------------------------------------------------------------------
    */

    private const TIMEZONE =
        'Asia/Jakarta';


    /*
    |--------------------------------------------------------------------------
    | HALAMAN BARCODE PRESENSI SEKOLAH
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        /*
        |--------------------------------------------------------------------------
        | HANYA GURU
        |--------------------------------------------------------------------------
        */

        $this->authorizeGuru();


        /*
        |--------------------------------------------------------------------------
        | SETTING
        |--------------------------------------------------------------------------
        */

        $settings =
            $this->getSettings();


        /*
        |--------------------------------------------------------------------------
        | WAKTU
        |--------------------------------------------------------------------------
        */

        $times =
            $this->getAttendanceTimes(
                $settings
            );


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'barcode.display',
            [
                'attendanceStartDisplay' =>
                    $times[
                        'starts_at'
                    ]
                        ->format(
                            'H:i'
                        ),

                'attendanceEndDisplay' =>
                    $times[
                        'ends_at'
                    ]
                        ->format(
                            'H:i'
                        ),

                'toleranceMinutes' =>
                    $times[
                        'tolerance_minutes'
                    ],

                'toleranceEndDisplay' =>
                    $times[
                        'tolerance_ends_at'
                    ]
                        ->format(
                            'H:i'
                        ),

                'attendanceCloseDisplay' =>
                    $times[
                        'closes_at'
                    ]
                        ->format(
                            'H:i'
                        ),

                'autoAlphaEnabled' =>
                    (bool) $settings
                        ->auto_alpha,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | BARCODE SEKOLAH AKTIF
    |--------------------------------------------------------------------------
    |
    | Endpoint ini dipanggil berkala oleh JavaScript halaman barcode.
    |
    | Status response:
    |
    | not_started = belum masuk Jam Mulai
    | active      = barcode dapat digunakan
    | ended       = toleransi sudah selesai
    |
    */

    public function current(
        DynamicBarcodeService $barcodeService
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | HANYA GURU
        |--------------------------------------------------------------------------
        */

        $this->authorizeGuru();


        /*
        |--------------------------------------------------------------------------
        | SETTING
        |--------------------------------------------------------------------------
        */

        $settings =
            $this->getSettings();


        /*
        |--------------------------------------------------------------------------
        | HITUNG WAKTU
        |--------------------------------------------------------------------------
        */

        $times =
            $this->getAttendanceTimes(
                $settings
            );


        $now =
            Carbon::now(
                self::TIMEZONE
            );


        /*
        |--------------------------------------------------------------------------
        | BELUM DIMULAI
        |--------------------------------------------------------------------------
        |
        | Jangan menampilkan QR sebelum Jam Mulai Presensi.
        |
        */

        if (
            $now->lt(
                $times[
                    'starts_at'
                ]
            )
        ) {

            /*
            |--------------------------------------------------------------------------
            | NONAKTIFKAN QR LAMA
            |--------------------------------------------------------------------------
            */

            $this->deactivateActiveBarcodes();


            return response()->json([
                'status' =>
                    'not_started',

                'message' =>
                    'Presensi sekolah belum dibuka. Barcode akan aktif mulai pukul '
                    .
                    $times[
                        'starts_at'
                    ]
                        ->format(
                            'H:i'
                        )
                    .
                    ' WIB.',

                'attendance_start_time' =>
                    $times[
                        'starts_at'
                    ]
                        ->format(
                            'H:i'
                        ),

                'attendance_end_time' =>
                    $times[
                        'ends_at'
                    ]
                        ->format(
                            'H:i'
                        ),

                'tolerance_minutes' =>
                    $times[
                        'tolerance_minutes'
                    ],

                'tolerance_end_time' =>
                    $times[
                        'tolerance_ends_at'
                    ]
                        ->format(
                            'H:i'
                        ),

                'closes_at' =>
                    $times[
                        'closes_at'
                    ]
                        ->format(
                            'H:i'
                        ),

                'auto_alpha' =>
                    (bool) $settings
                        ->auto_alpha,
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | PRESENSI SUDAH DITUTUP
        |--------------------------------------------------------------------------
        |
        | Contoh:
        |
        | Selesai   : 07:00
        | Toleransi : 10 menit
        |
        | 07:10:59 = masih aktif
        | 07:11:00 = ditutup
        |
        */

        if (
            $now->gte(
                $times[
                    'closes_at'
                ]
            )
        ) {

            /*
            |--------------------------------------------------------------------------
            | MATIKAN SEMUA BARCODE AKTIF
            |--------------------------------------------------------------------------
            */

            $this->deactivateActiveBarcodes();


            $message =
                $settings->auto_alpha
                    ? (
                        'Presensi sekolah ditutup mulai pukul '
                        .
                        $times[
                            'closes_at'
                        ]
                            ->format(
                                'H:i'
                            )
                        .
                        ' WIB. Siswa yang belum memiliki presensi akan diproses sebagai Alfa otomatis.'
                    )
                    : (
                        'Presensi sekolah ditutup mulai pukul '
                        .
                        $times[
                            'closes_at'
                        ]
                            ->format(
                                'H:i'
                            )
                        .
                        ' WIB. Auto Alfa sedang dinonaktifkan.'
                    );


            return response()->json([
                'status' =>
                    'ended',

                'message' =>
                    $message,

                'attendance_start_time' =>
                    $times[
                        'starts_at'
                    ]
                        ->format(
                            'H:i'
                        ),

                'attendance_end_time' =>
                    $times[
                        'ends_at'
                    ]
                        ->format(
                            'H:i'
                        ),

                'tolerance_minutes' =>
                    $times[
                        'tolerance_minutes'
                    ],

                'tolerance_end_time' =>
                    $times[
                        'tolerance_ends_at'
                    ]
                        ->format(
                            'H:i'
                        ),

                'closes_at' =>
                    $times[
                        'closes_at'
                    ]
                        ->format(
                            'H:i'
                        ),

                'auto_alpha' =>
                    (bool) $settings
                        ->auto_alpha,
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | AMBIL / BUAT BARCODE AKTIF
        |--------------------------------------------------------------------------
        */

        $barcode =
            $barcodeService
                ->current();


        /*
        |--------------------------------------------------------------------------
        | SERVICE TIDAK MENGEMBALIKAN BARCODE
        |--------------------------------------------------------------------------
        */

        if (
            !$barcode
        ) {

            return response()->json([
                'status' =>
                    'unavailable',

                'message' =>
                    'Barcode belum tersedia. Silakan tunggu beberapa saat.',
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | SUPPORT RETURN MODEL / ARRAY
        |--------------------------------------------------------------------------
        |
        | Bagian ini dibuat aman jika DynamicBarcodeService::current()
        | mengembalikan Model Barcode atau array.
        |
        */

        if (
            is_array(
                $barcode
            )
        ) {

            $rawToken =
                $barcode[
                    'token'
                ]
                ??
                null;


            $expiredAtRaw =
                $barcode[
                    'expired_at'
                ]
                ??
                null;


            $barcodeId =
                $barcode[
                    'id'
                ]
                ??
                $barcode[
                    'barcode_id'
                ]
                ??
                null;

        } else {

            $rawToken =
                $barcode
                    ->token
                ??
                null;


            $expiredAtRaw =
                $barcode
                    ->expired_at
                ??
                null;


            $barcodeId =
                $barcode
                    ->id
                ??
                null;
        }


        /*
        |--------------------------------------------------------------------------
        | TOKEN TIDAK VALID
        |--------------------------------------------------------------------------
        */

        if (
            blank(
                $rawToken
            )
        ) {

            return response()->json([
                'status' =>
                    'unavailable',

                'message' =>
                    'Token barcode tidak tersedia.',
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | EXPIRED AT
        |--------------------------------------------------------------------------
        */

        $expiredAt =
            $expiredAtRaw
                ? Carbon::parse(
                    $expiredAtRaw,
                    self::TIMEZONE
                )
                : $now
                    ->copy()
                    ->addSeconds(
                        max(
                            1,
                            (int) (
                                $settings
                                    ->barcode_lifetime_seconds
                                ??
                                60
                            )
                        )
                    );


        /*
        |--------------------------------------------------------------------------
        | QR TIDAK BOLEH MELEWATI WAKTU PENUTUPAN
        |--------------------------------------------------------------------------
        |
        | Misalnya sekarang 07:10:45 dan QR normal berlaku 60 detik.
        |
        | QR tidak boleh aktif sampai 07:11:45.
        |
        | QR harus berakhir tepat maksimal 07:11:00.
        |
        */

        if (
            $expiredAt->gt(
                $times[
                    'closes_at'
                ]
            )
        ) {

            $expiredAt =
                $times[
                    'closes_at'
                ]
                    ->copy();


            /*
            |--------------------------------------------------------------------------
            | UPDATE MODEL BARCODE
            |--------------------------------------------------------------------------
            */

            if (
                !is_array(
                    $barcode
                )
                &&
                method_exists(
                    $barcode,
                    'update'
                )
            ) {

                $barcode->update([
                    'expired_at' =>
                        $expiredAt,
                ]);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | PENGAMAN JIKA QR SUDAH TIDAK PUNYA WAKTU
        |--------------------------------------------------------------------------
        */

        if (
            $expiredAt->lte(
                $now
            )
        ) {

            $this->deactivateActiveBarcodes();


            return response()->json([
                'status' =>
                    'ended',

                'message' =>
                    'Presensi sekolah sudah ditutup.',
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | SISA WAKTU BARCODE
        |--------------------------------------------------------------------------
        */

        $secondsRemaining =
            (int) max(
                0,
                $now->diffInSeconds(
                    $expiredAt,
                    false
                )
            );


        /*
        |--------------------------------------------------------------------------
        | PERIODE SEKARANG
        |--------------------------------------------------------------------------
        |
        | Seluruh periode tetap menghasilkan status HADIR.
        |
        | Kita hanya membedakan label UI:
        |
        | main      = Jam Mulai sampai Jam Selesai
        | tolerance = setelah Jam Selesai sampai batas toleransi
        |
        */

        $attendancePeriod =
            $now->lte(
                $times[
                    'ends_at'
                ]
                    ->copy()
                    ->endOfMinute()
            )
                ? 'main'
                : 'tolerance';


        /*
        |--------------------------------------------------------------------------
        | RESPONSE ACTIVE
        |--------------------------------------------------------------------------
        |
        | AttendanceController membutuhkan prefix KKO:
        |
        */

        return response()->json([
            'status' =>
                'active',

            'token' =>
                'KKO:'
                .
                $rawToken,

            'barcode_id' =>
                $barcodeId,

            'expired_at' =>
                $expiredAt
                    ->toIso8601String(),

            'seconds_remaining' =>
                $secondsRemaining,

            /*
            |--------------------------------------------------------------------------
            | ATURAN PRESENSI
            |--------------------------------------------------------------------------
            */

            'attendance_period' =>
                $attendancePeriod,

            'attendance_period_label' =>
                $attendancePeriod === 'main'
                    ? 'WAKTU PRESENSI'
                    : 'TOLERANSI HADIR',

            'attendance_start_time' =>
                $times[
                    'starts_at'
                ]
                    ->format(
                        'H:i'
                    ),

            'attendance_end_time' =>
                $times[
                    'ends_at'
                ]
                    ->format(
                        'H:i'
                    ),

            'tolerance_minutes' =>
                $times[
                    'tolerance_minutes'
                ],

            'tolerance_start_time' =>
                $times[
                    'tolerance_starts_at'
                ]
                    ->format(
                        'H:i'
                    ),

            'tolerance_end_time' =>
                $times[
                    'tolerance_ends_at'
                ]
                    ->format(
                        'H:i'
                    ),

            'closes_at' =>
                $times[
                    'closes_at'
                ]
                    ->format(
                        'H:i'
                    ),

            'auto_alpha' =>
                (bool) $settings
                    ->auto_alpha,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | AMBIL SETTING
    |--------------------------------------------------------------------------
    */

    private function getSettings(): AttendanceSetting
    {
        return AttendanceSetting::firstOrCreate(
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
    }


    /*
    |--------------------------------------------------------------------------
    | HITUNG SEMUA WAKTU PRESENSI
    |--------------------------------------------------------------------------
    */

    private function getAttendanceTimes(
        AttendanceSetting $settings
    ): array {

        $now =
            Carbon::now(
                self::TIMEZONE
            );


        /*
        |--------------------------------------------------------------------------
        | JAM MULAI
        |--------------------------------------------------------------------------
        */

        $startsAt =
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
        | JAM SELESAI
        |--------------------------------------------------------------------------
        */

        $endsAt =
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
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        if (
            $endsAt->lte(
                $startsAt
            )
        ) {

            /*
            |--------------------------------------------------------------------------
            | FALLBACK AMAN
            |--------------------------------------------------------------------------
            */

            $endsAt =
                $startsAt
                    ->copy()
                    ->addHour();
        }


        /*
        |--------------------------------------------------------------------------
        | TOLERANSI
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
        | MULAI TOLERANSI
        |--------------------------------------------------------------------------
        */

        $toleranceStartsAt =
            $endsAt
                ->copy()
                ->addMinute()
                ->startOfMinute();


        /*
        |--------------------------------------------------------------------------
        | AKHIR TOLERANSI
        |--------------------------------------------------------------------------
        |
        | Contoh:
        |
        | selesai 07:00
        | toleransi 10
        |
        | akhir = 07:10:59
        |
        */

        $toleranceEndsAt =
            $endsAt
                ->copy()
                ->addMinutes(
                    $toleranceMinutes
                )
                ->endOfMinute();


        /*
        |--------------------------------------------------------------------------
        | MULAI DITUTUP
        |--------------------------------------------------------------------------
        */

        $closesAt =
            $toleranceEndsAt
                ->copy()
                ->addSecond();


        /*
        |--------------------------------------------------------------------------
        | RETURN
        |--------------------------------------------------------------------------
        */

        return [
            'starts_at' =>
                $startsAt,

            'ends_at' =>
                $endsAt,

            'tolerance_minutes' =>
                $toleranceMinutes,

            'tolerance_starts_at' =>
                $toleranceStartsAt,

            'tolerance_ends_at' =>
                $toleranceEndsAt,

            'closes_at' =>
                $closesAt,
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | MATIKAN BARCODE AKTIF
    |--------------------------------------------------------------------------
    */

    private function deactivateActiveBarcodes(): void
    {
        Barcode::query()
            ->where(
                'is_active',
                true
            )
            ->update([
                'is_active' =>
                    false,
            ]);
    }


    /*
    |--------------------------------------------------------------------------
    | HAK AKSES
    |--------------------------------------------------------------------------
    |
    | Barcode sekolah hanya boleh ditampilkan Guru.
    |
    */

    private function authorizeGuru(): void
    {
        if (
            !auth()->check()
            ||
            auth()->user()->role
            !==
            'guru'
        ) {

            abort(
                403,
                'Hanya Guru yang dapat menampilkan barcode presensi sekolah.'
            );
        }
    }
}