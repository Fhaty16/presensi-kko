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
        Schema::create('whatsapp_notifications', function (Blueprint $table) {
            $table->id();


            /*
            |--------------------------------------------------------------------------
            | RELASI SISWA
            |--------------------------------------------------------------------------
            */

            $table->foreignId('student_id')
                ->constrained('students')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | RELASI PRESENSI SEKOLAH
            |--------------------------------------------------------------------------
            |
            | Nullable agar tabel ini tetap fleksibel jika nantinya
            | digunakan untuk jenis pemberitahuan lain.
            |
            */

            $table->foreignId('attendance_id')
                ->nullable()
                ->constrained('attendances')
                ->nullOnDelete();


            /*
            |--------------------------------------------------------------------------
            | EVENT KEY
            |--------------------------------------------------------------------------
            |
            | Kunci unik untuk mencegah pesan yang sama dikirim dua kali.
            |
            | Contoh:
            |
            | school_attendance:15:present
            | school_attendance:20:late
            | school_attendance:31:absent
            |
            */

            $table->string('event_key', 191)
                ->unique();


            /*
            |--------------------------------------------------------------------------
            | JENIS NOTIFIKASI
            |--------------------------------------------------------------------------
            */

            $table->enum('notification_type', [
                'check_in',
                'absent',
                'correction',
            ]);


            /*
            |--------------------------------------------------------------------------
            | STATUS PRESENSI
            |--------------------------------------------------------------------------
            |
            | Mengikuti status presensi yang memicu pesan.
            |
            */

            $table->string('attendance_status', 50)
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | NOMOR TUJUAN
            |--------------------------------------------------------------------------
            |
            | Nomor disimpan juga di log agar riwayat tetap diketahui,
            | walaupun parent_phone siswa suatu saat berubah.
            |
            */

            $table->string('recipient_phone', 30);


            /*
            |--------------------------------------------------------------------------
            | PESAN
            |--------------------------------------------------------------------------
            */

            $table->text('message');


            /*
            |--------------------------------------------------------------------------
            | STATUS PENGIRIMAN
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'pending',
                'processing',
                'sent',
                'failed',
                'skipped',
            ])
                ->default('pending');


            /*
            |--------------------------------------------------------------------------
            | PROVIDER
            |--------------------------------------------------------------------------
            |
            | Nanti diisi ID pesan yang dikembalikan WhatsApp API.
            |
            */

            $table->string('provider_message_id')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | ERROR
            |--------------------------------------------------------------------------
            */

            $table->text('error_message')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | JUMLAH PERCOBAAN
            |--------------------------------------------------------------------------
            */

            $table->unsignedInteger('attempts')
                ->default(0);


            /*
            |--------------------------------------------------------------------------
            | WAKTU TERKIRIM
            |--------------------------------------------------------------------------
            */

            $table->timestamp('sent_at')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | LAST ATTEMPT
            |--------------------------------------------------------------------------
            */

            $table->timestamp('last_attempt_at')
                ->nullable();


            $table->timestamps();


            /*
            |--------------------------------------------------------------------------
            | INDEX
            |--------------------------------------------------------------------------
            */

            $table->index([
                'student_id',
                'status',
            ]);

            $table->index([
                'notification_type',
                'status',
            ]);

            $table->index([
                'attendance_id',
                'notification_type',
            ]);
        });
    }


    /*
    |--------------------------------------------------------------------------
    | DOWN
    |--------------------------------------------------------------------------
    */

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_notifications');
    }
};