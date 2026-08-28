<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\News;
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

        $student = Student::with('class')
            ->where(
                'user_id',
                auth()->id()
            )
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | PRESENSI HARI INI
        |--------------------------------------------------------------------------
        */

        $today = now(
            'Asia/Jakarta'
        )->toDateString();


        $todayAttendance = Attendance::query()
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
        | STATISTIK MINGGUAN
        |--------------------------------------------------------------------------
        */

        $startOfWeek = now(
            'Asia/Jakarta'
        )
            ->copy()
            ->startOfWeek();


        $endOfWeek = now(
            'Asia/Jakarta'
        )
            ->copy()
            ->endOfWeek();


        $weeklyAttendances = Attendance::query()
            ->where(
                'student_id',
                $student->id
            )
            ->whereBetween(
                'attendance_date',
                [
                    $startOfWeek->toDateString(),
                    $endOfWeek->toDateString(),
                ]
            )
            ->get();


        $weeklyStats = [
            'hadir' => $weeklyAttendances
                ->whereIn(
                    'status',
                    [
                        'present',
                        'late',
                    ]
                )
                ->count(),

            'izin' => $weeklyAttendances
                ->where(
                    'status',
                    'permission'
                )
                ->count(),

            'sakit' => $weeklyAttendances
                ->where(
                    'status',
                    'sick'
                )
                ->count(),

            'alfa' => $weeklyAttendances
                ->where(
                    'status',
                    'absent'
                )
                ->count(),
        ];


        /*
        |--------------------------------------------------------------------------
        | NOTIFIKASI
        |--------------------------------------------------------------------------
        */

        $notifications = auth()
            ->user()
            ->notifications()
            ->latest()
            ->limit(8)
            ->get();


        $unreadNotificationCount = auth()
            ->user()
            ->unreadNotifications()
            ->count();


        /*
        |--------------------------------------------------------------------------
        | QUERY BERITA PUBLISHED
        |--------------------------------------------------------------------------
        */

        $publishedNewsQuery = News::query()
            ->where(
                'status',
                'published'
            )
            ->whereNotNull(
                'published_at'
            )
            ->where(
                'published_at',
                '<=',
                now(
                    'Asia/Jakarta'
                )
            );


        /*
        |--------------------------------------------------------------------------
        | MAKSIMAL 4 BERITA DI DASHBOARD
        |--------------------------------------------------------------------------
        */

        $latestNews = (clone $publishedNewsQuery)
            ->latest(
                'published_at'
            )
            ->limit(4)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | ADA BERITA LAIN?
        |--------------------------------------------------------------------------
        |
        | Jika jumlah berita Published lebih dari 4,
        | card "Lihat Semua Berita" muncul di ujung carousel.
        |
        */

        $hasMoreNews = (clone $publishedNewsQuery)
            ->count() > 4;


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'siswa.dashboard',
            compact(
                'student',
                'todayAttendance',
                'weeklyStats',
                'notifications',
                'unreadNotificationCount',
                'latestNews',
                'hasMoreNews'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | TANDAI NOTIFIKASI DIBACA
    |--------------------------------------------------------------------------
    */

    public function markNotificationsRead(): JsonResponse
    {
        auth()
            ->user()
            ->unreadNotifications
            ->markAsRead();


        return response()->json([
            'success' => true,
        ]);
    }
}