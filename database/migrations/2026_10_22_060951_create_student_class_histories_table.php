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
    | Menyimpan riwayat kelas setiap siswa.
    |
    | Contoh:
    |
    | 2026/2027 -> X KKO
    | 2027/2028 -> XI KKO
    | 2028/2029 -> XII KKO
    |
    | students.class_id tetap digunakan sebagai kelas AKTIF siswa saat ini.
    |
    */

    public function up(): void
    {
        Schema::create(
            'student_class_histories',
            function (Blueprint $table) {

                $table->id();


                /*
                |--------------------------------------------------------------------------
                | SISWA
                |--------------------------------------------------------------------------
                */

                $table
                    ->foreignId('student_id')
                    ->constrained('students')
                    ->cascadeOnDelete();


                /*
                |--------------------------------------------------------------------------
                | KELAS
                |--------------------------------------------------------------------------
                */

                $table
                    ->foreignId('class_id')
                    ->constrained('classes')
                    ->restrictOnDelete();


                /*
                |--------------------------------------------------------------------------
                | TAHUN AJARAN
                |--------------------------------------------------------------------------
                |
                | Contoh:
                |
                | 2026/2027
                | 2027/2028
                |
                */

                $table
                    ->string(
                        'academic_year',
                        20
                    )
                    ->index();


                /*
                |--------------------------------------------------------------------------
                | TANGGAL MULAI
                |--------------------------------------------------------------------------
                |
                | Tanggal siswa mulai berada di kelas tersebut.
                |
                */

                $table
                    ->date('start_date')
                    ->nullable();


                /*
                |--------------------------------------------------------------------------
                | TANGGAL SELESAI
                |--------------------------------------------------------------------------
                |
                | Null berarti riwayat tersebut masih aktif.
                |
                */

                $table
                    ->date('end_date')
                    ->nullable();


                /*
                |--------------------------------------------------------------------------
                | STATUS KELAS SAAT INI
                |--------------------------------------------------------------------------
                |
                | Hanya satu riwayat per siswa yang seharusnya aktif.
                |
                */

                $table
                    ->boolean('is_current')
                    ->default(true)
                    ->index();


                /*
                |--------------------------------------------------------------------------
                | CATATAN
                |--------------------------------------------------------------------------
                |
                | Contoh:
                |
                | - Siswa baru
                | - Naik kelas
                | - Pindah kelas
                | - Koreksi data
                |
                */

                $table
                    ->string(
                        'notes',
                        255
                    )
                    ->nullable();


                /*
                |--------------------------------------------------------------------------
                | TIMESTAMP
                |--------------------------------------------------------------------------
                */

                $table->timestamps();


                /*
                |--------------------------------------------------------------------------
                | INDEX
                |--------------------------------------------------------------------------
                */

                $table->index([
                    'student_id',
                    'academic_year',
                ]);

                $table->index([
                    'class_id',
                    'academic_year',
                ]);

                $table->index([
                    'student_id',
                    'is_current',
                ]);
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
        Schema::dropIfExists(
            'student_class_histories'
        );
    }
};