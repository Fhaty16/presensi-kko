<?php

namespace App\Console\Commands;

use App\Models\Student;
use App\Models\TrainingAttendance;
use App\Models\TrainingSession;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MarkTrainingAbsent extends Command
{
    /*
    |--------------------------------------------------------------------------
    | SIGNATURE COMMAND
    |--------------------------------------------------------------------------
    |
    | Jalankan normal:
    |
    | php artisan training:mark-absent
    |
    | Cek tanpa menyimpan:
    |
    | php artisan training:mark-absent --dry-run
    |
    */

    protected $signature =
        'training:mark-absent
        {--dry-run : Cek siswa yang akan menjadi Alfa tanpa menyimpan ke database}';


    protected $description =
        'Menandai siswa Alfa jika belum melakukan presensi lebih dari 30 menit setelah latihan dimulai.';


    /*
    |--------------------------------------------------------------------------
    | HANDLE
    |--------------------------------------------------------------------------
    */

    public function handle(): int
    {
        $timezone =
            'Asia/Jakarta';


        $now =
            Carbon::now(
                $timezone
            );


        /*
        |--------------------------------------------------------------------------
        | AMBIL SESI HARI INI
        |--------------------------------------------------------------------------
        |
        | Untuk keamanan, command hanya memproses sesi latihan
        | pada tanggal hari ini.
        |
        | Jadi sesi lama tidak tiba-tiba diisi Alfa.
        |
        */

        $sessions =
            TrainingSession::query()
                ->whereDate(
                    'training_date',
                    $now->toDateString()
                )
                ->whereNotNull(
                    'start_time'
                )
                ->get();


        $totalCandidates = 0;
        $totalCreated = 0;


        /*
        |--------------------------------------------------------------------------
        | JIKA TIDAK ADA SESI
        |--------------------------------------------------------------------------
        */

        if ($sessions->isEmpty()) {

            $this->info(
                'Tidak ada sesi latihan hari ini.'
            );

            return self::SUCCESS;
        }


        /*
        |--------------------------------------------------------------------------
        | PROSES SETIAP SESI
        |--------------------------------------------------------------------------
        */

        foreach ($sessions as $session) {

            /*
            |--------------------------------------------------------------------------
            | TANGGAL SESI
            |--------------------------------------------------------------------------
            */

            $trainingDate =
                Carbon::parse(
                    $session->training_date,
                    $timezone
                )->format(
                    'Y-m-d'
                );


            /*
            |--------------------------------------------------------------------------
            | JAM MULAI
            |--------------------------------------------------------------------------
            */

            $startTime =
                Carbon::parse(
                    $session->start_time,
                    $timezone
                )->format(
                    'H:i:s'
                );


            /*
            |--------------------------------------------------------------------------
            | WAKTU MULAI LENGKAP
            |--------------------------------------------------------------------------
            */

            $startsAt =
                Carbon::createFromFormat(
                    'Y-m-d H:i:s',
                    $trainingDate
                    . ' '
                    . $startTime,
                    $timezone
                );


            /*
            |--------------------------------------------------------------------------
            | BATAS ALFA
            |--------------------------------------------------------------------------
            |
            | Contoh:
            |
            | Jam mulai : 14:00
            |
            | 14:00:00 - 14:10:00
            | => Hadir
            |
            | 14:10:01 - 14:30:00
            | => Terlambat
            |
            | > 14:30:00
            | => Alfa
            |
            */

            $alphaAt =
                $startsAt
                    ->copy()
                    ->addMinutes(30);


            /*
            |--------------------------------------------------------------------------
            | BELUM LEWAT BATAS ALFA
            |--------------------------------------------------------------------------
            |
            | Pada tepat 14:30:00 belum diproses.
            |
            | Baru setelah melewati 14:30:00 siswa menjadi Alfa.
            |
            */

            if (
                $now->lte(
                    $alphaAt
                )
            ) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | INFORMASI SESI
            |--------------------------------------------------------------------------
            */

            $this->newLine();

            $this->line(
                'Sesi: '
                . $session->sport
                . ' | Mulai: '
                . $startsAt->format('H:i')
                . ' | Batas Alfa: '
                . $alphaAt->format('H:i')
            );


            /*
            |--------------------------------------------------------------------------
            | AMBIL SISWA SESUAI CABANG OLAHRAGA
            |--------------------------------------------------------------------------
            |
            | Penting:
            |
            | Sesi Atletik
            | => hanya siswa Atletik
            |
            | Sesi Bola Basket
            | => hanya siswa Bola Basket
            |
            | dan seterusnya.
            |
            */

            $students =
                Student::query()
                    ->with('user')
                    ->where(
                        'status',
                        'active'
                    )
                    ->where(
                        'sport',
                        $session->sport
                    )
                    ->get();


            /*
            |--------------------------------------------------------------------------
            | JIKA CABANG TIDAK PUNYA SISWA
            |--------------------------------------------------------------------------
            */

            if ($students->isEmpty()) {

                $this->line(
                    'Tidak ada siswa aktif pada cabang '
                    . $session->sport
                    . '.'
                );

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | PROSES SETIAP SISWA
            |--------------------------------------------------------------------------
            */

            foreach ($students as $student) {

                /*
                |--------------------------------------------------------------------------
                | CEK APAKAH SISWA SUDAH PUNYA PRESENSI
                |--------------------------------------------------------------------------
                |
                | Kalau sudah memiliki salah satu:
                |
                | present
                | late
                | permission
                | sick
                | absent
                |
                | maka data TIDAK disentuh.
                |
                */

                $existingAttendance =
                    TrainingAttendance::query()
                        ->where(
                            'training_session_id',
                            $session->id
                        )
                        ->where(
                            'student_id',
                            $student->id
                        )
                        ->exists();


                if ($existingAttendance) {
                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | SISWA CALON ALFA
                |--------------------------------------------------------------------------
                */

                $totalCandidates++;


                $studentName =
                    $student->user?->name
                    ?? 'Siswa #' . $student->id;


                /*
                |--------------------------------------------------------------------------
                | DRY RUN
                |--------------------------------------------------------------------------
                |
                | Tidak menyimpan database.
                |
                */

                if (
                    $this->option(
                        'dry-run'
                    )
                ) {

                    $this->line(
                        '[DRY RUN] '
                        . $studentName
                        . ' → ALFA'
                    );

                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | SIMPAN ALFA
                |--------------------------------------------------------------------------
                |
                | firstOrCreate digunakan sebagai perlindungan tambahan
                | agar record tidak dibuat dua kali.
                |
                */

                $attendance =
                    TrainingAttendance::firstOrCreate(
                        [
                            'training_session_id' =>
                                $session->id,

                            'student_id' =>
                                $student->id,
                        ],
                        [
                            'status' =>
                                'absent',

                            'checked_in_at' =>
                                null,

                            'notes' =>
                                'Alfa otomatis karena tidak melakukan presensi lebih dari 30 menit setelah latihan dimulai.',
                        ]
                    );


                /*
                |--------------------------------------------------------------------------
                | HITUNG DATA BARU
                |--------------------------------------------------------------------------
                */

                if (
                    $attendance->wasRecentlyCreated
                ) {

                    $totalCreated++;


                    $this->line(
                        '[ALFA] '
                        . $studentName
                        . ' → berhasil ditandai Alfa'
                    );
                }
            }
        }


        /*
        |--------------------------------------------------------------------------
        | HASIL DRY RUN
        |--------------------------------------------------------------------------
        */

        if (
            $this->option(
                'dry-run'
            )
        ) {

            $this->newLine();

            $this->info(
                'Dry run selesai. '
                . $totalCandidates
                . ' siswa akan ditandai Alfa.'
            );


            return self::SUCCESS;
        }


        /*
        |--------------------------------------------------------------------------
        | HASIL EKSEKUSI
        |--------------------------------------------------------------------------
        */

        $this->newLine();

        $this->info(
            'Proses Alfa latihan selesai. '
            . $totalCreated
            . ' siswa berhasil ditandai Alfa.'
        );


        return self::SUCCESS;
    }
}