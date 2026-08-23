<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceHistoryController extends Controller
{
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | SISWA LOGIN
        |--------------------------------------------------------------------------
        */

        $student = Student::with([
                'user',
                'class',
            ])
            ->where('user_id', auth()->id())
            ->where('status', 'active')
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | BULAN YANG DIPILIH
        |--------------------------------------------------------------------------
        */

        $monthInput = $request->query('month');

        try {
            $selectedMonth = $monthInput
                ? Carbon::createFromFormat(
                    'Y-m',
                    $monthInput,
                    'Asia/Jakarta'
                )->startOfMonth()
                : Carbon::now('Asia/Jakarta')->startOfMonth();
        } catch (\Throwable $e) {
            $selectedMonth =
                Carbon::now('Asia/Jakarta')->startOfMonth();
        }

        $month = $selectedMonth->format('Y-m');


        /*
        |--------------------------------------------------------------------------
        | RIWAYAT PRESENSI
        |--------------------------------------------------------------------------
        */

        $attendances = Attendance::where(
                'student_id',
                $student->id
            )
            ->whereYear(
                'attendance_date',
                $selectedMonth->year
            )
            ->whereMonth(
                'attendance_date',
                $selectedMonth->month
            )
            ->orderByDesc('attendance_date')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | STATISTIK
        |--------------------------------------------------------------------------
        */

        $hadir = $attendances
            ->where('status', 'present')
            ->count();

        $terlambat = $attendances
            ->where('status', 'late')
            ->count();

        $sakit = $attendances
            ->where('status', 'sick')
            ->count();

        $izin = $attendances
            ->where('status', 'permission')
            ->count();

        $alfa = $attendances
            ->where('status', 'absent')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'siswa.attendance-history',
            compact(
                'student',
                'attendances',
                'selectedMonth',
                'month',
                'hadir',
                'terlambat',
                'sakit',
                'izin',
                'alfa'
            )
        );
    }
}