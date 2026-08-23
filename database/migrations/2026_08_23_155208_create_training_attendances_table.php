<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_attendances', function (Blueprint $table) {

            $table->id();


            /*
            |--------------------------------------------------------------------------
            | SESI LATIHAN
            |--------------------------------------------------------------------------
            */

            $table->foreignId('training_session_id')
                ->constrained('training_sessions')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | SISWA
            |--------------------------------------------------------------------------
            */

            $table->foreignId('student_id')
                ->constrained('students')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | STATUS KEHADIRAN
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'present',
                'permission',
                'sick',
                'absent',
            ]);


            /*
            |--------------------------------------------------------------------------
            | CATATAN
            |--------------------------------------------------------------------------
            */

            $table->text('notes')->nullable();


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

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('training_attendances');
    }
};