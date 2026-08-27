<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD SISWA
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        /*
        |--------------------------------------------------------------------------
        | DATA SISWA
        |--------------------------------------------------------------------------
        */

        $student =
            Student::with(
                'class'
            )
                ->where(
                    'user_id',
                    auth()->id()
                )
                ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | HARI INI
        |--------------------------------------------------------------------------
        */

        $today =
            now(
                'Asia/Jakarta'
            )
                ->toDateString();


        /*
        |--------------------------------------------------------------------------
        | PRESENSI HARI INI
        |--------------------------------------------------------------------------
        */

        $todayAttendance =
            Attendance::query()
                ->where(
                    'student_id',
                    $student->id
                )
                ->whereDate(
                    'attendance_date',
                    $today
                )
                ->first();


        /*
        |--------------------------------------------------------------------------
        | RENTANG MINGGU INI
        |--------------------------------------------------------------------------
        */

        $startOfWeek =
            now(
                'Asia/Jakarta'
            )
                ->copy()
                ->startOfWeek();


        $endOfWeek =
            now(
                'Asia/Jakarta'
            )
                ->copy()
                ->endOfWeek();


        /*
        |--------------------------------------------------------------------------
        | PRESENSI MINGGU INI
        |--------------------------------------------------------------------------
        */

        $weeklyAttendances =
            Attendance::query()
                ->where(
                    'student_id',
                    $student->id
                )
                ->whereBetween(
                    'attendance_date',
                    [
                        $startOfWeek
                            ->toDateString(),

                        $endOfWeek
                            ->toDateString(),
                    ]
                )
                ->get();


        /*
        |--------------------------------------------------------------------------
        | STATISTIK
        |--------------------------------------------------------------------------
        */

        $weeklyStats = [

            'hadir' =>
                $weeklyAttendances
                    ->whereIn(
                        'status',
                        [
                            'present',
                            'late',
                        ]
                    )
                    ->count(),

            'izin' =>
                $weeklyAttendances
                    ->where(
                        'status',
                        'permission'
                    )
                    ->count(),

            'sakit' =>
                $weeklyAttendances
                    ->where(
                        'status',
                        'sick'
                    )
                    ->count(),

            'alfa' =>
                $weeklyAttendances
                    ->where(
                        'status',
                        'absent'
                    )
                    ->count(),

        ];


        /*
        |--------------------------------------------------------------------------
        | NOTIFIKASI TERBARU
        |--------------------------------------------------------------------------
        */

        $notifications =
            auth()
                ->user()
                ->notifications()
                ->latest()
                ->limit(8)
                ->get();


        /*
        |--------------------------------------------------------------------------
        | NOTIFIKASI BELUM DIBACA
        |--------------------------------------------------------------------------
        */

        $unreadNotificationCount =
            auth()
                ->user()
                ->unreadNotifications()
                ->count();


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'siswa.dashboard',
            compact(
                'student',
                'todayAttendance',
                'weeklyStats',
                'notifications',
                'unreadNotificationCount'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | TANDAI SEMUA NOTIFIKASI SUDAH DIBACA
    |--------------------------------------------------------------------------
    */

    public function markNotificationsRead(): JsonResponse
    {
        /*
        |--------------------------------------------------------------------------
        | MARK AS READ
        |--------------------------------------------------------------------------
        */

        auth()
            ->user()
            ->unreadNotifications
            ->markAsRead();


        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */

        return response()
            ->json([
                'success' => true,
            ]);
    }
}