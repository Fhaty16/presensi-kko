<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_schedules', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | KELAS
            |--------------------------------------------------------------------------
            */
            $table
                ->foreignId('class_id')
                ->constrained('classes')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | MATA PELAJARAN
            |--------------------------------------------------------------------------
            |
            | Nullable karena baris Istirahat / ISHOMA tidak memiliki
            | mata pelajaran.
            |
            */
            $table
                ->foreignId('subject_id')
                ->nullable()
                ->constrained('subjects')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | HARI
            |--------------------------------------------------------------------------
            |
            | 1 = Senin
            | 2 = Selasa
            | 3 = Rabu
            | 4 = Kamis
            | 5 = Jumat
            |
            */
            $table
                ->unsignedTinyInteger('day_of_week');

            /*
            |--------------------------------------------------------------------------
            | TIPE JADWAL
            |--------------------------------------------------------------------------
            */
            $table
                ->enum(
                    'schedule_type',
                    [
                        'lesson',
                        'break',
                        'activity',
                    ]
                )
                ->default('lesson');

            /*
            |--------------------------------------------------------------------------
            | LABEL
            |--------------------------------------------------------------------------
            |
            | Digunakan untuk:
            |
            | Istirahat
            | ISHOMA
            | Upacara
            | kegiatan khusus
            |
            */
            $table
                ->string('label', 100)
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | WAKTU
            |--------------------------------------------------------------------------
            */
            $table->time('start_time');

            $table->time('end_time');

            /*
            |--------------------------------------------------------------------------
            | GURU
            |--------------------------------------------------------------------------
            |
            | Sementara nullable.
            |
            | Nanti Guru/Admin dapat mengisi nama guru pengampu
            | dari halaman Kelola Jadwal.
            |
            */
            $table
                ->string('teacher_name', 100)
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | RUANG
            |--------------------------------------------------------------------------
            */
            $table
                ->string('room', 100)
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */
            $table
                ->boolean('status')
                ->default(true);

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | CEGAH SLOT DUPLIKAT
            |--------------------------------------------------------------------------
            */
            $table->unique(
                [
                    'class_id',
                    'day_of_week',
                    'start_time',
                    'end_time',
                ],
                'school_schedule_unique_slot'
            );

            $table->index(
                [
                    'class_id',
                    'day_of_week',
                    'status',
                ],
                'school_schedule_lookup_index'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_schedules');
    }
};