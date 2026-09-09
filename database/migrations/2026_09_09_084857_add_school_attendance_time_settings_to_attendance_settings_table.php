<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
    |--------------------------------------------------------------------------
    | UP
    |--------------------------------------------------------------------------
    |
    | Migration ini sudah pernah dijalankan dalam keadaan kosong.
    | Dipertahankan sebagai historical no-op migration.
    |
    */

    public function up(): void
    {
        Schema::table(
            'attendance_settings',
            function (Blueprint $table) {
                //
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DOWN
    |--------------------------------------------------------------------------
    */

    public function down(): void
    {
        Schema::table(
            'attendance_settings',
            function (Blueprint $table) {
                //
            }
        );
    }
};