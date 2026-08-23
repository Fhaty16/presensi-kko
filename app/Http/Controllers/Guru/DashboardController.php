<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        $totalSiswa = Student::where('status', 'active')->count();

        $hadir = Attendance::whereDate('attendance_date', $today)
            ->whereIn('status', ['present', 'late'])
            ->count();

        $sakit = Attendance::whereDate('attendance_date', $today)
            ->where('status', 'sick')
            ->count();

        $izin = Attendance::whereDate('attendance_date', $today)
            ->where('status', 'permission')
            ->count();

        $alfa = Attendance::whereDate('attendance_date', $today)
            ->where('status', 'absent')
            ->count();

        $persentaseHadir = $totalSiswa > 0
            ? round(($hadir / $totalSiswa) * 100)
            : 0;

        return view('guru.dashboard', compact(
            'totalSiswa',
            'hadir',
            'sakit',
            'izin',
            'alfa',
            'persentaseHadir'
        ));
    }
}