<?php

namespace App\Console\Commands;

use App\Models\TrainingSession;
use App\Services\TrainingAttendanceService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Throwable;

class MarkTrainingAbsent extends Command
{
    /*
    |--------------------------------------------------------------------------
    | SIGNATURE COMMAND
    |--------------------------------------------------------------------------
    |
    | Normal:
    |
    | php artisan training:mark-absent
    |
    | Simulasi:
    |
    | php artisan training:mark-absent --dry-run
    |
    */

    protected $signature =
        'training:mark-absent
        {--dry-run : Cek siswa yang akan menjadi Alfa tanpa menyimpan ke database}';


    /*
    |--------------------------------------------------------------------------
    | DESCRIPTION
    |--------------------------------------------------------------------------
    */

    protected $description =
        'Menandai siswa Alfa jika belum melakukan presensi lebih dari 30 menit setelah latihan dimulai.';


    /*
    |--------------------------------------------------------------------------
    | HANDLE
    |--------------------------------------------------------------------------
    */

    public function handle(
        TrainingAttendanceService $trainingAttendanceService
    ): int {

        /*
        |--------------------------------------------------------------------------
        | WAKTU SEKARANG
        |--------------------------------------------------------------------------
        */

        $now =
            Carbon::now(
                TrainingAttendanceService::TIMEZONE
            );


        /*
        |--------------------------------------------------------------------------
        | SESI HARI INI
        |--------------------------------------------------------------------------
        |
        | Hanya sesi pada tanggal hari ini yang diproses.
        |
        | Sesi lama tidak akan tiba-tiba dibuatkan Alfa.
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
                ->orderBy(
                    'start_time'
                )
                ->get();


        /*
        |--------------------------------------------------------------------------
        | TIDAK ADA SESI
        |--------------------------------------------------------------------------
        */

        if (
            $sessions->isEmpty()
        ) {

            $this->info(
                'Tidak ada sesi latihan hari ini.'
            );


            return self::SUCCESS;
        }


        /*
        |--------------------------------------------------------------------------
        | COUNTER
        |--------------------------------------------------------------------------
        */

        $totalCandidates =
            0;


        $totalCreated =
            0;


        /*
        |--------------------------------------------------------------------------
        | PROSES SETIAP SESI
        |--------------------------------------------------------------------------
        */

        foreach (
            $sessions
            as $session
        ) {

            try {

                /*
                |--------------------------------------------------------------------------
                | WAKTU MULAI
                |--------------------------------------------------------------------------
                */

                $startsAt =
                    $trainingAttendanceService
                        ->getSessionStartsAt(
                            $session
                        );


                /*
                |--------------------------------------------------------------------------
                | WAKTU ALFA
                |--------------------------------------------------------------------------
                */

                $alphaAt =
                    $trainingAttendanceService
                        ->getAutomaticAbsentAt(
                            $session
                        );


                /*
                |--------------------------------------------------------------------------
                | DATA TIDAK VALID
                |--------------------------------------------------------------------------
                */

                if (
                    !$startsAt
                    ||
                    !$alphaAt
                ) {
                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | BELUM LEWAT BATAS ALFA
                |--------------------------------------------------------------------------
                */

                if (
                    !$trainingAttendanceService
                        ->isAutomaticAbsentDue(
                            $session
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
                    .
                    $session->sport
                    .
                    ' | Mulai: '
                    .
                    $startsAt->format(
                        'H:i'
                    )
                    .
                    ' | Batas Alfa: '
                    .
                    $alphaAt->format(
                        'H:i'
                    )
                );


                /*
                |--------------------------------------------------------------------------
                | CALON ALFA
                |--------------------------------------------------------------------------
                */

                $candidates =
                    $trainingAttendanceService
                        ->getAutomaticAbsentCandidates(
                            $session
                        );


                /*
                |--------------------------------------------------------------------------
                | TIDAK ADA CALON ALFA
                |--------------------------------------------------------------------------
                */

                if (
                    $candidates->isEmpty()
                ) {

                    $this->line(
                        'Tidak ada siswa yang perlu ditandai Alfa.'
                    );


                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | JUMLAH CALON
                |--------------------------------------------------------------------------
                */

                $totalCandidates +=
                    $candidates->count();


                /*
                |--------------------------------------------------------------------------
                | DRY RUN
                |--------------------------------------------------------------------------
                */

                if (
                    $this->option(
                        'dry-run'
                    )
                ) {

                    foreach (
                        $candidates
                        as $student
                    ) {

                        $studentName =
                            $student->user?->name
                            ??
                            'Siswa #'
                            .
                            $student->id;


                        $this->line(
                            '[DRY RUN] '
                            .
                            $studentName
                            .
                            ' -> ALFA'
                        );
                    }


                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | SIMPAN ALFA MELALUI SERVICE
                |--------------------------------------------------------------------------
                */

                $created =
                    $trainingAttendanceService
                        ->markAutomaticAbsencesIfDue(
                            $session
                        );


                $totalCreated +=
                    $created;


                /*
                |--------------------------------------------------------------------------
                | INFORMASI
                |--------------------------------------------------------------------------
                */

                if (
                    $created > 0
                ) {

                    $this->info(
                        $created
                        .
                        ' siswa berhasil ditandai Alfa.'
                    );

                } else {

                    $this->line(
                        'Tidak ada Alfa baru yang dibuat.'
                    );
                }

            } catch (
                Throwable $exception
            ) {

                /*
                |--------------------------------------------------------------------------
                | ERROR SESI
                |--------------------------------------------------------------------------
                */

                report(
                    $exception
                );


                $this->error(
                    'Gagal memproses sesi ID '
                    .
                    $session->id
                    .
                    ': '
                    .
                    $exception->getMessage()
                );
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
                .
                $totalCandidates
                .
                ' siswa akan ditandai Alfa.'
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
            .
            $totalCreated
            .
            ' siswa berhasil ditandai Alfa.'
        );


        return self::SUCCESS;
    }
}