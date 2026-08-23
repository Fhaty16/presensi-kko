<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_sessions', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | INFORMASI LATIHAN
            |--------------------------------------------------------------------------
            */

            $table->date('training_date');

            $table->string('sport');

            $table->string('location')->nullable();

            $table->time('start_time')->nullable();

            $table->time('end_time')->nullable();

            $table->text('notes')->nullable();


            /*
            |--------------------------------------------------------------------------
            | PEMBUAT SESI
            |--------------------------------------------------------------------------
            |
            | Bisa Guru maupun Pelatih.
            |
            */

            $table->foreignId('created_by')
                ->constrained('users')
                ->cascadeOnDelete();


            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('training_sessions');
    }
};