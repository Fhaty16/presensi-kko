<?php

namespace App\Services;

use App\Models\AttendanceSetting;
use App\Models\Barcode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DynamicBarcodeService
{
    public function current(): Barcode
    {
        return DB::transaction(function () {

            /*
            |--------------------------------------------------------------------------
            | Ambil Setting Presensi
            |--------------------------------------------------------------------------
            */

            $settings = AttendanceSetting::firstOrCreate(
                [],
                [
                    'cutoff_time' => '07:00:00',
                    'auto_alpha' => true,
                    'location_radius_meters' => 150,
                    'barcode_lifetime_seconds' => 60,
                ]
            );


            /*
            |--------------------------------------------------------------------------
            | Lock Setting
            |--------------------------------------------------------------------------
            |
            | Mencegah dua request membuat barcode baru secara bersamaan.
            |
            */

            AttendanceSetting::whereKey($settings->id)
                ->lockForUpdate()
                ->first();


            /*
            |--------------------------------------------------------------------------
            | Cari Barcode Aktif
            |--------------------------------------------------------------------------
            */

            $barcode = Barcode::where('is_active', true)
                ->whereNull('used_at')
                ->where('expired_at', '>', now())
                ->latest('id')
                ->first();


            /*
            |--------------------------------------------------------------------------
            | Kalau masih ada barcode aktif, gunakan itu
            |--------------------------------------------------------------------------
            */

            if ($barcode) {
                return $barcode;
            }


            /*
            |--------------------------------------------------------------------------
            | Matikan Barcode Lama
            |--------------------------------------------------------------------------
            */

            Barcode::where('is_active', true)
                ->update([
                    'is_active' => false,
                ]);


            /*
            |--------------------------------------------------------------------------
            | Buat Barcode Baru
            |--------------------------------------------------------------------------
            |
            | Masa berlaku = 60 detik.
            |
            */

            return Barcode::create([
                'token' => Str::random(64),

                'expired_at' => now()->addSeconds(
                    (int) $settings->barcode_lifetime_seconds
                ),

                'is_active' => true,
            ]);
        });
    }
}