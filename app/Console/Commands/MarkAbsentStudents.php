<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Models\AttendanceSetting;
use App\Models\Student;
use App\Services\WhatsAppService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class MarkAbsentStudents extends Command
{
    /*
    |--------------------------------------------------------------------------
    | NAMA COMMAND
    |--------------------------------------------------------------------------
    */

    protected $signature = 'attendance:mark-absent';


    /*
    |--------------------------------------------------------------------------
    | DESKRIPSI
    |--------------------------------------------------------------------------
    */

    protected $description =
        'Menandai siswa yang belum presensi sebagai Alfa setiap Senin sampai Jumat setelah pukul 07:01 WIB';


    /*
    |--------------------------------------------------------------------------
    | HANDLE
    |--------------------------------------------------------------------------
    */

    public function handle(
        WhatsAppService $whatsAppService
    ): int {
        /*
        |--------------------------------------------------------------------------
        | AMBIL SETTING PRESENSI
        |--------------------------------------------------------------------------
        */

        $settings =
            AttendanceSetting::first();


        if (
            !$settings
        ) {
            $this->error(
                'Setting presensi belum tersedia.'
            );

            return self::FAILURE;
        }


        /*
        |--------------------------------------------------------------------------
        | CEK AUTO ALFA
        |--------------------------------------------------------------------------
        */

        if (
            !$settings->auto_alpha
        ) {
            $this->info(
                'Auto Alfa sedang dinonaktifkan.'
            );

            return self::SUCCESS;
        }


        /*
        |--------------------------------------------------------------------------
        | WAKTU SEKARANG
        |--------------------------------------------------------------------------
        */

        $now =
            now(
                'Asia/Jakarta'
            );


        /*
        |--------------------------------------------------------------------------
        | HANYA SENIN - JUMAT
        |--------------------------------------------------------------------------
        */

        if (
            !$now->isWeekday()
        ) {
            $this->info(
                'Hari ini Sabtu/Minggu. Auto Alfa tidak dijalankan.'
            );

            return self::SUCCESS;
        }


        /*
        |--------------------------------------------------------------------------
        | TANGGAL HARI INI
        |--------------------------------------------------------------------------
        */

        $today =
            $now->toDateString();


        /*
        |--------------------------------------------------------------------------
        | BATAS PRESENSI
        |--------------------------------------------------------------------------
        |
        | 06:59:59 = masih boleh
        | 07:00:00 = masih boleh
        | 07:00:59 = masih boleh
        | 07:01:00 = mulai Alfa
        |
        */

        $cutoff =
            $now
                ->copy()
                ->setTimeFromTimeString(
                    $settings->cutoff_time
                );


        /*
        |--------------------------------------------------------------------------
        | JANGAN JALANKAN SEBELUM CUTOFF
        |--------------------------------------------------------------------------
        */

        if (
            $now->lt(
                $cutoff
            )
        ) {
            $this->warn(
                'Belum melewati batas presensi '
                . $settings->cutoff_time
                . '.'
            );

            return self::SUCCESS;
        }


        /*
        |--------------------------------------------------------------------------
        | AMBIL SISWA AKTIF
        |--------------------------------------------------------------------------
        |
        | Relasi user ikut dimuat karena nama siswa digunakan
        | dalam pesan WhatsApp.
        |
        */

        $students =
            Student::query()
                ->with(
                    'user'
                )
                ->where(
                    'status',
                    'active'
                )
                ->get();


        /*
        |--------------------------------------------------------------------------
        | COUNTER
        |--------------------------------------------------------------------------
        */

        $created = 0;

        $skipped = 0;

        $whatsappCreated = 0;

        $whatsappSkipped = 0;

        $whatsappFailed = 0;


        /*
        |--------------------------------------------------------------------------
        | PROSES SISWA
        |--------------------------------------------------------------------------
        */

        foreach (
            $students
            as $student
        ) {
            /*
            |--------------------------------------------------------------------------
            | CEK PRESENSI HARI INI
            |--------------------------------------------------------------------------
            |
            | Jika sudah punya:
            |
            | present
            | late
            | permission
            | sick
            | absent
            |
            | maka jangan membuat Alfa lagi.
            |
            */

            $alreadyExists =
                Attendance::query()
                    ->where(
                        'student_id',
                        $student->id
                    )
                    ->whereDate(
                        'attendance_date',
                        $today
                    )
                    ->exists();


            if (
                $alreadyExists
            ) {
                $skipped++;

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | BUAT DATA ALFA
            |--------------------------------------------------------------------------
            */

            $attendance =
                Attendance::create([
                    'student_id' =>
                        $student->id,

                    'barcode_id' =>
                        null,

                    'attendance_date' =>
                        $today,

                    'check_in_time' =>
                        null,

                    'status' =>
                        'absent',

                    'notes' =>
                        'Alfa otomatis karena belum melakukan presensi sampai pukul 07:01 WIB.',

                    'wa_sent' =>
                        false,
                ]);


            $created++;


            /*
            |--------------------------------------------------------------------------
            | BUAT NOTIFIKASI WHATSAPP
            |--------------------------------------------------------------------------
            |
            | Masih TEST MODE.
            |
            | Kalau siswa tidak memiliki parent_phone,
            | WhatsAppService akan mengembalikan null.
            |
            */

            try {
                $notification =
                    $whatsAppService
                        ->createAttendanceNotification(
                            $student,
                            $attendance
                        );


                if (
                    $notification
                ) {
                    $whatsappCreated++;
                } else {
                    $whatsappSkipped++;
                }

            } catch (
                \Throwable $exception
            ) {
                /*
                |--------------------------------------------------------------------------
                | JANGAN GAGALKAN AUTO ALFA
                |--------------------------------------------------------------------------
                */

                $whatsappFailed++;


                Log::error(
                    'Gagal membuat WhatsApp Notification untuk Auto Alfa.',
                    [
                        'student_id' =>
                            $student->id,

                        'nis' =>
                            $student->nis,

                        'attendance_id' =>
                            $attendance->id,

                        'error' =>
                            $exception->getMessage(),
                    ]
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | HASIL COMMAND
        |--------------------------------------------------------------------------
        */

        $this->newLine();

        $this->info(
            'Auto Alfa selesai.'
        );


        $this->line(
            'Tanggal     : '
            . $today
        );


        $this->line(
            'Hari        : '
            . $now
                ->locale('id')
                ->translatedFormat(
                    'l'
                )
        );


        $this->line(
            'Total siswa : '
            . $students->count()
        );


        $this->line(
            'Alfa baru   : '
            . $created
        );


        $this->line(
            'Dilewati    : '
            . $skipped
        );


        /*
        |--------------------------------------------------------------------------
        | INFO WHATSAPP
        |--------------------------------------------------------------------------
        */

        $this->line(
            'WA dibuat   : '
            . $whatsappCreated
        );


        $this->line(
            'WA dilewati : '
            . $whatsappSkipped
        );


        $this->line(
            'WA gagal    : '
            . $whatsappFailed
        );


        $this->newLine();


        return self::SUCCESS;
    }
}