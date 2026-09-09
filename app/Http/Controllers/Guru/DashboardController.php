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
        | PENGATURAN PRESENSI SEKOLAH
        |--------------------------------------------------------------------------
        */

        $attendanceSetting =
            AttendanceSetting::firstOrCreate(
                [],
                [
                    'attendance_start_time' =>
                        '06:50:00',

                    'late_after_minutes' =>
                        10,

                    'cutoff_time' =>
                        '07:01:00',

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
        | JAM MULAI PRESENSI RAW
        |--------------------------------------------------------------------------
        */

        $attendanceStartRaw =
            (string) (
                $attendanceSetting
                    ->attendance_start_time
                ?? '06:50:00'
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
        | TAMPILAN JAM MULAI
        |--------------------------------------------------------------------------
        */

        $attendanceStartDisplay =
            substr(
                $attendanceStartTime,
                0,
                5
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
        | JAM MULAI TERLAMBAT
        |--------------------------------------------------------------------------
        |
        | Contoh:
        |
        | Jam mulai       : 06:50
        | Toleransi       : 10 menit
        |
        | Maka:
        |
        | Batas Hadir     : 07:00
        | Setelah 07:00   : Terlambat
        |
        */

        $lateStartDateTime =
            $attendanceStartDateTime
                ->copy()
                ->addMinutes(
                    $lateAfterMinutes
                );


        /*
        |--------------------------------------------------------------------------
        | TAMPILAN BATAS HADIR
        |--------------------------------------------------------------------------
        */

        $lateStartDisplay =
            $lateStartDateTime
                ->format(
                    'H:i'
                );


        /*
        |--------------------------------------------------------------------------
        | JAM BATAS ALFA RAW
        |--------------------------------------------------------------------------
        */

        $cutoffRaw =
            (string) (
                $attendanceSetting
                    ->cutoff_time
                ?? '07:01:00'
            );


        /*
        |--------------------------------------------------------------------------
        | NORMALISASI JAM BATAS
        |--------------------------------------------------------------------------
        */

        $cutoffTime =
            strlen(
                $cutoffRaw
            ) === 5
                ? $cutoffRaw
                    . ':00'
                : substr(
                    $cutoffRaw,
                    0,
                    8
                );


        /*
        |--------------------------------------------------------------------------
        | TAMPILAN JAM BATAS
        |--------------------------------------------------------------------------
        */

        $cutoffDisplay =
            substr(
                $cutoffTime,
                0,
                5
            );


        /*
        |--------------------------------------------------------------------------
        | DATETIME JAM BATAS HARI INI
        |--------------------------------------------------------------------------
        */

        $cutoffDateTime =
            Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $today
                    . ' '
                    . $cutoffTime,
                $timezone
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
        | Tujuan:
        |
        | - Tetap ada fallback jika scheduler belum berjalan.
        |
        | - Hanya Senin sampai Jumat.
        |
        | - Hanya berjalan jika Auto Alfa AKTIF.
        |
        | - Hanya berjalan setelah Jam Batas Alfa.
        |
        | - Command sendiri tetap mengecek siswa yang sudah punya presensi
        |   agar tidak membuat data ganda.
        |
        */

        if (
            $autoAlphaEnabled
            &&
            $now->isWeekday()
            &&
            $now->greaterThanOrEqualTo(
                $cutoffDateTime
            )
        ) {

            try {

                Artisan::call(
                    'attendance:mark-absent'
                );

            } catch (
                Throwable $exception
            ) {

                /*
                |--------------------------------------------------------------------------
                | JANGAN BUAT DASHBOARD ERROR
                |--------------------------------------------------------------------------
                */

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
        | Hanya siswa yang tepat waktu.
        |
        */

        $hadir =
            $todayAttendances
                ->where(
                    'status',
                    'present'
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | TERLAMBAT
        |--------------------------------------------------------------------------
        */

        $terlambat =
            $todayAttendances
                ->where(
                    'status',
                    'late'
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | TOTAL HADIR
        |--------------------------------------------------------------------------
        |
        | Digunakan untuk persentase kehadiran.
        |
        | Hadir + Terlambat tetap dianggap datang ke sekolah.
        |
        */

        $totalHadir =
            $hadir
            +
            $terlambat;


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
        |
        | Hadir + Terlambat dihitung sebagai kehadiran.
        |
        */

        $persentaseHadir =
            $totalSiswa > 0
                ? round(
                    (
                        $totalHadir
                        /
                        $totalSiswa
                    )
                    *
                    100
                )
                : 0;


        /*
        |--------------------------------------------------------------------------
        | JUMLAH PENGAJUAN YANG MASIH MENUNGGU
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
        | NOTIFIKASI PENGAJUAN TERBARU
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
                'terlambat',
                'sakit',
                'izin',
                'alfa',

                'persentaseHadir',

                'attendanceStartDisplay',
                'lateAfterMinutes',
                'lateStartDisplay',

                'cutoffDisplay',
                'autoAlphaEnabled',

                'pendingLeaveCount',
                'pendingLeaveNotifications'
            )
        );
    }
}