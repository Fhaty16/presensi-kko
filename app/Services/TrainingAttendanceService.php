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
    | Mulai sampai tepat +10 menit = Hadir.
    | Setelah +10 menit = Terlambat.
    |
    */

    public const LATE_LIMIT_MINUTES =
        10;


    /*
    |--------------------------------------------------------------------------
    | BATAS MAKSIMAL PRESENSI
    |--------------------------------------------------------------------------
    |
    | Presensi maksimal dibuka sampai +30 menit setelah latihan dimulai.
    |
    */

    public const AUTO_ABSENT_AFTER_MINUTES =
        30;


    /*
    |--------------------------------------------------------------------------
    | CATATAN AUTO ALFA
    |--------------------------------------------------------------------------
    */

    public const AUTO_ABSENT_NOTE =
        'Alfa otomatis karena tidak melakukan presensi sampai batas waktu presensi latihan berakhir.';


    /*
    |--------------------------------------------------------------------------
    | CATATAN AUTO ALFA VERSI LAMA
    |--------------------------------------------------------------------------
    |
    | Dipertahankan supaya Alfa otomatis yang sudah pernah tersimpan
    | masih dapat dikenali ketika jadwal latihan diedit.
    |
    */

    public const LEGACY_AUTO_ABSENT_NOTE =
        'Alfa otomatis karena tidak melakukan presensi lebih dari 30 menit setelah latihan dimulai.';


    /*
    |--------------------------------------------------------------------------
    | WAKTU MULAI SESI
    |--------------------------------------------------------------------------
    */

    public function getSessionStartsAt(
        TrainingSession $trainingSession
    ): ?Carbon {

        if (
            !$trainingSession->training_date
            ||
            !$trainingSession->start_time
        ) {
            return null;
        }


        $date =
            Carbon::parse(
                $trainingSession->training_date,
                self::TIMEZONE
            )->format(
                'Y-m-d'
            );


        $startTime =
            Carbon::parse(
                $trainingSession->start_time,
                self::TIMEZONE
            )->format(
                'H:i:s'
            );


        return Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $date . ' ' . $startTime,
            self::TIMEZONE
        );
    }


    /*
    |--------------------------------------------------------------------------
    | WAKTU SELESAI SESI
    |--------------------------------------------------------------------------
    */

    public function getSessionEndsAt(
        TrainingSession $trainingSession
    ): ?Carbon {

        if (
            !$trainingSession->training_date
            ||
            !$trainingSession->end_time
        ) {
            return null;
        }


        $date =
            Carbon::parse(
                $trainingSession->training_date,
                self::TIMEZONE
            )->format(
                'Y-m-d'
            );


        $endTime =
            Carbon::parse(
                $trainingSession->end_time,
                self::TIMEZONE
            )->format(
                'H:i:s'
            );


        return Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $date . ' ' . $endTime,
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
    | Mulai       : 14:00:00
    | Batas hadir : 14:10:00
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
    | BATAS MAKSIMAL +30 MENIT
    |--------------------------------------------------------------------------
    */

    public function getMaximumAttendanceLimitAt(
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
    | BATAS AKHIR PRESENSI
    |--------------------------------------------------------------------------
    |
    | Ambil waktu yang lebih dahulu:
    |
    | 1. end_time
    | 2. start_time + 30 menit
    |
    | Contoh:
    |
    | 14:00 - 16:00
    | closes_at = 14:30
    |
    | 14:00 - 14:20
    | closes_at = 14:20
    |
    */

    public function getAttendanceClosesAt(
        TrainingSession $trainingSession
    ): ?Carbon {

        $endsAt =
            $this->getSessionEndsAt(
                $trainingSession
            );


        $maximumLimitAt =
            $this->getMaximumAttendanceLimitAt(
                $trainingSession
            );


        if (
            !$endsAt
            ||
            !$maximumLimitAt
        ) {
            return null;
        }


        return $endsAt->lt(
            $maximumLimitAt
        )
            ? $endsAt->copy()
            : $maximumLimitAt->copy();
    }


    /*
    |--------------------------------------------------------------------------
    | SEMUA WAKTU SESI
    |--------------------------------------------------------------------------
    |
    | Ini menjadi SATU SUMBER WAKTU untuk:
    |
    | - Scanner siswa
    | - QR / Barcode latihan
    | - Auto Alfa
    |
    */

    public function getSessionTimes(
        TrainingSession $trainingSession
    ): ?array {

        $startsAt =
            $this->getSessionStartsAt(
                $trainingSession
            );


        $endsAt =
            $this->getSessionEndsAt(
                $trainingSession
            );


        $lateLimit =
            $this->getLateLimitAt(
                $trainingSession
            );


        $maximumAttendanceLimitAt =
            $this->getMaximumAttendanceLimitAt(
                $trainingSession
            );


        $closesAt =
            $this->getAttendanceClosesAt(
                $trainingSession
            );


        if (
            !$startsAt
            ||
            !$endsAt
            ||
            !$lateLimit
            ||
            !$maximumAttendanceLimitAt
            ||
            !$closesAt
        ) {
            return null;
        }


        return [

            'starts_at' =>
                $startsAt,

            'late_limit' =>
                $lateLimit,

            /*
            |--------------------------------------------------------------------------
            | ALPHA_AT
            |--------------------------------------------------------------------------
            |
            | Ini adalah batas Alfa aktual.
            |
            | Jika sesi selesai sebelum +30 menit,
            | alpha_at mengikuti end_time.
            |
            */

            'alpha_at' =>
                $closesAt,

            /*
            |--------------------------------------------------------------------------
            | BATAS MAKSIMAL +30
            |--------------------------------------------------------------------------
            */

            'maximum_attendance_limit_at' =>
                $maximumAttendanceLimitAt,

            'ends_at' =>
                $endsAt,

            'closes_at' =>
                $closesAt,

        ];
    }


    /*
    |--------------------------------------------------------------------------
    | WAKTU AUTO ALFA
    |--------------------------------------------------------------------------
    |
    | Menggunakan closes_at agar sama dengan scanner dan barcode.
    |
    */

    public function getAutomaticAbsentAt(
        TrainingSession $trainingSession
    ): ?Carbon {

        return $this->getAttendanceClosesAt(
            $trainingSession
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CEK AUTO ALFA SUDAH DUE
    |--------------------------------------------------------------------------
    |
    | Tepat di batas masih boleh presensi.
    |
    | 14:30:00 = belum Alfa
    | 14:30:01 = Alfa
    |
    */

    public function isAutomaticAbsentDue(
        TrainingSession $trainingSession
    ): bool {

        $closesAt =
            $this->getAttendanceClosesAt(
                $trainingSession
            );


        if (!$closesAt) {
            return false;
        }


        $now =
            Carbon::now(
                self::TIMEZONE
            );


        return $now->gt(
            $closesAt
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CALON AUTO ALFA
    |--------------------------------------------------------------------------
    |
    | Syarat:
    |
    | - siswa active
    | - cabang olahraga sama
    | - belum memiliki record presensi pada sesi tersebut
    | - sudah melewati batas presensi
    |
    */

    public function getAutomaticAbsentCandidates(
        TrainingSession $trainingSession
    ): Collection {

        if (
            !$trainingSession->sport
            ||
            !$trainingSession->training_date
            ||
            !$trainingSession->start_time
            ||
            !$trainingSession->end_time
        ) {
            return collect();
        }


        if (
            !$this->isAutomaticAbsentDue(
                $trainingSession
            )
        ) {
            return collect();
        }


        /*
        |--------------------------------------------------------------------------
        | SISWA YANG SUDAH PUNYA PRESENSI
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
        | SISWA ACTIVE SESUAI CABANG
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
    | BUAT AUTO ALFA
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
            | Mencegah duplikasi jika scheduler/controller berjalan
            | hampir bersamaan.
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
    | HAPUS AUTO ALFA
    |--------------------------------------------------------------------------
    |
    | Digunakan ketika jadwal latihan berubah.
    |
    | Alfa manual tidak dihapus.
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
            ->whereIn(
                'notes',
                [
                    self::AUTO_ABSENT_NOTE,
                    self::LEGACY_AUTO_ABSENT_NOTE,
                ]
            )
            ->delete();
    }
}