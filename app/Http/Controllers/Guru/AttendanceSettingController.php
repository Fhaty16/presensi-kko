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
    | UPDATE PENGATURAN PRESENSI SEKOLAH
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $validated =
            $request->validate([
                'attendance_start_time' => [
                    'required',
                    'date_format:H:i',
                ],

                'late_after_minutes' => [
                    'required',
                    'integer',
                    'min:0',
                    'max:180',
                ],

                'cutoff_time' => [
                    'required',
                    'date_format:H:i',
                ],

                'auto_alpha' => [
                    'required',
                    'boolean',
                ],
            ]);


        /*
        |--------------------------------------------------------------------------
        | JAM MULAI
        |--------------------------------------------------------------------------
        */

        $startAt =
            Carbon::createFromFormat(
                'H:i',
                $validated[
                    'attendance_start_time'
                ],
                'Asia/Jakarta'
            )
                ->setSecond(0);


        /*
        |--------------------------------------------------------------------------
        | JAM MULAI TERLAMBAT
        |--------------------------------------------------------------------------
        */

        $lateAt =
            $startAt
                ->copy()
                ->addMinutes(
                    (int) $validated[
                        'late_after_minutes'
                    ]
                );


        /*
        |--------------------------------------------------------------------------
        | JAM BATAS ALFA
        |--------------------------------------------------------------------------
        */

        $cutoffAt =
            Carbon::createFromFormat(
                'H:i',
                $validated[
                    'cutoff_time'
                ],
                'Asia/Jakarta'
            )
                ->setSecond(0);


        /*
        |--------------------------------------------------------------------------
        | VALIDASI URUTAN WAKTU
        |--------------------------------------------------------------------------
        */

        if (
            !$cutoffAt->gt(
                $startAt
            )
        ) {
            throw ValidationException::withMessages([
                'cutoff_time' =>
                    'Jam batas Alfa harus setelah jam mulai presensi.',
            ]);
        }


        if (
            !$lateAt->lt(
                $cutoffAt
            )
        ) {
            throw ValidationException::withMessages([
                'late_after_minutes' =>
                    'Toleransi Hadir terlalu panjang. Waktu mulai Terlambat harus sebelum Jam Batas Alfa.',
            ]);
        }


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
        | SIMPAN
        |--------------------------------------------------------------------------
        */

        $settings->update([
            'attendance_start_time' =>
                $startAt->format(
                    'H:i:s'
                ),

            'late_after_minutes' =>
                (int) $validated[
                    'late_after_minutes'
                ],

            'cutoff_time' =>
                $cutoffAt->format(
                    'H:i:s'
                ),

            'auto_alpha' =>
                (bool) $validated[
                    'auto_alpha'
                ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | KEMBALI
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'guru.dashboard'
            )
            ->with(
                'success',
                'Pengaturan presensi sekolah berhasil diperbarui.'
            );
    }
}