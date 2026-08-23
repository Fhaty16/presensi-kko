<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;

class DashboardController extends Controller
{
    public function index()
    {
        $student = Student::with('class')
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $today = now()->toDateString();

        // Presensi hari ini
        $todayAttendance = Attendance::where('student_id', $student->id)
            ->whereDate('attendance_date', $today)
            ->first();

        // Statistik minggu ini
        $startOfWeek = now()->copy()->startOfWeek();
        $endOfWeek = now()->copy()->endOfWeek();

        $weeklyAttendances = Attendance::where('student_id', $student->id)
            ->whereBetween('attendance_date', [
                $startOfWeek->toDateString(),
                $endOfWeek->toDateString()
            ])
            ->get();

        $weeklyStats = [
            'hadir' => $weeklyAttendances
                ->whereIn('status', ['present', 'late'])
                ->count(),

            'izin' => $weeklyAttendances
                ->where('status', 'permission')
                ->count(),

            'sakit' => $weeklyAttendances
                ->where('status', 'sick')
                ->count(),

            'alfa' => $weeklyAttendances
                ->where('status', 'absent')
                ->count(),
        ];

        return view('siswa.dashboard', compact(
            'student',
            'todayAttendance',
            'weeklyStats'
        ));
    }
}