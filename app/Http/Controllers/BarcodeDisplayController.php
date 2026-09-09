<?php

namespace App\Http\Controllers;

use App\Models\AttendanceSetting;
use App\Services\DynamicBarcodeService;

class BarcodeDisplayController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN BARCODE PRESENSI SEKOLAH
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI ROLE
        |--------------------------------------------------------------------------
        */

        $this->authorizeRole();


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'barcode.display'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | BARCODE AKTIF SAAT INI
    |--------------------------------------------------------------------------
    */

    public function current(
        DynamicBarcodeService $barcodeService
    ) {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI ROLE
        |--------------------------------------------------------------------------
        */

        $this->authorizeRole();


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
        | TOLERANSI HADIR
        |--------------------------------------------------------------------------
        */

        $lateAfterMinutes =
            max(
                0,
                (int) (
                    $settings->late_after_minutes
                    ?? 10
                )
            );


        /*
        |--------------------------------------------------------------------------
        | BATAS HADIR
        |--------------------------------------------------------------------------
        |
        | Contoh:
        |
        | Jam mulai     : 06:50
        | Toleransi     : 10 menit
        |
        | Batas Hadir   : 07:00
        |
        */

        $lateLimit =
            $attendanceStart
                ->copy()
                ->addMinutes(
                    $lateAfterMinutes
                );


        /*
        |--------------------------------------------------------------------------
        | JAM BATAS PRESENSI / ALFA
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
        | Harus:
        |
        | Jam Mulai
        |     <
        | Batas Hadir
        |     <
        | Jam Batas
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

                'closed' =>
                    true,

                'reason' =>
                    'invalid_settings',

                'message' =>
                    'Pengaturan waktu presensi sekolah tidak valid. Silakan periksa Pengaturan Presensi.',

                'seconds_remaining' =>
                    0,
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
                    true,

                'closed' =>
                    true,

                'reason' =>
                    'not_started',

                'message' =>
                    'Presensi belum dibuka. Presensi mulai pukul '
                    . $attendanceStart->format('H:i')
                    . ' WIB.',

                'seconds_remaining' =>
                    0,

                'attendance_start_time' =>
                    $attendanceStart->format(
                        'H:i'
                    ),

                'late_limit' =>
                    $lateLimit->format(
                        'H:i'
                    ),

                'cutoff_time' =>
                    $cutoff->format(
                        'H:i'
                    ),

                'auto_alpha' =>
                    (bool) $settings->auto_alpha,
            ]);
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

            /*
            |--------------------------------------------------------------------------
            | PESAN SESUAI AUTO ALFA
            |--------------------------------------------------------------------------
            */

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
                    true,

                'closed' =>
                    true,

                'reason' =>
                    'cutoff',

                'message' =>
                    $message,

                'seconds_remaining' =>
                    0,

                'attendance_start_time' =>
                    $attendanceStart->format(
                        'H:i'
                    ),

                'late_limit' =>
                    $lateLimit->format(
                        'H:i'
                    ),

                'cutoff_time' =>
                    $cutoff->format(
                        'H:i'
                    ),

                'auto_alpha' =>
                    (bool) $settings->auto_alpha,
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | AMBIL / GENERATE BARCODE AKTIF
        |--------------------------------------------------------------------------
        */

        $barcode =
            $barcodeService
                ->current();


        /*
        |--------------------------------------------------------------------------
        | HITUNG SISA WAKTU BARCODE
        |--------------------------------------------------------------------------
        */

        $secondsRemaining =
            (int) ceil(
                $now->diffInSeconds(
                    $barcode->expired_at,
                    false
                )
            );


        /*
        |--------------------------------------------------------------------------
        | LIFETIME BARCODE
        |--------------------------------------------------------------------------
        */

        $barcodeLifetime =
            max(
                1,
                (int) (
                    $settings->barcode_lifetime_seconds
                    ?? 60
                )
            );


        /*
        |--------------------------------------------------------------------------
        | BATASI SISA WAKTU
        |--------------------------------------------------------------------------
        */

        $secondsRemaining =
            max(
                0,
                min(
                    $barcodeLifetime,
                    $secondsRemaining
                )
            );


        /*
        |--------------------------------------------------------------------------
        | STATUS PERIODE PRESENSI
        |--------------------------------------------------------------------------
        */

        $attendancePeriod =
            $now->lte(
                $lateLimit
            )
                ? 'present'
                : 'late';


        /*
        |--------------------------------------------------------------------------
        | LABEL PERIODE
        |--------------------------------------------------------------------------
        */

        $attendancePeriodLabel =
            $attendancePeriod === 'present'
                ? 'HADIR'
                : 'TERLAMBAT';


        /*
        |--------------------------------------------------------------------------
        | RESPONSE BARCODE
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' =>
                true,

            'closed' =>
                false,

            'reason' =>
                null,

            'barcode_id' =>
                $barcode->id,

            'payload' =>
                'KKO:'
                . $barcode->token,

            'expires_at' =>
                $barcode
                    ->expired_at
                    ->toIso8601String(),

            'seconds_remaining' =>
                $secondsRemaining,

            /*
            |--------------------------------------------------------------------------
            | INFORMASI PENGATURAN
            |--------------------------------------------------------------------------
            */

            'attendance_start_time' =>
                $attendanceStart
                    ->format(
                        'H:i'
                    ),

            'late_limit' =>
                $lateLimit
                    ->format(
                        'H:i'
                    ),

            'cutoff_time' =>
                $cutoff
                    ->format(
                        'H:i'
                    ),

            'late_after_minutes' =>
                $lateAfterMinutes,

            'auto_alpha' =>
                (bool) $settings->auto_alpha,

            /*
            |--------------------------------------------------------------------------
            | PERIODE SEKARANG
            |--------------------------------------------------------------------------
            */

            'attendance_period' =>
                $attendancePeriod,

            'attendance_period_label' =>
                $attendancePeriodLabel,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | HANYA GURU
    |--------------------------------------------------------------------------
    |
    | Barcode presensi sekolah hanya boleh ditampilkan Guru.
    |
    | Siswa:
    | - hanya melakukan scan.
    |
    | Pelatih:
    | - tidak memiliki akses ke barcode sekolah.
    |
    */

    private function authorizeRole(): void
    {
        abort_unless(
            auth()->check()
            &&
            auth()->user()->role
                === 'guru',
            403
        );
    }
}