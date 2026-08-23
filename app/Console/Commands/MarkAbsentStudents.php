<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Models\AttendanceSetting;
use App\Models\Student;
use Illuminate\Console\Command;

class MarkAbsentStudents extends Command
{
    /**
     * Nama command Artisan.
     */
    protected $signature = 'attendance:mark-absent';


    /**
     * Deskripsi command.
     */
    protected $description = 'Menandai siswa yang belum presensi sebagai Alfa setiap Senin sampai Jumat setelah pukul 07:01 WIB';


    /**
     * Jalankan command.
     */
    public function handle(): int
    {
        /*
        |--------------------------------------------------------------------------
        | AMBIL SETTING PRESENSI
        |--------------------------------------------------------------------------
        */

        $settings = AttendanceSetting::first();


        if (!$settings) {

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

        if (!$settings->auto_alpha) {

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

        $now = now();


        /*
        |--------------------------------------------------------------------------
        | HANYA SENIN - JUMAT
        |--------------------------------------------------------------------------
        |
        | Senin  = dijalankan
        | Selasa = dijalankan
        | Rabu   = dijalankan
        | Kamis  = dijalankan
        | Jumat  = dijalankan
        |
        | Sabtu  = tidak dijalankan
        | Minggu = tidak dijalankan
        |
        */

        if (!$now->isWeekday()) {

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

        $today = $now->toDateString();


        /*
        |--------------------------------------------------------------------------
        | BATAS PRESENSI
        |--------------------------------------------------------------------------
        |
        | Aturan:
        |
        | 06:59:59 = masih boleh hadir
        | 07:00:00 = masih boleh hadir
        | 07:00:59 = masih boleh hadir
        | 07:01:00 = mulai Alfa
        |
        */

        $cutoff = $now
            ->copy()
            ->setTimeFromTimeString(
                $settings->cutoff_time
            );


        /*
        |--------------------------------------------------------------------------
        | JANGAN JALANKAN SEBELUM CUTOFF
        |--------------------------------------------------------------------------
        */

        if ($now->lt($cutoff)) {

            $this->warn(
                'Belum melewati batas presensi ' .
                $settings->cutoff_time .
                '.'
            );

            return self::SUCCESS;
        }


        /*
        |--------------------------------------------------------------------------
        | AMBIL SEMUA SISWA AKTIF
        |--------------------------------------------------------------------------
        */

        $students = Student::where(
            'status',
            'active'
        )->get();


        /*
        |--------------------------------------------------------------------------
        | COUNTER
        |--------------------------------------------------------------------------
        */

        $created = 0;
        $skipped = 0;


        /*
        |--------------------------------------------------------------------------
        | PROSES SISWA SATU PER SATU
        |--------------------------------------------------------------------------
        */

        foreach ($students as $student) {

            /*
            |--------------------------------------------------------------------------
            | CEK PRESENSI HARI INI
            |--------------------------------------------------------------------------
            |
            | Jika siswa sudah memiliki salah satu status:
            |
            | present     = Hadir
            | late        = Terlambat
            | permission  = Izin
            | sick        = Sakit
            | absent      = Alfa
            |
            | maka siswa tersebut tidak akan dibuat Alfa lagi.
            |
            */

            $alreadyExists = Attendance::where(
                'student_id',
                $student->id
            )
                ->whereDate(
                    'attendance_date',
                    $today
                )
                ->exists();


            if ($alreadyExists) {

                $skipped++;

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | BUAT DATA ALFA
            |--------------------------------------------------------------------------
            */

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
            'Tanggal     : ' . $today
        );


        $this->line(
            'Hari        : ' . $now->translatedFormat('l')
        );


        $this->line(
            'Total siswa : ' . $students->count()
        );


        $this->line(
            'Alfa baru   : ' . $created
        );


        $this->line(
            'Dilewati    : ' . $skipped
        );


        $this->newLine();


        return self::SUCCESS;
    }
}