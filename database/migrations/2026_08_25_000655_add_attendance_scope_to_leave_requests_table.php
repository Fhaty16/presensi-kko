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
        Schema::table('leave_requests', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | TUJUAN PENGAJUAN
            |--------------------------------------------------------------------------
            |
            | school   = izin / sakit presensi sekolah
            | training = izin / sakit latihan KKO
            |
            */

            $table
                ->string(
                    'attendance_scope',
                    20
                )
                ->default('school')
                ->after('student_id');


            /*
            |--------------------------------------------------------------------------
            | SESI LATIHAN
            |--------------------------------------------------------------------------
            |
            | Hanya digunakan jika attendance_scope = training.
            |
            | Untuk izin sekolah nilainya NULL.
            |
            */

            $table
                ->foreignId(
                    'training_session_id'
                )
                ->nullable()
                ->after('attendance_scope')
                ->constrained(
                    'training_sessions'
                )
                ->nullOnDelete();


            /*
            |--------------------------------------------------------------------------
            | INDEX
            |--------------------------------------------------------------------------
            */

            $table->index(
                'attendance_scope'
            );
        });
    }


    /*
    |--------------------------------------------------------------------------
    | DOWN
    |--------------------------------------------------------------------------
    */

    public function down(): void
    {
        Schema::table('leave_requests', function (Blueprint $table) {

            $table->dropIndex([
                'attendance_scope',
            ]);

            $table->dropForeign([
                'training_session_id',
            ]);

            $table->dropColumn([
                'attendance_scope',
                'training_session_id',
            ]);
        });
    }
};