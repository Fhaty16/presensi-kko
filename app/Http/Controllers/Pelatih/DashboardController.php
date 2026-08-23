<?php

namespace App\Http\Controllers\Pelatih;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        // Total siswa aktif
        $totalSiswa = Student::where('status', 'active')->count();

        // Jumlah siswa yang sudah memiliki data presensi hari ini
        $sudahPresensi = Attendance::whereDate('attendance_date', $today)
            ->distinct()
            ->count('student_id');

        // Hadir + terlambat tetap dianggap hadir
        $hadirHariIni = Attendance::whereDate('attendance_date', $today)
            ->whereIn('status', ['present', 'late'])
            ->distinct()
            ->count('student_id');

        // Izin + sakit
        $izinSakitHariIni = Attendance::whereDate('attendance_date', $today)
            ->whereIn('status', ['permission', 'sick'])
            ->distinct()
            ->count('student_id');

        // Siswa aktif yang belum memiliki data presensi
        $belumPresensi = max($totalSiswa - $sudahPresensi, 0);

        // Presensi terbaru hari ini
        $presensiTerbaru = Attendance::with([
                'student.user',
                'student.class'
            ])
            ->whereDate('attendance_date', $today)
            ->orderByDesc('check_in_time')
            ->limit(6)
            ->get();

        // Rekap jumlah siswa per kelas
        $rekapKelas = Student::with('class')
            ->where('status', 'active')
            ->get()
            ->groupBy('class_id');

        return view('pelatih.dashboard', compact(
            'totalSiswa',
            'hadirHariIni',
            'izinSakitHariIni',
            'belumPresensi',
            'presensiTerbaru',
            'rekapKelas'
        ));
    }
}
