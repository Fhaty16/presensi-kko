<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MonthlySchoolAttendanceRecapPrintController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CETAK / PDF REKAP PRESENSI SEKOLAH BULANAN
    |--------------------------------------------------------------------------
    */

    public function __invoke(
        Request $request
    ): View {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI ROLE
        |--------------------------------------------------------------------------
        */

        abort_unless(
            auth()->check()
            && auth()->user()->role === 'guru',
            403
        );


        /*
        |--------------------------------------------------------------------------
        | VALIDASI PARAMETER
        |--------------------------------------------------------------------------
        */

        $validated =
            $request->validate([
                'month' => [
                    'required',
                    'integer',
                    'between:1,12',
                ],

                'year' => [
                    'required',
                    'integer',
                    'between:2020,2100',
                ],
            ]);


        /*
        |--------------------------------------------------------------------------
        | BULAN & TAHUN
        |--------------------------------------------------------------------------
        */

        $selectedMonth =
            (int) $validated['month'];


        $selectedYear =
            (int) $validated['year'];


        /*
        |--------------------------------------------------------------------------
        | NAMA BULAN
        |--------------------------------------------------------------------------
        */

        $monthNames = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];


        /*
        |--------------------------------------------------------------------------
        | PERIODE
        |--------------------------------------------------------------------------
        */

        $period =
            Carbon::create(
                $selectedYear,
                $selectedMonth,
                1,
                0,
                0,
                0,
                'Asia/Jakarta'
            );


        /*
        |--------------------------------------------------------------------------
        | SISWA AKTIF
        |--------------------------------------------------------------------------
        */

        $students =
            Student::query()
                ->with([
                    'user',
                    'class',
                ])
                ->where(
                    'status',
                    'active'
                )
                ->get()
                ->sortBy(
                    function (
                        Student $student
                    ) {
                        return mb_strtolower(
                            $student->user?->name
                            ?? ''
                        );
                    }
                )
                ->values();


        /*
        |--------------------------------------------------------------------------
        | SEMUA PRESENSI BULAN TERPILIH
        |--------------------------------------------------------------------------
        */

        $monthlyAttendances =
            Attendance::query()
                ->whereYear(
                    'attendance_date',
                    $selectedYear
                )
                ->whereMonth(
                    'attendance_date',
                    $selectedMonth
                )
                ->orderBy(
                    'attendance_date'
                )
                ->get();


        /*
        |--------------------------------------------------------------------------
        | TANGGAL PRESENSI UNIK
        |--------------------------------------------------------------------------
        */

        $attendanceDates =
            $monthlyAttendances
                ->pluck(
                    'attendance_date'
                )
                ->map(
                    function ($date) {
                        return Carbon::parse(
                            $date,
                            'Asia/Jakarta'
                        )->format(
                            'Y-m-d'
                        );
                    }
                )
                ->unique()
                ->sort()
                ->values();


        /*
        |--------------------------------------------------------------------------
        | TOTAL HARI PRESENSI
        |--------------------------------------------------------------------------
        */

        $totalAttendanceDays =
            $attendanceDates
                ->count();


        /*
        |--------------------------------------------------------------------------
        | KELOMPOKKAN PRESENSI PER SISWA
        |--------------------------------------------------------------------------
        */

        $attendancesByStudent =
            $monthlyAttendances
                ->groupBy(
                    'student_id'
                );


        /*
        |--------------------------------------------------------------------------
        | REKAP PER SISWA
        |--------------------------------------------------------------------------
        */

        $recaps =
            $students
                ->map(
                    function (
                        Student $student
                    ) use (
                        $attendancesByStudent,
                        $totalAttendanceDays
                    ) {
                        /*
                        |--------------------------------------------------------------------------
                        | PRESENSI SISWA
                        |--------------------------------------------------------------------------
                        */

                        $studentAttendances =
                            $attendancesByStudent
                                ->get(
                                    $student->id,
                                    collect()
                                );


                        /*
                        |--------------------------------------------------------------------------
                        | HADIR
                        |--------------------------------------------------------------------------
                        */

                        $present =
                            $studentAttendances
                                ->where(
                                    'status',
                                    'present'
                                )
                                ->count();


                        /*
                        |--------------------------------------------------------------------------
                        | TERLAMBAT
                        |--------------------------------------------------------------------------
                        */

                        $late =
                            $studentAttendances
                                ->where(
                                    'status',
                                    'late'
                                )
                                ->count();


                        /*
                        |--------------------------------------------------------------------------
                        | IZIN
                        |--------------------------------------------------------------------------
                        */

                        $permission =
                            $studentAttendances
                                ->where(
                                    'status',
                                    'permission'
                                )
                                ->count();


                        /*
                        |--------------------------------------------------------------------------
                        | SAKIT
                        |--------------------------------------------------------------------------
                        */

                        $sick =
                            $studentAttendances
                                ->where(
                                    'status',
                                    'sick'
                                )
                                ->count();


                        /*
                        |--------------------------------------------------------------------------
                        | ALFA
                        |--------------------------------------------------------------------------
                        */

                        $absent =
                            $studentAttendances
                                ->where(
                                    'status',
                                    'absent'
                                )
                                ->count();


                        /*
                        |--------------------------------------------------------------------------
                        | DATANG
                        |--------------------------------------------------------------------------
                        */

                        $attended =
                            $present
                            +
                            $late;


                        /*
                        |--------------------------------------------------------------------------
                        | JUMLAH RECORD SISWA
                        |--------------------------------------------------------------------------
                        */

                        $recorded =
                            $studentAttendances
                                ->count();


                        /*
                        |--------------------------------------------------------------------------
                        | BELUM TERCATAT
                        |--------------------------------------------------------------------------
                        */

                        $notRecorded =
                            max(
                                0,
                                $totalAttendanceDays
                                -
                                $recorded
                            );


                        /*
                        |--------------------------------------------------------------------------
                        | PERSENTASE KEHADIRAN SISWA
                        |--------------------------------------------------------------------------
                        */

                        $attendanceRate =
                            $totalAttendanceDays > 0
                                ? round(
                                    (
                                        $attended
                                        /
                                        $totalAttendanceDays
                                    )
                                    *
                                    100,
                                    1
                                )
                                : 0;


                        /*
                        |--------------------------------------------------------------------------
                        | RETURN
                        |--------------------------------------------------------------------------
                        */

                        return [
                            'student' =>
                                $student,

                            'present' =>
                                $present,

                            'late' =>
                                $late,

                            'permission' =>
                                $permission,

                            'sick' =>
                                $sick,

                            'absent' =>
                                $absent,

                            'attended' =>
                                $attended,

                            'recorded' =>
                                $recorded,

                            'not_recorded' =>
                                $notRecorded,

                            'total_days' =>
                                $totalAttendanceDays,

                            'attendance_rate' =>
                                $attendanceRate,
                        ];
                    }
                )
                ->values();


        /*
        |--------------------------------------------------------------------------
        | TOTAL SISWA
        |--------------------------------------------------------------------------
        */

        $totalStudents =
            $students
                ->count();


        /*
        |--------------------------------------------------------------------------
        | TOTAL HADIR
        |--------------------------------------------------------------------------
        */

        $totalPresent =
            $recaps
                ->sum(
                    'present'
                );


        /*
        |--------------------------------------------------------------------------
        | TOTAL TERLAMBAT
        |--------------------------------------------------------------------------
        */

        $totalLate =
            $recaps
                ->sum(
                    'late'
                );


        /*
        |--------------------------------------------------------------------------
        | TOTAL IZIN
        |--------------------------------------------------------------------------
        */

        $totalPermission =
            $recaps
                ->sum(
                    'permission'
                );


        /*
        |--------------------------------------------------------------------------
        | TOTAL SAKIT
        |--------------------------------------------------------------------------
        */

        $totalSick =
            $recaps
                ->sum(
                    'sick'
                );


        /*
        |--------------------------------------------------------------------------
        | TOTAL ALFA
        |--------------------------------------------------------------------------
        */

        $totalAbsent =
            $recaps
                ->sum(
                    'absent'
                );


        /*
        |--------------------------------------------------------------------------
        | TOTAL DATANG
        |--------------------------------------------------------------------------
        */

        $totalAttended =
            $totalPresent
            +
            $totalLate;


        /*
        |--------------------------------------------------------------------------
        | TOTAL BELUM TERCATAT
        |--------------------------------------------------------------------------
        */

        $totalNotRecorded =
            $recaps
                ->sum(
                    'not_recorded'
                );


        /*
        |--------------------------------------------------------------------------
        | TOTAL KESEMPATAN PRESENSI
        |--------------------------------------------------------------------------
        */

        $totalOpportunities =
            $totalAttendanceDays
            *
            $totalStudents;


        /*
        |--------------------------------------------------------------------------
        | PERSENTASE KESELURUHAN
        |--------------------------------------------------------------------------
        */

        $overallPercentage =
            $totalOpportunities > 0
                ? round(
                    (
                        $totalAttended
                        /
                        $totalOpportunities
                    )
                    *
                    100,
                    1
                )
                : 0;


        /*
        |--------------------------------------------------------------------------
        | SUMMARY
        |--------------------------------------------------------------------------
        */

        $summary = [
            'students' =>
                $totalStudents,

            'days' =>
                $totalAttendanceDays,

            'present' =>
                $totalPresent,

            'late' =>
                $totalLate,

            'permission' =>
                $totalPermission,

            'sick' =>
                $totalSick,

            'absent' =>
                $totalAbsent,

            'attended' =>
                $totalAttended,

            'not_recorded' =>
                $totalNotRecorded,

            'opportunities' =>
                $totalOpportunities,

            'percentage' =>
                $overallPercentage,
        ];


        /*
        |--------------------------------------------------------------------------
        | VIEW PDF / PRINT
        |--------------------------------------------------------------------------
        */

        return view(
            'guru.attendance-recap.monthly-print',
            compact(
                'period',
                'selectedMonth',
                'selectedYear',
                'monthNames',
                'attendanceDates',
                'recaps',
                'summary'
            )
        );
    }
}