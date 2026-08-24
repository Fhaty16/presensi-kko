<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceSetting;
use App\Models\LeaveRequest;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\View\View;

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
        | TANGGAL HARI INI
        |--------------------------------------------------------------------------
        */

        $today =
            Carbon::now(
                'Asia/Jakarta'
            )->toDateString();


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
        | HADIR + TERLAMBAT
        |--------------------------------------------------------------------------
        */

        $hadir =
            $todayAttendances
                ->whereIn(
                    'status',
                    [
                        'present',
                        'late',
                    ]
                )
                ->count();


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
                        / $totalSiswa
                    ) * 100
                )
                : 0;


        /*
        |--------------------------------------------------------------------------
        | JAM BATAS PRESENSI SEKOLAH
        |--------------------------------------------------------------------------
        */

        $attendanceSetting =
            AttendanceSetting::query()
                ->first();


        $cutoffDisplay =
            substr(
                (string) (
                    $attendanceSetting?->cutoff_time
                    ?? '07:01:00'
                ),
                0,
                5
            );


        /*
        |--------------------------------------------------------------------------
        | JUMLAH PENGAJUAN YANG MASIH MENUNGGU
        |--------------------------------------------------------------------------
        |
        | Semua pengajuan:
        |
        | - Presensi Sekolah
        | - Latihan KKO
        |
        | dihitung selama statusnya masih pending.
        |
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
        | NOTIFIKASI TERBARU
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
                ->limit(6)
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
                'cutoffDisplay',
                'pendingLeaveCount',
                'pendingLeaveNotifications'
            )
        );
    }
}