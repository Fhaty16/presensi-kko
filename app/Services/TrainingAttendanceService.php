<?php

namespace App\Services;

use App\Models\Student;
use App\Models\TrainingAttendance;
use App\Models\TrainingSession;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class TrainingAttendanceService
{
    /*
    |--------------------------------------------------------------------------
    | TIMEZONE
    |--------------------------------------------------------------------------
    */

    public const TIMEZONE =
        'Asia/Jakarta';


    /*
    |--------------------------------------------------------------------------
    | BATAS ALFA
    |--------------------------------------------------------------------------
    */

    public const AUTO_ABSENT_AFTER_MINUTES =
        30;


    /*
    |--------------------------------------------------------------------------
    | CATATAN ALFA OTOMATIS
    |--------------------------------------------------------------------------
    */

    public const AUTO_ABSENT_NOTE =
        'Alfa otomatis karena tidak melakukan presensi lebih dari 30 menit setelah latihan dimulai.';


    /*
    |--------------------------------------------------------------------------
    | WAKTU MULAI SESI
    |--------------------------------------------------------------------------
    */

    public function getSessionStartsAt(
        TrainingSession $trainingSession
    ): ?Carbon {

        /*
        |--------------------------------------------------------------------------
        | VALIDASI DATA
        |--------------------------------------------------------------------------
        */

        if (
            !$trainingSession->training_date
            ||
            !$trainingSession->start_time
        ) {
            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | TANGGAL
        |--------------------------------------------------------------------------
        */

        $date =
            Carbon::parse(
                $trainingSession->training_date,
                self::TIMEZONE
            )
                ->format(
                    'Y-m-d'
                );


        /*
        |--------------------------------------------------------------------------
        | JAM MULAI
        |--------------------------------------------------------------------------
        */

        $startTime =
            Carbon::parse(
                $trainingSession->start_time,
                self::TIMEZONE
            )
                ->format(
                    'H:i:s'
                );


        /*
        |--------------------------------------------------------------------------
        | WAKTU MULAI LENGKAP
        |--------------------------------------------------------------------------
        */

        return Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $date
            .
            ' '
            .
            $startTime,
            self::TIMEZONE
        );
    }


    /*
    |--------------------------------------------------------------------------
    | WAKTU ALFA
    |--------------------------------------------------------------------------
    |
    | Contoh:
    |
    | Mulai latihan : 14:00
    | Batas Alfa    : 14:30
    |
    */

    public function getAutomaticAbsentAt(
        TrainingSession $trainingSession
    ): ?Carbon {

        $startsAt =
            $this->getSessionStartsAt(
                $trainingSession
            );


        if (!$startsAt) {
            return null;
        }


        return $startsAt
            ->copy()
            ->addMinutes(
                self::AUTO_ABSENT_AFTER_MINUTES
            );
    }


    /*
    |--------------------------------------------------------------------------
    | CEK APAKAH SUDAH WAKTUNYA ALFA
    |--------------------------------------------------------------------------
    |
    | Penting:
    |
    | 14:30:00
    | => belum Alfa
    |
    | 14:30:01
    | => sudah dapat diproses menjadi Alfa
    |
    */

    public function isAutomaticAbsentDue(
        TrainingSession $trainingSession
    ): bool {

        /*
        |--------------------------------------------------------------------------
        | WAKTU ALFA
        |--------------------------------------------------------------------------
        */

        $alphaAt =
            $this->getAutomaticAbsentAt(
                $trainingSession
            );


        if (!$alphaAt) {
            return false;
        }


        /*
        |--------------------------------------------------------------------------
        | WAKTU SEKARANG
        |--------------------------------------------------------------------------
        */

        $now =
            Carbon::now(
                self::TIMEZONE
            );


        /*
        |--------------------------------------------------------------------------
        | HARUS SUDAH LEWAT BATAS
        |--------------------------------------------------------------------------
        */

        return $now->gt(
            $alphaAt
        );
    }


    /*
    |--------------------------------------------------------------------------
    | AMBIL SISWA CALON ALFA
    |--------------------------------------------------------------------------
    |
    | Siswa harus:
    |
    | - status active
    | - cabang olahraga sama dengan sesi
    | - belum memiliki record TrainingAttendance
    |
    */

    public function getAutomaticAbsentCandidates(
        TrainingSession $trainingSession
    ): Collection {

        /*
        |--------------------------------------------------------------------------
        | VALIDASI SESI
        |--------------------------------------------------------------------------
        */

        if (
            !$trainingSession->sport
            ||
            !$trainingSession->training_date
            ||
            !$trainingSession->start_time
        ) {
            return collect();
        }


        /*
        |--------------------------------------------------------------------------
        | BELUM LEWAT BATAS ALFA
        |--------------------------------------------------------------------------
        */

        if (
            !$this->isAutomaticAbsentDue(
                $trainingSession
            )
        ) {
            return collect();
        }


        /*
        |--------------------------------------------------------------------------
        | SISWA YANG SUDAH MEMILIKI PRESENSI
        |--------------------------------------------------------------------------
        |
        | Status apa pun dianggap sudah tercatat:
        |
        | present
        | late
        | permission
        | sick
        | absent
        |
        */

        $existingStudentIds =
            TrainingAttendance::query()
                ->where(
                    'training_session_id',
                    $trainingSession->id
                )
                ->pluck(
                    'student_id'
                );


        /*
        |--------------------------------------------------------------------------
        | QUERY SISWA
        |--------------------------------------------------------------------------
        */

        $studentsQuery =
            Student::query()
                ->with(
                    'user'
                )
                ->where(
                    'status',
                    'active'
                )
                ->where(
                    'sport',
                    $trainingSession->sport
                );


        /*
        |--------------------------------------------------------------------------
        | KECUALIKAN SISWA YANG SUDAH TERCATAT
        |--------------------------------------------------------------------------
        */

        if (
            $existingStudentIds->isNotEmpty()
        ) {

            $studentsQuery
                ->whereNotIn(
                    'id',
                    $existingStudentIds
                );
        }


        /*
        |--------------------------------------------------------------------------
        | HASIL
        |--------------------------------------------------------------------------
        */

        return $studentsQuery
            ->get();
    }


    /*
    |--------------------------------------------------------------------------
    | BUAT ALFA OTOMATIS
    |--------------------------------------------------------------------------
    */

    public function markAutomaticAbsencesIfDue(
        TrainingSession $trainingSession
    ): int {

        /*
        |--------------------------------------------------------------------------
        | AMBIL CALON ALFA
        |--------------------------------------------------------------------------
        */

        $students =
            $this->getAutomaticAbsentCandidates(
                $trainingSession
            );


        /*
        |--------------------------------------------------------------------------
        | TIDAK ADA CALON ALFA
        |--------------------------------------------------------------------------
        */

        if (
            $students->isEmpty()
        ) {
            return 0;
        }


        /*
        |--------------------------------------------------------------------------
        | JUMLAH RECORD BARU
        |--------------------------------------------------------------------------
        */

        $createdCount =
            0;


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
            | FIRST OR CREATE
            |--------------------------------------------------------------------------
            |
            | Tetap gunakan firstOrCreate sebagai perlindungan tambahan jika:
            |
            | - scheduler berjalan bersamaan,
            | - controller membuka sesi bersamaan,
            | - terjadi request hampir bersamaan.
            |
            */

            $attendance =
                TrainingAttendance::firstOrCreate(
                    [
                        'training_session_id' =>
                            $trainingSession->id,

                        'student_id' =>
                            $student->id,
                    ],
                    [
                        'status' =>
                            'absent',

                        'checked_in_at' =>
                            null,

                        'notes' =>
                            self::AUTO_ABSENT_NOTE,
                    ]
                );


            /*
            |--------------------------------------------------------------------------
            | HITUNG RECORD BARU
            |--------------------------------------------------------------------------
            */

            if (
                $attendance->wasRecentlyCreated
            ) {
                $createdCount++;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | HASIL
        |--------------------------------------------------------------------------
        */

        return $createdCount;
    }


    /*
    |--------------------------------------------------------------------------
    | HAPUS ALFA OTOMATIS
    |--------------------------------------------------------------------------
    |
    | Digunakan jika jadwal latihan berubah.
    |
    | Yang dihapus hanya:
    |
    | status = absent
    | notes  = AUTO_ABSENT_NOTE
    |
    | Alfa manual tidak akan ikut terhapus.
    |
    */

    public function deleteAutomaticAbsences(
        TrainingSession $trainingSession
    ): int {

        return $trainingSession
            ->attendances()
            ->where(
                'status',
                'absent'
            )
            ->where(
                'notes',
                self::AUTO_ABSENT_NOTE
            )
            ->delete();
    }
}