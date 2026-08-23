<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MonthlyAttendanceRecapController extends Controller
{
    public function index(Request $request)
    {
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


        $month =
            $selectedMonth->format('Y-m');


        /*
        |--------------------------------------------------------------------------
        | SISWA AKTIF
        |--------------------------------------------------------------------------
        */

        $students = Student::with([
                'user',
                'class',
            ])
            ->where('status', 'active')
            ->get()
            ->sortBy(
                fn ($student) =>
                    strtolower(
                        $student->user?->name ?? ''
                    )
            )
            ->values();


        /*
        |--------------------------------------------------------------------------
        | SEMUA PRESENSI BULAN TERPILIH
        |--------------------------------------------------------------------------
        */

        $attendances = Attendance::whereYear(
                'attendance_date',
                $selectedMonth->year
            )
            ->whereMonth(
                'attendance_date',
                $selectedMonth->month
            )
            ->get()
            ->groupBy('student_id');


        /*
        |--------------------------------------------------------------------------
        | REKAP PER SISWA
        |--------------------------------------------------------------------------
        */

        $recaps = $students->map(
            function ($student) use ($attendances) {

                $studentAttendances =
                    $attendances->get(
                        $student->id,
                        collect()
                    );


                $present =
                    $studentAttendances
                        ->where('status', 'present')
                        ->count();


                $late =
                    $studentAttendances
                        ->where('status', 'late')
                        ->count();


                $sick =
                    $studentAttendances
                        ->where('status', 'sick')
                        ->count();


                $permission =
                    $studentAttendances
                        ->where('status', 'permission')
                        ->count();


                $absent =
                    $studentAttendances
                        ->where('status', 'absent')
                        ->count();


                $total =
                    $studentAttendances->count();


                $attendanceRate =
                    $total > 0
                        ? round(
                            (($present + $late) / $total) * 100
                        )
                        : 0;


                return [
                    'student' => $student,

                    'present' => $present,

                    'late' => $late,

                    'sick' => $sick,

                    'permission' => $permission,

                    'absent' => $absent,

                    'total' => $total,

                    'attendance_rate' =>
                        $attendanceRate,
                ];

            }
        );


        /*
        |--------------------------------------------------------------------------
        | TOTAL KESELURUHAN
        |--------------------------------------------------------------------------
        */

        $summary = [

            'students' =>
                $students->count(),

            'present' =>
                $recaps->sum('present'),

            'late' =>
                $recaps->sum('late'),

            'sick' =>
                $recaps->sum('sick'),

            'permission' =>
                $recaps->sum('permission'),

            'absent' =>
                $recaps->sum('absent'),

        ];


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'guru.monthly-attendance-recap.index',
            compact(
                'selectedMonth',
                'month',
                'recaps',
                'summary'
            )
        );
    }
}