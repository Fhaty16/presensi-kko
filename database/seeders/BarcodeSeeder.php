<?php

namespace Database\Seeders;

use App\Models\Barcode;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BarcodeSeeder extends Seeder
{
    public function run(): void
    {
        Barcode::create([
            'token' => Str::random(40),
            'expired_at' => null,
            'is_active' => true,
        ]);
    }
}