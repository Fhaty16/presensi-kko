<?php

namespace App\Http\Controllers;

use App\Models\AttendanceSetting;
use App\Services\DynamicBarcodeService;

class BarcodeDisplayController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN BARCODE
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $this->authorizeRole();

        return view('barcode.display');
    }


    /*
    |--------------------------------------------------------------------------
    | BARCODE AKTIF SAAT INI
    |--------------------------------------------------------------------------
    */

    public function current(
        DynamicBarcodeService $barcodeService
    ) {

        $this->authorizeRole();


        /*
        |--------------------------------------------------------------------------
        | SETTING PRESENSI
        |--------------------------------------------------------------------------
        |
        | 07:00 masih boleh presensi.
        | Tepat mulai 07:01:00 presensi ditutup.
        |
        */

        $settings = AttendanceSetting::firstOrCreate(
            [],
            [
                'cutoff_time' => '07:01:00',
                'auto_alpha' => true,
                'location_radius_meters' => 120,
                'barcode_lifetime_seconds' => 60,
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | CEK JAM PRESENSI
        |--------------------------------------------------------------------------
        */

        $now = now();

        $cutoff = $now
            ->copy()
            ->setTimeFromTimeString(
                $settings->cutoff_time
            );


        /*
        |--------------------------------------------------------------------------
        | MULAI 07:01 BARCODE DITUTUP
        |--------------------------------------------------------------------------
        */

        if ($now->gte($cutoff)) {

            return response()->json([
                'success' => true,
                'closed' => true,
                'message' => 'Presensi sudah ditutup. Mulai pukul 07:01 WIB siswa yang belum presensi dinyatakan Alfa.',
                'seconds_remaining' => 0,
            ]);

        }


        /*
        |--------------------------------------------------------------------------
        | AMBIL / GENERATE BARCODE AKTIF
        |--------------------------------------------------------------------------
        */

        $barcode = $barcodeService->current();


        /*
        |--------------------------------------------------------------------------
        | HITUNG SISA WAKTU BARCODE
        |--------------------------------------------------------------------------
        */

        $secondsRemaining = (int) ceil(
            $now->diffInSeconds(
                $barcode->expired_at,
                false
            )
        );


        /*
        |--------------------------------------------------------------------------
        | BATASI ANTARA 0 - 60 DETIK
        |--------------------------------------------------------------------------
        */

        $secondsRemaining = max(
            0,
            min(
                60,
                $secondsRemaining
            )
        );


        /*
        |--------------------------------------------------------------------------
        | RESPONSE BARCODE
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' => true,

            'closed' => false,

            'barcode_id' =>
                $barcode->id,

            'payload' =>
                'KKO:' . $barcode->token,

            'expires_at' =>
                $barcode->expired_at->toIso8601String(),

            'seconds_remaining' =>
                $secondsRemaining,

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | HANYA GURU DAN PELATIH
    |--------------------------------------------------------------------------
    */

    private function authorizeRole(): void
    {
        abort_unless(
            auth()->check()
            &&
            in_array(
                auth()->user()->role,
                [
                    'guru',
                    'pelatih',
                ],
                true
            ),
            403
        );
    }
}