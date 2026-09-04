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
    | BATAS HADIR
    |--------------------------------------------------------------------------
    |
    | Mulai latihan sampai tepat +10 menit:
    |
    | status = present
    |
    | Setelah +10 menit:
    |
    | status = late
    |
    */

    public const LATE_LIMIT_MINUTES =
        10;


    /*
    |--------------------------------------------------------------------------
    | BATAS ALFA
    |--------------------------------------------------------------------------
    |
    | Tepat +30 menit masih boleh presensi.
    |
    | Setelah +30 menit:
    |
    | status = absent
    |
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
    | BATAS HADIR
    |--------------------------------------------------------------------------
    |
    | Contoh:
    |
    | Mulai latihan : 14:00
    | Batas hadir   : 14:10
    |
    | Tepat 14:10:00 masih Hadir.
    |
    */

    public function getLateLimitAt(
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
                self::LATE_LIMIT_MINUTES
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

        $alphaAt =
            $this->getAutomaticAbsentAt(
                $trainingSession
            );


        if (!$alphaAt) {
            return false;
        }


        $now =
            Carbon::now(
                self::TIMEZONE
            );


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
    | - belum memiliki TrainingAttendance
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
        | QUERY SISWA SESUAI CABANG
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
        | KECUALIKAN YANG SUDAH TERCATAT
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

        $students =
            $this->getAutomaticAbsentCandidates(
                $trainingSession
            );


        if (
            $students->isEmpty()
        ) {
            return 0;
        }


        $createdCount =
            0;


        foreach (
            $students
            as $student
        ) {

            /*
            |--------------------------------------------------------------------------
            | FIRST OR CREATE
            |--------------------------------------------------------------------------
            |
            | Menjaga agar tidak terjadi duplikasi jika scheduler/controller
            | berjalan hampir bersamaan.
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


            if (
                $attendance->wasRecentlyCreated
            ) {
                $createdCount++;
            }
        }


        return $createdCount;
    }


    /*
    |--------------------------------------------------------------------------
    | HAPUS ALFA OTOMATIS
    |--------------------------------------------------------------------------
    |
    | Digunakan ketika jadwal latihan berubah.
    |
    | Hanya Alfa otomatis yang dihapus.
    | Alfa manual tetap dipertahankan.
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