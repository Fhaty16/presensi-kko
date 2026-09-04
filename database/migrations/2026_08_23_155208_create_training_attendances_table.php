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
        Schema::create(
            'training_attendances',
            function (Blueprint $table) {

                $table->id();


                /*
                |--------------------------------------------------------------------------
                | SESI LATIHAN
                |--------------------------------------------------------------------------
                */

                $table
                    ->foreignId(
                        'training_session_id'
                    )
                    ->constrained(
                        'training_sessions'
                    )
                    ->cascadeOnDelete();


                /*
                |--------------------------------------------------------------------------
                | SISWA
                |--------------------------------------------------------------------------
                */

                $table
                    ->foreignId(
                        'student_id'
                    )
                    ->constrained(
                        'students'
                    )
                    ->cascadeOnDelete();


                /*
                |--------------------------------------------------------------------------
                | STATUS KEHADIRAN
                |--------------------------------------------------------------------------
                |
                | Status:
                |
                | present     = Hadir
                | late        = Terlambat
                | permission  = Izin
                | sick        = Sakit
                | absent      = Alfa
                |
                | late dimasukkan langsung ke migration awal agar fresh migration
                | MySQL maupun SQLite memiliki struktur status yang lengkap.
                |
                */

                $table->enum(
                    'status',
                    [
                        'present',
                        'late',
                        'permission',
                        'sick',
                        'absent',
                    ]
                );


                /*
                |--------------------------------------------------------------------------
                | WAKTU CHECK-IN
                |--------------------------------------------------------------------------
                |
                | Jika kolom ini memang sudah ditambahkan melalui migration lain,
                | JANGAN tambahkan di sini.
                |
                */


                /*
                |--------------------------------------------------------------------------
                | CATATAN
                |--------------------------------------------------------------------------
                */

                $table
                    ->text(
                        'notes'
                    )
                    ->nullable();


                /*
                |--------------------------------------------------------------------------
                | TIMESTAMPS
                |--------------------------------------------------------------------------
                */

                $table->timestamps();


                /*
                |--------------------------------------------------------------------------
                | SATU SISWA HANYA SEKALI PER SESI
                |--------------------------------------------------------------------------
                */

                $table->unique([
                    'training_session_id',
                    'student_id',
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
            'training_attendances'
        );
    }
};