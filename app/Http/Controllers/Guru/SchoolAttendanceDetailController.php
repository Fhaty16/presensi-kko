<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SchoolAttendanceDetailController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DETAIL RIWAYAT PRESENSI SEKOLAH PER SISWA
    |--------------------------------------------------------------------------
    */

    public function show(
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
        | LOAD DATA SISWA
        |--------------------------------------------------------------------------
        */

        $student->load([
            'user',
            'class',
        ]);


        /*
        |--------------------------------------------------------------------------
        | WAKTU SEKARANG
        |--------------------------------------------------------------------------
        */

        $now =
            now(
                'Asia/Jakarta'
            );


        /*
        |--------------------------------------------------------------------------
        | BULAN
        |--------------------------------------------------------------------------
        */

        $selectedMonth =
            (int) $request->query(
                'month',
                $now->month
            );


        if (
            $selectedMonth < 1
            ||
            $selectedMonth > 12
        ) {
            $selectedMonth =
                $now->month;
        }


        /*
        |--------------------------------------------------------------------------
        | TAHUN
        |--------------------------------------------------------------------------
        */

        $selectedYear =
            (int) $request->query(
                'year',
                $now->year
            );


        if (
            $selectedYear < 2020
            ||
            $selectedYear > 2100
        ) {
            $selectedYear =
                $now->year;
        }


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
        | TAHUN TERSEDIA
        |--------------------------------------------------------------------------
        */

        $availableYears = [
            $now->year + 1,
            $now->year,
            $now->year - 1,
            $now->year - 2,
            $now->year - 3,
            $now->year - 4,
        ];


        /*
        |--------------------------------------------------------------------------
        | SEMUA PRESENSI PADA BULAN TERPILIH
        |--------------------------------------------------------------------------
        |
        | Digunakan untuk menentukan hari presensi sekolah yang benar-benar
        | tercatat di sistem pada bulan tersebut.
        |
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
        | PRESENSI SISWA BERDASARKAN TANGGAL
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
        | SUSUN RIWAYAT
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
                        /*
                        |--------------------------------------------------------------------------
                        | DATA PRESENSI
                        |--------------------------------------------------------------------------
                        */

                        $attendance =
                            $attendanceByDate
                                ->get(
                                    $date
                                );


                        /*
                        |--------------------------------------------------------------------------
                        | STATUS
                        |--------------------------------------------------------------------------
                        */

                        $status =
                            $attendance?->status;


                        /*
                        |--------------------------------------------------------------------------
                        | LABEL STATUS
                        |--------------------------------------------------------------------------
                        */

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


                        /*
                        |--------------------------------------------------------------------------
                        | CLASS STATUS
                        |--------------------------------------------------------------------------
                        */

                        $statusClass =
                            match ($status) {
                                'present' =>
                                    'present',

                                'late' =>
                                    'late',

                                'permission' =>
                                    'permission',

                                'sick' =>
                                    'sick',

                                'absent' =>
                                    'absent',

                                default =>
                                    'not-yet',
                            };


                        /*
                        |--------------------------------------------------------------------------
                        | JAM MASUK
                        |--------------------------------------------------------------------------
                        */

                        $checkInTime =
                            $attendance?->checked_in_at
                                ? Carbon::parse(
                                    $attendance->checked_in_at,
                                    'Asia/Jakarta'
                                )->format(
                                    'H:i'
                                )
                                : null;


                        /*
                        |--------------------------------------------------------------------------
                        | RETURN
                        |--------------------------------------------------------------------------
                        */

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

                            'status_class' =>
                                $statusClass,

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
        | STATISTIK SISWA
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


        /*
        |--------------------------------------------------------------------------
        | BELUM TERCATAT
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | TOTAL HADIR
        |--------------------------------------------------------------------------
        */

        $attended =
            $present
            +
            $late;


        /*
        |--------------------------------------------------------------------------
        | PERSENTASE
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | SUMMARY
        |--------------------------------------------------------------------------
        */

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
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'guru.attendance-recap.student-detail',
            compact(
                'student',
                'selectedMonth',
                'selectedYear',
                'monthNames',
                'availableYears',
                'attendanceDates',
                'history',
                'summary'
            )
        );
    }
}