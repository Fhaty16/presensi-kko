<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')
                ->constrained('students')
                ->cascadeOnDelete();

            $table->foreignId('barcode_id')
                ->nullable()
                ->constrained('barcodes')
                ->nullOnDelete();

            $table->date('attendance_date');

            $table->time('check_in_time')->nullable();

            $table->enum('status', [
                'present',
                'late',
                'permission',
                'sick',
                'absent',
            ]);

            $table->text('notes')->nullable();

            $table->boolean('wa_sent')->default(false);

            $table->timestamps();

            $table->unique([
                'student_id',
                'attendance_date',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};