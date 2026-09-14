<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Models\AttendanceSetting;
use App\Models\Student;
use App\Services\WhatsAppService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class MarkAbsentStudents extends Command
{
    /*
    |--------------------------------------------------------------------------
    | COMMAND
    |--------------------------------------------------------------------------
    */

    protected $signature =
        'attendance:mark-absent';


    /*
    |--------------------------------------------------------------------------
    | DESCRIPTION
    |--------------------------------------------------------------------------
    */

    protected $description =
        'Menandai siswa yang belum presensi sebagai Alfa setelah batas presensi sekolah berakhir.';


    /*
    |--------------------------------------------------------------------------
    | TIMEZONE
    |--------------------------------------------------------------------------
    */

    private const TIMEZONE =
        'Asia/Jakarta';


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
        | AMBIL SETTING
        |--------------------------------------------------------------------------
        */

        $settings =
            AttendanceSetting::first();


        /*
        |--------------------------------------------------------------------------
        | SETTING BELUM ADA
        |--------------------------------------------------------------------------
        */

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
        | AUTO ALFA OFF
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
            Carbon::now(
                self::TIMEZONE
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
        | JAM MULAI PRESENSI
        |--------------------------------------------------------------------------
        */

        $attendanceStart =
            $now
                ->copy()
                ->setTimeFromTimeString(
                    $settings
                        ->attendance_start_time
                    ??
                    '06:00:00'
                );


        /*
        |--------------------------------------------------------------------------
        | JAM SELESAI PRESENSI
        |--------------------------------------------------------------------------
        */

        $attendanceEnd =
            $now
                ->copy()
                ->setTimeFromTimeString(
                    $settings
                        ->attendance_end_time
                    ??
                    '07:00:00'
                );


        /*
        |--------------------------------------------------------------------------
        | VALIDASI JAM
        |--------------------------------------------------------------------------
        */

        if (
            $attendanceEnd
                ->lessThanOrEqualTo(
                    $attendanceStart
                )
        ) {

            $this->error(
                'Konfigurasi presensi tidak valid. Jam selesai harus setelah jam mulai.'
            );


            return self::FAILURE;
        }


        /*
        |--------------------------------------------------------------------------
        | TOLERANSI HADIR
        |--------------------------------------------------------------------------
        */

        $toleranceMinutes =
            max(
                0,
                (int) (
                    $settings
                        ->late_after_minutes
                    ??
                    0
                )
            );


        /*
        |--------------------------------------------------------------------------
        | AKHIR TOLERANSI
        |--------------------------------------------------------------------------
        |
        | Contoh:
        |
        | Jam selesai : 07:00
        | Toleransi   : 10 menit
        |
        | Maka:
        |
        | 07:01 - 07:10 = masih boleh presensi
        | 07:10:59       = masih boleh
        |
        */

        $toleranceEndsAt =
            $attendanceEnd
                ->copy()
                ->addMinutes(
                    $toleranceMinutes
                )
                ->endOfMinute();


        /*
        |--------------------------------------------------------------------------
        | MULAI ALFA
        |--------------------------------------------------------------------------
        |
        | 07:10:59
        | +
        | 1 detik
        |
        | =
        |
        | 07:11:00
        |
        */

        $alphaStartsAt =
            $toleranceEndsAt
                ->copy()
                ->addSecond();


        /*
        |--------------------------------------------------------------------------
        | BELUM MASUK WAKTU AUTO ALFA
        |--------------------------------------------------------------------------
        */

        if (
            $now->lt(
                $alphaStartsAt
            )
        ) {

            $this->warn(
                'Auto Alfa belum dijalankan. Presensi baru ditutup pukul '
                .
                $alphaStartsAt
                    ->format(
                        'H:i'
                    )
                .
                ' WIB.'
            );


            return self::SUCCESS;
        }


        /*
        |--------------------------------------------------------------------------
        | SISWA AKTIF
        |--------------------------------------------------------------------------
        */

        $students =
            Student::query()
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

        $created =
            0;


        $skipped =
            0;


        $whatsAppCreated =
            0;


        $whatsAppFailed =
            0;


        /*
        |--------------------------------------------------------------------------
        | PROSES SISWA
        |--------------------------------------------------------------------------
        */

        foreach (
            $students
            as
            $student
        ) {

            /*
            |--------------------------------------------------------------------------
            | CEK PRESENSI SUDAH ADA
            |--------------------------------------------------------------------------
            |
            | Jika siswa sudah mempunyai salah satu status:
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
            | BUAT ALFA
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

                    /*
                    |--------------------------------------------------------------------------
                    | CATATAN DINAMIS
                    |--------------------------------------------------------------------------
                    */

                    'notes' =>
                        'Alfa otomatis karena belum melakukan presensi sampai batas toleransi pukul '
                        .
                        $toleranceEndsAt
                            ->format(
                                'H:i'
                            )
                        .
                        ' WIB. Presensi ditutup mulai pukul '
                        .
                        $alphaStartsAt
                            ->format(
                                'H:i'
                            )
                        .
                        ' WIB.',

                    'wa_sent' =>
                        false,
                ]);


            $created++;


            /*
            |--------------------------------------------------------------------------
            | WHATSAPP ALFA
            |--------------------------------------------------------------------------
            |
            | Gagal membuat WhatsApp tidak boleh membatalkan data Alfa.
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

                    $whatsAppCreated++;
                }

            } catch (
                Throwable $exception
            ) {

                $whatsAppFailed++;


                Log::error(
                    'Gagal membuat WhatsApp Notification Auto Alfa.',
                    [
                        'student_id' =>
                            $student->id,

                        'nis' =>
                            $student->nis,

                        'attendance_id' =>
                            $attendance->id,

                        'error' =>
                            $exception
                                ->getMessage(),
                    ]
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | HASIL
        |--------------------------------------------------------------------------
        */

        $this->newLine();


        $this->info(
            'Auto Alfa selesai.'
        );


        $this->line(
            'Tanggal       : '
            .
            $today
        );


        $this->line(
            'Hari          : '
            .
            $now
                ->locale(
                    'id'
                )
                ->translatedFormat(
                    'l'
                )
        );


        $this->line(
            'Jam Mulai     : '
            .
            $attendanceStart
                ->format(
                    'H:i'
                )
        );


        $this->line(
            'Jam Selesai   : '
            .
            $attendanceEnd
                ->format(
                    'H:i'
                )
        );


        $this->line(
            'Toleransi     : '
            .
            $toleranceMinutes
            .
            ' menit'
        );


        $this->line(
            'Batas Hadir   : '
            .
            $toleranceEndsAt
                ->format(
                    'H:i'
                )
        );


        $this->line(
            'Mulai Alfa    : '
            .
            $alphaStartsAt
                ->format(
                    'H:i'
                )
        );


        $this->line(
            'Total siswa   : '
            .
            $students
                ->count()
        );


        $this->line(
            'Alfa baru     : '
            .
            $created
        );


        $this->line(
            'Dilewati      : '
            .
            $skipped
        );


        $this->line(
            'WA dibuat     : '
            .
            $whatsAppCreated
        );


        $this->line(
            'WA gagal      : '
            .
            $whatsAppFailed
        );


        $this->newLine();


        return self::SUCCESS;
    }
}