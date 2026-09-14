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
                | JAM SELESAI PRESENSI
                |--------------------------------------------------------------------------
                |
                | Contoh pengaturan:
                |
                | Jam Mulai Presensi   : 06:00
                | Jam Selesai Presensi : 07:00
                | Toleransi Hadir      : 10 menit
                |
                | Maka:
                |
                | 06:00 - 07:00 = waktu presensi utama
                | 07:01 - 07:10 = masih diperbolehkan karena toleransi
                | mulai 07:11   = presensi ditutup
                |
                | Jika Auto Alfa aktif:
                | siswa yang belum memiliki presensi mulai 07:11
                | akan diproses sebagai Alfa.
                |
                */

                $table
                    ->time(
                        'attendance_end_time'
                    )
                    ->default(
                        '07:00:00'
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

                $table->dropColumn(
                    'attendance_end_time'
                );
            }
        );
    }
};