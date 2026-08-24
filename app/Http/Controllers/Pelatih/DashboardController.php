<?php

namespace App\Http\Controllers\Pelatih;

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
    | DASHBOARD PELATIH
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
        | PRESENSI SEKOLAH HARI INI
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
        | Hadir + Terlambat dianggap hadir.
        |
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
        | SUDAH PRESENSI
        |--------------------------------------------------------------------------
        */

        $sudahPresensi =
            $todayAttendances
                ->pluck(
                    'student_id'
                )
                ->unique()
                ->count();


        /*
        |--------------------------------------------------------------------------
        | BELUM PRESENSI
        |--------------------------------------------------------------------------
        */

        $belumPresensi =
            max(
                $totalSiswa
                - $sudahPresensi,
                0
            );


        /*
        |--------------------------------------------------------------------------
        | IZIN + SAKIT
        |--------------------------------------------------------------------------
        */

        $izinSakitHariIni =
            $izin
            + $sakit;


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
        | PRESENSI TERBARU
        |--------------------------------------------------------------------------
        */

        $presensiTerbaru =
            Attendance::query()
                ->with([
                    'student.user',
                    'student.class',
                ])
                ->whereDate(
                    'attendance_date',
                    $today
                )
                ->orderByDesc(
                    'check_in_time'
                )
                ->limit(6)
                ->get();


        /*
        |--------------------------------------------------------------------------
        | REKAP KELAS
        |--------------------------------------------------------------------------
        */

        $rekapKelas =
            Student::query()
                ->with(
                    'class'
                )
                ->where(
                    'status',
                    'active'
                )
                ->get()
                ->groupBy(
                    'class_id'
                );


        /*
        |--------------------------------------------------------------------------
        | NOTIFIKASI PENGAJUAN LATIHAN KKO
        |--------------------------------------------------------------------------
        |
        | Hanya:
        |
        | - attendance_scope = training
        | - status = pending
        |
        | Pengajuan sekolah TIDAK ditampilkan kepada Pelatih.
        |
        */

        $pendingTrainingRequests =
            LeaveRequest::query()
                ->with([
                    'student.user',
                    'student.class',
                    'trainingSession',
                ])
                ->where(
                    'attendance_scope',
                    'training'
                )
                ->where(
                    'status',
                    'pending'
                )
                ->latest()
                ->limit(6)
                ->get();


        /*
        |--------------------------------------------------------------------------
        | JUMLAH NOTIFIKASI LATIHAN
        |--------------------------------------------------------------------------
        */

        $pendingTrainingCount =
            LeaveRequest::query()
                ->where(
                    'attendance_scope',
                    'training'
                )
                ->where(
                    'status',
                    'pending'
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'pelatih.dashboard',
            compact(
                'totalSiswa',
                'hadir',
                'sakit',
                'izin',
                'alfa',
                'sudahPresensi',
                'belumPresensi',
                'izinSakitHariIni',
                'persentaseHadir',
                'cutoffDisplay',
                'presensiTerbaru',
                'rekapKelas',
                'pendingTrainingRequests',
                'pendingTrainingCount'
            )
        );
    }
}