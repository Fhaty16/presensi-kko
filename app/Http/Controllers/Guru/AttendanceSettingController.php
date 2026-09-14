<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\AttendanceSetting;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AttendanceSettingController extends Controller
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
    | UPDATE PENGATURAN PRESENSI
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | VALIDASI INPUT
        |--------------------------------------------------------------------------
        */

        $validated =
            $request->validate([
                'attendance_start_time' => [
                    'required',
                    'date_format:H:i',
                ],

                'attendance_end_time' => [
                    'required',
                    'date_format:H:i',
                ],

                'late_after_minutes' => [
                    'required',
                    'integer',
                    'min:0',
                    'max:180',
                ],

                'auto_alpha' => [
                    'required',
                    'boolean',
                ],
            ]);


        /*
        |--------------------------------------------------------------------------
        | TANGGAL ACUAN
        |--------------------------------------------------------------------------
        */

        $today =
            Carbon::now(
                self::TIMEZONE
            )
                ->toDateString();


        /*
        |--------------------------------------------------------------------------
        | JAM MULAI
        |--------------------------------------------------------------------------
        */

        $attendanceStart =
            Carbon::createFromFormat(
                'Y-m-d H:i',
                $today
                .
                ' '
                .
                $validated[
                    'attendance_start_time'
                ],
                self::TIMEZONE
            );


        /*
        |--------------------------------------------------------------------------
        | JAM SELESAI
        |--------------------------------------------------------------------------
        */

        $attendanceEnd =
            Carbon::createFromFormat(
                'Y-m-d H:i',
                $today
                .
                ' '
                .
                $validated[
                    'attendance_end_time'
                ],
                self::TIMEZONE
            );


        /*
        |--------------------------------------------------------------------------
        | VALIDASI JAM SELESAI
        |--------------------------------------------------------------------------
        |
        | Contoh valid:
        |
        | Mulai   : 06:00
        | Selesai : 07:00
        |
        | Contoh tidak valid:
        |
        | Mulai   : 07:00
        | Selesai : 06:00
        |
        */

        if (
            $attendanceEnd
                ->lessThanOrEqualTo(
                    $attendanceStart
                )
        ) {

            throw ValidationException::withMessages([
                'attendance_end_time' =>
                    'Jam selesai presensi harus setelah jam mulai presensi.',
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | TOLERANSI
        |--------------------------------------------------------------------------
        */

        $toleranceMinutes =
            max(
                0,
                (int) $validated[
                    'late_after_minutes'
                ]
            );


        /*
        |--------------------------------------------------------------------------
        | BATAS AKHIR TOLERANSI
        |--------------------------------------------------------------------------
        |
        | Contoh:
        |
        | Jam selesai : 07:00
        | Toleransi   : 10 menit
        |
        | Presensi utama:
        |
        | 06:00 - 07:00:59
        |
        | Toleransi:
        |
        | 07:01 - 07:10:59
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
        | JAM MULAI DITUTUP / ALFA
        |--------------------------------------------------------------------------
        |
        | 07:10:59
        | +
        | 1 detik
        |
        | =
        |
        | 07:11:00
        |
        */

        $cutoff =
            $toleranceEndsAt
                ->copy()
                ->addSecond();


        /*
        |--------------------------------------------------------------------------
        | AMBIL SETTING
        |--------------------------------------------------------------------------
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
        | SIMPAN SETTING
        |--------------------------------------------------------------------------
        |
        | cutoff_time tetap kita simpan.
        |
        | Tujuannya:
        |
        | - kompatibel dengan fitur lama
        | - scheduler
        | - WhatsApp
        | - Auto Alfa
        |
        | Tetapi cutoff_time TIDAK lagi diinput manual Guru.
        |
        | cutoff_time dihitung otomatis:
        |
        | Jam Selesai + Toleransi + 1 menit
        |
        */

        $settings->update([
            'attendance_start_time' =>
                $attendanceStart
                    ->format(
                        'H:i:s'
                    ),

            'attendance_end_time' =>
                $attendanceEnd
                    ->format(
                        'H:i:s'
                    ),

            'late_after_minutes' =>
                $toleranceMinutes,

            'cutoff_time' =>
                $cutoff
                    ->format(
                        'H:i:s'
                    ),

            'auto_alpha' =>
                (bool) $validated[
                    'auto_alpha'
                ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'guru.dashboard'
            )
            ->with(
                'success',
                'Pengaturan presensi berhasil diperbarui.'
            );
    }
}