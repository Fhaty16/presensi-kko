<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\TrainingSession;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentSportController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | VALIDASI ROLE
    |--------------------------------------------------------------------------
    |
    | Halaman ini hanya boleh diakses oleh:
    |
    | - Guru
    | - Pelatih
    |
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
    | HALAMAN DATA CABANG SISWA
    |--------------------------------------------------------------------------
    */

    public function index(
        Request $request
    ): View {
        $this->authorizeRole();


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
        | DAFTAR CABANG
        |--------------------------------------------------------------------------
        */

        $sports =
            $this->sports();


        /*
        |--------------------------------------------------------------------------
        | CABANG YANG DIPILIH
        |--------------------------------------------------------------------------
        */

        $selectedSport =
            $request->query(
                'sport'
            );


        /*
        |--------------------------------------------------------------------------
        | VALIDASI CABANG
        |--------------------------------------------------------------------------
        */

        if (
            $selectedSport !== null
            && !in_array(
                $selectedSport,
                $sports,
                true
            )
        ) {
            abort(
                404,
                'Cabang olahraga tidak ditemukan.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | TAB
        |--------------------------------------------------------------------------
        |
        | data
        | rekap
        |
        */

        $activeTab =
            $request->query(
                'tab',
                'data'
            );


        if (
            !in_array(
                $activeTab,
                [
                    'data',
                    'rekap',
                ],
                true
            )
        ) {
            $activeTab =
                'data';
        }


        /*
        |--------------------------------------------------------------------------
        | REKAP HANYA ADA JIKA CABANG DIPILIH
        |--------------------------------------------------------------------------
        */

        if (!$selectedSport) {
            $activeTab =
                'data';
        }


        /*
        |--------------------------------------------------------------------------
        | BULAN REKAP
        |--------------------------------------------------------------------------
        */

        $selectedMonth =
            (int) $request->query(
                'month',
                $now->month
            );


        if (
            $selectedMonth < 1
            || $selectedMonth > 12
        ) {
            $selectedMonth =
                $now->month;
        }


        /*
        |--------------------------------------------------------------------------
        | TAHUN REKAP
        |--------------------------------------------------------------------------
        */

        $selectedYear =
            (int) $request->query(
                'year',
                $now->year
            );


        if (
            $selectedYear < 2020
            || $selectedYear > 2100
        ) {
            $selectedYear =
                $now->year;
        }


        /*
        |--------------------------------------------------------------------------
        | PILIHAN TAHUN
        |--------------------------------------------------------------------------
        */

        $availableYears =
            range(
                $now->year + 1,
                $now->year - 4
            );


        /*
        |--------------------------------------------------------------------------
        | SEMUA SISWA AKTIF
        |--------------------------------------------------------------------------
        */

        $allStudents =
            Student::query()
                ->with([
                    'user',
                    'class',
                ])
                ->where(
                    'status',
                    'active'
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
        | STATISTIK CABANG OLAHRAGA
        |--------------------------------------------------------------------------
        */

        $sportStats =
            [];


        foreach (
            $sports
            as $sport
        ) {
            $sportStats[$sport] =
                $allStudents
                    ->where(
                        'sport',
                        $sport
                    )
                    ->count();
        }


        /*
        |--------------------------------------------------------------------------
        | BELUM DITENTUKAN
        |--------------------------------------------------------------------------
        */

        $sportStats['Belum Ditentukan'] =
            $allStudents
                ->filter(
                    fn ($student) =>
                        empty(
                            $student->sport
                        )
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | FILTER SISWA BERDASARKAN CABANG
        |--------------------------------------------------------------------------
        */

        $students =
            $selectedSport
                ? $allStudents
                    ->where(
                        'sport',
                        $selectedSport
                    )
                    ->values()
                : $allStudents;


        /*
        |--------------------------------------------------------------------------
        | TOTAL SISWA AKTIF
        |--------------------------------------------------------------------------
        */

        $totalActiveStudents =
            $allStudents
                ->count();


        /*
        |--------------------------------------------------------------------------
        | DEFAULT DATA REKAP
        |--------------------------------------------------------------------------
        */

        $trainingSessions =
            collect();


        $studentRecaps =
            collect();


        $recapStats = [

            'sessions' =>
                0,

            'present' =>
                0,

            'late' =>
                0,

            'permission' =>
                0,

            'sick' =>
                0,

            'absent' =>
                0,

            'attended' =>
                0,

            'percentage' =>
                0,

        ];


        /*
        |--------------------------------------------------------------------------
        | REKAP PRESENSI CABANG
        |--------------------------------------------------------------------------
        */

        if (
            $selectedSport
            && $activeTab === 'rekap'
        ) {

            /*
            |--------------------------------------------------------------------------
            | AMBIL SESI LATIHAN
            |--------------------------------------------------------------------------
            */

            $trainingSessions =
                TrainingSession::query()
                    ->with([
                        'attendances',
                    ])
                    ->where(
                        'sport',
                        $selectedSport
                    )
                    ->whereYear(
                        'training_date',
                        $selectedYear
                    )
                    ->whereMonth(
                        'training_date',
                        $selectedMonth
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

            $trainingSessions =
                $trainingSessions
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
                                )->format(
                                    'Y-m-d'
                                );


                            $startTime =
                                Carbon::parse(
                                    $session->start_time,
                                    'Asia/Jakarta'
                                )->format(
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
                $trainingSessions
                    ->count();


            /*
            |--------------------------------------------------------------------------
            | ID SISWA CABANG
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
                $trainingSessions
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
            | HADIR
            |--------------------------------------------------------------------------
            */

            $presentCount =
                $allAttendances
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

            $lateCount =
                $allAttendances
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

            $permissionCount =
                $allAttendances
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

            $sickCount =
                $allAttendances
                    ->where(
                        'status',
                        'sick'
                    )
                    ->count();


            /*
            |--------------------------------------------------------------------------
            | ALFA
            |--------------------------------------------------------------------------
            |
            | Alfa hanya dihitung berdasarkan record absent yang
            | benar-benar tersimpan di database.
            |
            */

            $absentCount =
                $allAttendances
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

            $attendedCount =
                $presentCount
                +
                $lateCount;


            /*
            |--------------------------------------------------------------------------
            | JUMLAH PRESENSI YANG SEHARUSNYA ADA
            |--------------------------------------------------------------------------
            */

            $expectedAttendanceCount =
                $totalSessions
                *
                $students->count();


            /*
            |--------------------------------------------------------------------------
            | PERSENTASE KEHADIRAN CABANG
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
            | STATISTIK REKAP
            |--------------------------------------------------------------------------
            */

            $recapStats = [

                'sessions' =>
                    $totalSessions,

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

                'attended' =>
                    $attendedCount,

                'percentage' =>
                    $overallPercentage,

            ];


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
                            | TOTAL DATANG
                            |--------------------------------------------------------------------------
                            */

                            $attended =
                                $present
                                +
                                $late;


                            /*
                            |--------------------------------------------------------------------------
                            | PERSENTASE KEHADIRAN
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

                                'percentage' =>
                                    $percentage,

                            ];
                        }
                    )
                    ->values();
        }


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'students.sports',
            compact(
                'students',
                'sports',
                'sportStats',
                'selectedSport',
                'totalActiveStudents',
                'activeTab',
                'selectedMonth',
                'selectedYear',
                'availableYears',
                'trainingSessions',
                'studentRecaps',
                'recapStats'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DETAIL RIWAYAT PRESENSI SISWA
    |--------------------------------------------------------------------------
    */

    public function attendanceDetail(
        Request $request,
        Student $student
    ): View {
        $this->authorizeRole();


        /*
        |--------------------------------------------------------------------------
        | SISWA HARUS AKTIF
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $student->status === 'active',
            404,
            'Siswa tidak ditemukan.'
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
        | CABANG SISWA
        |--------------------------------------------------------------------------
        */

        $sport =
            $student->sport;


        if (
            !$sport
            || !in_array(
                $sport,
                $this->sports(),
                true
            )
        ) {
            abort(
                404,
                'Cabang olahraga siswa tidak ditemukan.'
            );
        }


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
            || $selectedMonth > 12
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
            || $selectedYear > 2100
        ) {
            $selectedYear =
                $now->year;
        }


        /*
        |--------------------------------------------------------------------------
        | AMBIL SESI LATIHAN
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
                    $selectedYear
                )
                ->whereMonth(
                    'training_date',
                    $selectedMonth
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
        | HANYA SESI YANG SUDAH LEWAT BATAS +30 MENIT
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
                            )->format(
                                'Y-m-d'
                            );


                        $startTime =
                            Carbon::parse(
                                $session->start_time,
                                'Asia/Jakarta'
                            )->format(
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


                        return $now->gt(
                            $startsAt
                                ->copy()
                                ->addMinutes(
                                    30
                                )
                        );
                    }
                )
                ->values();


        /*
        |--------------------------------------------------------------------------
        | RIWAYAT PER SESI
        |--------------------------------------------------------------------------
        */

        $history =
            $sessions
                ->map(
                    function (
                        TrainingSession $session
                    ) use (
                        $student
                    ) {
                        $attendance =
                            $session
                                ->attendances
                                ->firstWhere(
                                    'student_id',
                                    $student->id
                                );


                        return [

                            'session' =>
                                $session,

                            'attendance' =>
                                $attendance,

                            'status' =>
                                $attendance?->status,

                            'checked_in_at' =>
                                $attendance?->checked_in_at,

                            'notes' =>
                                $attendance?->notes,

                        ];
                    }
                )
                ->values();


        /*
        |--------------------------------------------------------------------------
        | HITUNG STATISTIK
        |--------------------------------------------------------------------------
        */

        $present =
            $history
                ->where(
                    'status',
                    'present'
                )
                ->count();


        $late =
            $history
                ->where(
                    'status',
                    'late'
                )
                ->count();


        $permission =
            $history
                ->where(
                    'status',
                    'permission'
                )
                ->count();


        $sick =
            $history
                ->where(
                    'status',
                    'sick'
                )
                ->count();


        $absent =
            $history
                ->where(
                    'status',
                    'absent'
                )
                ->count();


        $attended =
            $present
            +
            $late;


        $totalSessions =
            $sessions
                ->count();


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


        /*
        |--------------------------------------------------------------------------
        | STATISTIK
        |--------------------------------------------------------------------------
        */

        $stats = [

            'sessions' =>
                $totalSessions,

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


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'students.attendance-detail',
            compact(
                'student',
                'sport',
                'selectedMonth',
                'selectedYear',
                'history',
                'stats'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE CABANG SISWA
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Student $student
    ): RedirectResponse {
        $this->authorizeRole();


        /*
        |--------------------------------------------------------------------------
        | SISWA HARUS AKTIF
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $student->status === 'active',
            422,
            'Siswa tidak aktif dan tidak dapat diubah.'
        );


        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $validated =
            $request->validate([

                'sport' => [
                    'required',
                    'string',
                    'in:Atletik,Bola Basket,Sepak Bola,Bola Voli',
                ],

                'current_filter' => [
                    'nullable',
                    'string',
                    'in:Atletik,Bola Basket,Sepak Bola,Bola Voli',
                ],

            ]);


        /*
        |--------------------------------------------------------------------------
        | UPDATE CABANG
        |--------------------------------------------------------------------------
        */

        $student->update([
            'sport' =>
                $validated['sport'],
        ]);


        /*
        |--------------------------------------------------------------------------
        | PARAMETER REDIRECT
        |--------------------------------------------------------------------------
        */

        $routeParameters =
            [];


        if (
            !empty(
                $validated['current_filter']
            )
        ) {
            $routeParameters['sport'] =
                $validated[
                    'current_filter'
                ];

            $routeParameters['tab'] =
                'data';
        }


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'students.sports.index',
                $routeParameters
            )
            ->with(
                'success',
                'Cabang olahraga '
                . (
                    $student
                        ->user?->name
                    ?? 'siswa'
                )
                . ' berhasil diubah menjadi '
                . $validated['sport']
                . '.'
            );
    }
}