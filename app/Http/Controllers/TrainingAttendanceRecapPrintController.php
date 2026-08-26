<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\TrainingSession;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TrainingAttendanceRecapPrintController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DAFTAR CABANG OLAHRAGA
    |--------------------------------------------------------------------------
    */

    private function sports(): array
    {
        return [
            'Atletik',
            'Bola Basket',
            'Sepak Bola',
            'Bola Voli',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | VALIDASI ROLE
    |--------------------------------------------------------------------------
    */

    private function authorizeRole(): void
    {
        abort_unless(
            auth()->check()
            && in_array(
                auth()->user()->role,
                [
                    'guru',
                    'pelatih',
                ],
                true
            ),
            403
        );
    }


    /*
    |--------------------------------------------------------------------------
    | HALAMAN CETAK REKAP
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

        $this->authorizeRole();


        /*
        |--------------------------------------------------------------------------
        | VALIDASI FILTER
        |--------------------------------------------------------------------------
        */

        $validated =
            $request->validate([
                'sport' => [
                    'required',
                    'string',
                    'in:' . implode(
                        ',',
                        $this->sports()
                    ),
                ],

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
        | FILTER
        |--------------------------------------------------------------------------
        */

        $sport =
            $validated['sport'];

        $month =
            (int) $validated['month'];

        $year =
            (int) $validated['year'];


        /*
        |--------------------------------------------------------------------------
        | WAKTU SEKARANG
        |--------------------------------------------------------------------------
        */

        $now =
            Carbon::now(
                'Asia/Jakarta'
            );


        /*
        |--------------------------------------------------------------------------
        | SISWA AKTIF SESUAI CABANG
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
                ->where(
                    'sport',
                    $sport
                )
                ->orderBy(
                    'class_id'
                )
                ->orderBy(
                    'nis'
                )
                ->get();


        /*
        |--------------------------------------------------------------------------
        | SESI LATIHAN
        |--------------------------------------------------------------------------
        */

        $sessions =
            TrainingSession::query()
                ->with([
                    'attendances',
                ])
                ->where(
                    'sport',
                    $sport
                )
                ->whereYear(
                    'training_date',
                    $year
                )
                ->whereMonth(
                    'training_date',
                    $month
                )
                ->orderBy(
                    'training_date'
                )
                ->orderBy(
                    'start_time'
                )
                ->get();


        /*
        |--------------------------------------------------------------------------
        | HANYA SESI YANG SUDAH LEWAT +30 MENIT
        |--------------------------------------------------------------------------
        */

        $sessions =
            $sessions
                ->filter(
                    function (
                        TrainingSession $session
                    ) use (
                        $now
                    ) {
                        if (
                            !$session->training_date
                            || !$session->start_time
                        ) {
                            return false;
                        }


                        $date =
                            Carbon::parse(
                                $session->training_date
                            )
                                ->format(
                                    'Y-m-d'
                                );


                        $startTime =
                            Carbon::parse(
                                $session->start_time,
                                'Asia/Jakarta'
                            )
                                ->format(
                                    'H:i:s'
                                );


                        $startsAt =
                            Carbon::createFromFormat(
                                'Y-m-d H:i:s',
                                $date
                                . ' '
                                . $startTime,
                                'Asia/Jakarta'
                            );


                        $alphaAt =
                            $startsAt
                                ->copy()
                                ->addMinutes(
                                    30
                                );


                        return $now->gt(
                            $alphaAt
                        );
                    }
                )
                ->values();


        /*
        |--------------------------------------------------------------------------
        | TOTAL SESI
        |--------------------------------------------------------------------------
        */

        $totalSessions =
            $sessions
                ->count();


        /*
        |--------------------------------------------------------------------------
        | ID SISWA
        |--------------------------------------------------------------------------
        */

        $studentIds =
            $students
                ->pluck(
                    'id'
                );


        /*
        |--------------------------------------------------------------------------
        | SEMUA PRESENSI
        |--------------------------------------------------------------------------
        */

        $allAttendances =
            $sessions
                ->flatMap(
                    function (
                        TrainingSession $session
                    ) {
                        return $session
                            ->attendances;
                    }
                )
                ->filter(
                    function (
                        $attendance
                    ) use (
                        $studentIds
                    ) {
                        return $studentIds
                            ->contains(
                                $attendance
                                    ->student_id
                            );
                    }
                )
                ->values();


        /*
        |--------------------------------------------------------------------------
        | REKAP PER SISWA
        |--------------------------------------------------------------------------
        */

        $studentRecaps =
            $students
                ->map(
                    function (
                        Student $student
                    ) use (
                        $allAttendances,
                        $totalSessions
                    ) {
                        /*
                        |--------------------------------------------------------------------------
                        | PRESENSI SISWA
                        |--------------------------------------------------------------------------
                        */

                        $studentAttendances =
                            $allAttendances
                                ->where(
                                    'student_id',
                                    $student->id
                                )
                                ->values();


                        /*
                        |--------------------------------------------------------------------------
                        | HITUNG STATUS
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
                        | TOTAL DATANG
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

                        $percentage =
                            $totalSessions > 0
                                ? round(
                                    (
                                        $attended
                                        /
                                        $totalSessions
                                    )
                                    *
                                    100,
                                    1
                                )
                                : 0;


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

                            'percentage' =>
                                $percentage,
                        ];
                    }
                )
                ->values();


        /*
        |--------------------------------------------------------------------------
        | STATISTIK KESELURUHAN
        |--------------------------------------------------------------------------
        */

        $presentCount =
            $studentRecaps
                ->sum(
                    'present'
                );


        $lateCount =
            $studentRecaps
                ->sum(
                    'late'
                );


        $permissionCount =
            $studentRecaps
                ->sum(
                    'permission'
                );


        $sickCount =
            $studentRecaps
                ->sum(
                    'sick'
                );


        $absentCount =
            $studentRecaps
                ->sum(
                    'absent'
                );


        $attendedCount =
            $presentCount
            +
            $lateCount;


        /*
        |--------------------------------------------------------------------------
        | TOTAL KESEMPATAN PRESENSI
        |--------------------------------------------------------------------------
        */

        $expectedAttendanceCount =
            $totalSessions
            *
            $students->count();


        /*
        |--------------------------------------------------------------------------
        | PERSENTASE KESELURUHAN
        |--------------------------------------------------------------------------
        */

        $overallPercentage =
            $expectedAttendanceCount > 0
                ? round(
                    (
                        $attendedCount
                        /
                        $expectedAttendanceCount
                    )
                    *
                    100,
                    1
                )
                : 0;


        /*
        |--------------------------------------------------------------------------
        | STATISTIK
        |--------------------------------------------------------------------------
        */

        $stats = [
            'sessions' =>
                $totalSessions,

            'students' =>
                $students->count(),

            'present' =>
                $presentCount,

            'late' =>
                $lateCount,

            'permission' =>
                $permissionCount,

            'sick' =>
                $sickCount,

            'absent' =>
                $absentCount,

            'percentage' =>
                $overallPercentage,
        ];


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
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'students.training-attendance-print',
            compact(
                'sport',
                'month',
                'year',
                'monthNames',
                'sessions',
                'studentRecaps',
                'stats'
            )
        );
    }
}