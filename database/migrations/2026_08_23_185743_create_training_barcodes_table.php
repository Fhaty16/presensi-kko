<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_barcodes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('training_session_id')
                ->constrained('training_sessions')
                ->cascadeOnDelete();

            $table->string('token', 64)
                ->unique();

            $table->dateTime('expired_at');

            $table->boolean('is_active')
                ->default(true);

            $table->foreignId('used_by_student_id')
                ->nullable()
                ->constrained('students')
                ->nullOnDelete();

            $table->dateTime('used_at')
                ->nullable();

            $table->timestamps();

            $table->index([
                'training_session_id',
                'is_active',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_barcodes');
    }
};