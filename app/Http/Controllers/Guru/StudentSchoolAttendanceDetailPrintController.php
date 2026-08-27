<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentSchoolAttendanceDetailPrintController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CETAK / PDF DETAIL PRESENSI SEKOLAH SISWA
    |--------------------------------------------------------------------------
    */

    public function __invoke(
        Request $request,
        Student $student
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
        | LOAD SISWA
        |--------------------------------------------------------------------------
        */

        $student->load([
            'user',
            'class',
        ]);


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
        | SEMUA PRESENSI BULAN TERPILIH
        |--------------------------------------------------------------------------
        */

        $allMonthlyAttendances =
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
            $allMonthlyAttendances
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
        | PRESENSI SISWA
        |--------------------------------------------------------------------------
        */

        $studentAttendances =
            Attendance::query()
                ->where(
                    'student_id',
                    $student->id
                )
                ->whereYear(
                    'attendance_date',
                    $selectedYear
                )
                ->whereMonth(
                    'attendance_date',
                    $selectedMonth
                )
                ->orderByDesc(
                    'attendance_date'
                )
                ->get();


        /*
        |--------------------------------------------------------------------------
        | PRESENSI BERDASARKAN TANGGAL
        |--------------------------------------------------------------------------
        */

        $attendanceByDate =
            $studentAttendances
                ->keyBy(
                    function (
                        Attendance $attendance
                    ) {
                        return Carbon::parse(
                            $attendance->attendance_date,
                            'Asia/Jakarta'
                        )->format(
                            'Y-m-d'
                        );
                    }
                );


        /*
        |--------------------------------------------------------------------------
        | RIWAYAT
        |--------------------------------------------------------------------------
        */

        $history =
            $attendanceDates
                ->map(
                    function (
                        string $date
                    ) use (
                        $attendanceByDate
                    ) {
                        $attendance =
                            $attendanceByDate
                                ->get(
                                    $date
                                );


                        $status =
                            $attendance?->status;


                        $statusLabel =
                            match ($status) {
                                'present' =>
                                    'Hadir',

                                'late' =>
                                    'Terlambat',

                                'permission' =>
                                    'Izin',

                                'sick' =>
                                    'Sakit',

                                'absent' =>
                                    'Alfa',

                                default =>
                                    'Belum Tercatat',
                            };


                        $checkInTime =
                            $attendance?->checked_in_at
                                ? Carbon::parse(
                                    $attendance->checked_in_at,
                                    'Asia/Jakarta'
                                )->format(
                                    'H:i'
                                )
                                : null;


                        return [
                            'date' =>
                                $date,

                            'date_object' =>
                                Carbon::parse(
                                    $date,
                                    'Asia/Jakarta'
                                ),

                            'attendance' =>
                                $attendance,

                            'status' =>
                                $status,

                            'status_label' =>
                                $statusLabel,

                            'check_in_time' =>
                                $checkInTime,
                        ];
                    }
                )
                ->sortByDesc(
                    'date'
                )
                ->values();


        /*
        |--------------------------------------------------------------------------
        | SUMMARY
        |--------------------------------------------------------------------------
        */

        $present =
            $studentAttendances
                ->where(
                    'status',
                    'present'
                )
                ->count();


        $late =
            $studentAttendances
                ->where(
                    'status',
                    'late'
                )
                ->count();


        $permission =
            $studentAttendances
                ->where(
                    'status',
                    'permission'
                )
                ->count();


        $sick =
            $studentAttendances
                ->where(
                    'status',
                    'sick'
                )
                ->count();


        $absent =
            $studentAttendances
                ->where(
                    'status',
                    'absent'
                )
                ->count();


        $recorded =
            $studentAttendances
                ->count();


        $notRecorded =
            max(
                0,
                $attendanceDates->count()
                -
                $recorded
            );


        $attended =
            $present
            +
            $late;


        $attendancePercentage =
            $attendanceDates->count() > 0
                ? round(
                    (
                        $attended
                        /
                        $attendanceDates->count()
                    )
                    *
                    100,
                    1
                )
                : 0;


        $summary = [
            'days' =>
                $attendanceDates->count(),

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

            'not_recorded' =>
                $notRecorded,

            'attended' =>
                $attended,

            'percentage' =>
                $attendancePercentage,
        ];


        /*
        |--------------------------------------------------------------------------
        | PERIODE
        |--------------------------------------------------------------------------
        */

        $period =
            (
                $monthNames[
                    $selectedMonth
                ]
                ?? '-'
            )
            . ' '
            . $selectedYear;


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'guru.attendance-recap.student-detail-print',
            compact(
                'student',
                'selectedMonth',
                'selectedYear',
                'monthNames',
                'period',
                'history',
                'summary'
            )
        );
    }
}