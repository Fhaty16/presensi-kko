<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceSetting;
use App\Models\LeaveRequest;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\View\View;
use Throwable;

class DashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD GURU
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        /*
        |--------------------------------------------------------------------------
        | TIMEZONE
        |--------------------------------------------------------------------------
        */

        $timezone =
            'Asia/Jakarta';


        /*
        |--------------------------------------------------------------------------
        | WAKTU SEKARANG
        |--------------------------------------------------------------------------
        */

        $now =
            Carbon::now(
                $timezone
            );


        /*
        |--------------------------------------------------------------------------
        | TANGGAL HARI INI
        |--------------------------------------------------------------------------
        */

        $today =
            $now->toDateString();


        /*
        |--------------------------------------------------------------------------
        | PENGATURAN PRESENSI
        |--------------------------------------------------------------------------
        */

        $attendanceSetting =
            AttendanceSetting::firstOrCreate(
                [],
                [
                    'attendance_start_time' =>
                        '06:00:00',

                    'attendance_end_time' =>
                        '07:00:00',

                    'late_after_minutes' =>
                        10,

                    'cutoff_time' =>
                        '07:11:00',

                    'auto_alpha' =>
                        true,

                    'location_radius_meters' =>
                        120,

                    'barcode_lifetime_seconds' =>
                        60,
                ]
            );


        /*
        |--------------------------------------------------------------------------
        | JAM MULAI RAW
        |--------------------------------------------------------------------------
        */

        $attendanceStartRaw =
            (string) (
                $attendanceSetting
                    ->attendance_start_time
                ?? '06:00:00'
            );


        /*
        |--------------------------------------------------------------------------
        | NORMALISASI JAM MULAI
        |--------------------------------------------------------------------------
        */

        $attendanceStartTime =
            strlen(
                $attendanceStartRaw
            ) === 5
                ? $attendanceStartRaw
                    . ':00'
                : substr(
                    $attendanceStartRaw,
                    0,
                    8
                );


        /*
        |--------------------------------------------------------------------------
        | JAM SELESAI RAW
        |--------------------------------------------------------------------------
        */

        $attendanceEndRaw =
            (string) (
                $attendanceSetting
                    ->attendance_end_time
                ?? '07:00:00'
            );


        /*
        |--------------------------------------------------------------------------
        | NORMALISASI JAM SELESAI
        |--------------------------------------------------------------------------
        */

        $attendanceEndTime =
            strlen(
                $attendanceEndRaw
            ) === 5
                ? $attendanceEndRaw
                    . ':00'
                : substr(
                    $attendanceEndRaw,
                    0,
                    8
                );


        /*
        |--------------------------------------------------------------------------
        | TOLERANSI HADIR
        |--------------------------------------------------------------------------
        */

        $lateAfterMinutes =
            max(
                0,
                (int) (
                    $attendanceSetting
                        ->late_after_minutes
                    ?? 10
                )
            );


        /*
        |--------------------------------------------------------------------------
        | DATETIME JAM MULAI
        |--------------------------------------------------------------------------
        */

        $attendanceStartDateTime =
            Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $today
                    . ' '
                    . $attendanceStartTime,
                $timezone
            );


        /*
        |--------------------------------------------------------------------------
        | DATETIME JAM SELESAI
        |--------------------------------------------------------------------------
        */

        $attendanceEndDateTime =
            Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $today
                    . ' '
                    . $attendanceEndTime,
                $timezone
            );


        /*
        |--------------------------------------------------------------------------
        | FALLBACK JIKA DATA JAM TIDAK VALID
        |--------------------------------------------------------------------------
        */

        if (
            $attendanceEndDateTime
                ->lessThanOrEqualTo(
                    $attendanceStartDateTime
                )
        ) {

            $attendanceEndDateTime =
                $attendanceStartDateTime
                    ->copy()
                    ->addHour();
        }


        /*
        |--------------------------------------------------------------------------
        | DISPLAY JAM MULAI
        |--------------------------------------------------------------------------
        */

        $attendanceStartDisplay =
            $attendanceStartDateTime
                ->format(
                    'H:i'
                );


        /*
        |--------------------------------------------------------------------------
        | DISPLAY JAM SELESAI
        |--------------------------------------------------------------------------
        */

        $attendanceEndDisplay =
            $attendanceEndDateTime
                ->format(
                    'H:i'
                );


        /*
        |--------------------------------------------------------------------------
        | MULAI TOLERANSI
        |--------------------------------------------------------------------------
        |
        | Jam selesai 07:00 berarti:
        |
        | 07:00:59 masih masuk waktu presensi utama.
        |
        | Menit toleransi pertama:
        |
        | 07:01
        |
        */

        $toleranceStartDateTime =
            $attendanceEndDateTime
                ->copy()
                ->addMinute()
                ->startOfMinute();


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
        | Akhir toleransi:
        |
        | 07:10:59
        |
        */

        $toleranceEndDateTime =
            $attendanceEndDateTime
                ->copy()
                ->addMinutes(
                    $lateAfterMinutes
                )
                ->endOfMinute();


        /*
        |--------------------------------------------------------------------------
        | DISPLAY TOLERANSI
        |--------------------------------------------------------------------------
        */

        $toleranceStartDisplay =
            $toleranceStartDateTime
                ->format(
                    'H:i'
                );


        $toleranceEndDisplay =
            $toleranceEndDateTime
                ->format(
                    'H:i'
                );


        /*
        |--------------------------------------------------------------------------
        | MULAI PRESENSI DITUTUP / ALFA
        |--------------------------------------------------------------------------
        |
        | 07:10:59
        | +
        | 1 detik
        |
        | = 07:11:00
        |
        */

        $alphaStartDateTime =
            $toleranceEndDateTime
                ->copy()
                ->addSecond();


        /*
        |--------------------------------------------------------------------------
        | DISPLAY ALFA
        |--------------------------------------------------------------------------
        */

        $alphaStartDisplay =
            $alphaStartDateTime
                ->format(
                    'H:i'
                );


        /*
        |--------------------------------------------------------------------------
        | STATUS AUTO ALFA
        |--------------------------------------------------------------------------
        */

        $autoAlphaEnabled =
            (bool) $attendanceSetting
                ->auto_alpha;


        /*
        |--------------------------------------------------------------------------
        | AUTO ALFA FALLBACK
        |--------------------------------------------------------------------------
        |
        | Scheduler tetap menjadi mekanisme utama.
        |
        | Dashboard hanya menjadi fallback jika scheduler belum berjalan.
        |
        */

        if (
            $autoAlphaEnabled
            &&
            $now->isWeekday()
            &&
            $now->greaterThanOrEqualTo(
                $alphaStartDateTime
            )
        ) {

            try {

                Artisan::call(
                    'attendance:mark-absent'
                );

            } catch (
                Throwable $exception
            ) {

                report(
                    $exception
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | TOTAL SISWA AKTIF
        |--------------------------------------------------------------------------
        */

        $totalSiswa =
            Student::query()
                ->where(
                    'status',
                    'active'
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | PRESENSI HARI INI
        |--------------------------------------------------------------------------
        */

        $todayAttendances =
            Attendance::query()
                ->whereDate(
                    'attendance_date',
                    $today
                )
                ->get();


        /*
        |--------------------------------------------------------------------------
        | HADIR
        |--------------------------------------------------------------------------
        |
        | Status late lama tetap dimasukkan ke Hadir agar data lama
        | tidak hilang dari statistik.
        |
        | Scanner sekolah baru nantinya tidak lagi membuat status late.
        |
        */

        $presentCount =
            $todayAttendances
                ->where(
                    'status',
                    'present'
                )
                ->count();


        $legacyLateCount =
            $todayAttendances
                ->where(
                    'status',
                    'late'
                )
                ->count();


        $hadir =
            $presentCount
            +
            $legacyLateCount;


        /*
        |--------------------------------------------------------------------------
        | SAKIT
        |--------------------------------------------------------------------------
        */

        $sakit =
            $todayAttendances
                ->where(
                    'status',
                    'sick'
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | IZIN
        |--------------------------------------------------------------------------
        */

        $izin =
            $todayAttendances
                ->where(
                    'status',
                    'permission'
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | ALFA
        |--------------------------------------------------------------------------
        */

        $alfa =
            $todayAttendances
                ->where(
                    'status',
                    'absent'
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | PERSENTASE HADIR
        |--------------------------------------------------------------------------
        */

        $persentaseHadir =
            $totalSiswa > 0
                ? round(
                    (
                        $hadir
                        /
                        $totalSiswa
                    )
                    *
                    100
                )
                : 0;


        /*
        |--------------------------------------------------------------------------
        | PENDING LEAVE
        |--------------------------------------------------------------------------
        */

        $pendingLeaveCount =
            LeaveRequest::query()
                ->where(
                    'status',
                    'pending'
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | NOTIFIKASI LEAVE
        |--------------------------------------------------------------------------
        */

        $pendingLeaveNotifications =
            LeaveRequest::query()
                ->with([
                    'student.user',
                    'student.class',
                    'trainingSession',
                ])
                ->where(
                    'status',
                    'pending'
                )
                ->latest()
                ->limit(
                    6
                )
                ->get();


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'guru.dashboard',
            compact(
                'totalSiswa',

                'hadir',
                'sakit',
                'izin',
                'alfa',

                'persentaseHadir',

                'attendanceStartDisplay',
                'attendanceEndDisplay',

                'lateAfterMinutes',

                'toleranceStartDisplay',
                'toleranceEndDisplay',

                'alphaStartDisplay',

                'autoAlphaEnabled',

                'pendingLeaveCount',
                'pendingLeaveNotifications'
            )
        );
    }
}