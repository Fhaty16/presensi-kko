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
    */

    public function up(): void
    {
        Schema::table(
            'attendance_settings',
            function (Blueprint $table) {

                /*
                |--------------------------------------------------------------------------
                | JAM MULAI PRESENSI
                |--------------------------------------------------------------------------
                |
                | Default:
                |
                | 06:50 WIB
                |
                */

                $table
                    ->time(
                        'attendance_start_time'
                    )
                    ->default(
                        '06:50:00'
                    )
                    ->after(
                        'auto_alpha'
                    );


                /*
                |--------------------------------------------------------------------------
                | TOLERANSI HADIR
                |--------------------------------------------------------------------------
                |
                | Contoh:
                |
                | Jam mulai         : 06:50
                | Toleransi hadir   : 10 menit
                |
                | 06:50:00 - 07:00:00 = Hadir
                | setelah 07:00:00     = Terlambat
                |
                */

                $table
                    ->unsignedSmallInteger(
                        'late_after_minutes'
                    )
                    ->default(
                        10
                    )
                    ->after(
                        'attendance_start_time'
                    );
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

                $table->dropColumn([
                    'attendance_start_time',
                    'late_after_minutes',
                ]);
            }
        );
    }
};