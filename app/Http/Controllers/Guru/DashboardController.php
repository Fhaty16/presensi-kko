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
        | WAKTU SEKARANG
        |--------------------------------------------------------------------------
        */

        $now =
            Carbon::now(
                'Asia/Jakarta'
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
        | JAM BATAS PRESENSI SEKOLAH
        |--------------------------------------------------------------------------
        */

        $attendanceSetting =
            AttendanceSetting::query()
                ->first();


        /*
        |--------------------------------------------------------------------------
        | JAM BATAS RAW
        |--------------------------------------------------------------------------
        */

        $cutoffRaw =
            (string) (
                $attendanceSetting?->cutoff_time
                ?? '07:01:00'
            );


        /*
        |--------------------------------------------------------------------------
        | NORMALISASI FORMAT JAM
        |--------------------------------------------------------------------------
        |
        | Misalnya database berisi:
        |
        | 07:01
        |
        | akan diubah menjadi:
        |
        | 07:01:00
        |
        */

        $cutoffTime =
            strlen(
                $cutoffRaw
            ) === 5
                ? $cutoffRaw . ':00'
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
        | WAKTU BATAS HARI INI
        |--------------------------------------------------------------------------
        */

        $cutoffDateTime =
            Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $today
                    . ' '
                    . $cutoffTime,
                'Asia/Jakarta'
            );


        /*
        |--------------------------------------------------------------------------
        | AUTO ALFA FALLBACK
        |--------------------------------------------------------------------------
        |
        | Tujuan:
        |
        | - Tidak perlu menjalankan schedule:work secara manual.
        |
        | - Hanya berlaku Senin sampai Jumat.
        |
        | - Sebelum jam batas tidak melakukan apa-apa.
        |
        | - Setelah jam batas, ketika Dashboard Guru dibuka,
        |   command attendance:mark-absent otomatis dijalankan.
        |
        | - Sabtu dan Minggu tidak dijalankan.
        |
        | Command attendance:mark-absent sendiri sudah menangani
        | siswa yang sudah memiliki presensi, sehingga tidak
        | membuat data presensi ganda.
        |
        */

        if (
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

            } catch (Throwable $exception) {

                /*
                |--------------------------------------------------------------------------
                | JANGAN BUAT DASHBOARD ERROR
                |--------------------------------------------------------------------------
                |
                | Kalau Auto-Alfa mengalami masalah, halaman Guru
                | tetap dapat dibuka dan error dicatat ke Laravel log.
                |
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
        |
        | Query dilakukan SETELAH Auto-Alfa dijalankan.
        |
        | Jadi kalau Auto-Alfa baru saja membuat data,
        | angka dashboard langsung ikut diperbarui.
        |
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