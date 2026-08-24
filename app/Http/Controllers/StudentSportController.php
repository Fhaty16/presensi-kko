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
    | CEK AKSES
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
        |
        | Rekap hanya dihitung jika:
        |
        | - cabang olahraga dipilih
        | - tab Rekap dibuka
        |
        */

        if (
            $selectedSport
            && $activeTab === 'rekap'
        ) {

            /*
            |--------------------------------------------------------------------------
            | AMBIL SEMUA SESI PADA BULAN & TAHUN
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
            | HANYA SESI YANG SUDAH LEWAT BATAS ALFA +30 MENIT
            |--------------------------------------------------------------------------
            |
            | Sesi yang masih berlangsung atau belum dimulai tidak ikut
            | dihitung agar siswa tidak langsung dianggap Alfa.
            |
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
            | SEMUA PRESENSI DARI SESI TERPILIH
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
            | STATISTIK HADIR
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
            | STATISTIK TERLAMBAT
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
            | STATISTIK IZIN
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
            | STATISTIK SAKIT
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
            | ALFA TERCATAT
            |--------------------------------------------------------------------------
            */

            $explicitAbsentCount =
                $allAttendances
                    ->where(
                        'status',
                        'absent'
                    )
                    ->count();


            /*
            |--------------------------------------------------------------------------
            | PRESENSI YANG SEHARUSNYA ADA
            |--------------------------------------------------------------------------
            |
            | Contoh:
            |
            | 10 siswa
            | 4 sesi
            |
            | Total yang seharusnya = 40 record presensi.
            |
            */

            $expectedAttendanceCount =
                $totalSessions
                *
                $students->count();


            /*
            |--------------------------------------------------------------------------
            | PRESENSI YANG BELUM MEMILIKI RECORD
            |--------------------------------------------------------------------------
            |
            | Karena sesi sudah lewat +30 menit, siswa yang tidak memiliki
            | record tetap dianggap Alfa dalam laporan.
            |
            */

            $missingAttendanceCount =
                max(
                    0,
                    $expectedAttendanceCount
                    -
                    $allAttendances
                        ->count()
                );


            /*
            |--------------------------------------------------------------------------
            | TOTAL ALFA
            |--------------------------------------------------------------------------
            */

            $absentCount =
                $explicitAbsentCount
                +
                $missingAttendanceCount;


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
                            | ALFA YANG TERCATAT
                            |--------------------------------------------------------------------------
                            */

                            $explicitAbsent =
                                $studentAttendances
                                    ->where(
                                        'status',
                                        'absent'
                                    )
                                    ->count();


                            /*
                            |--------------------------------------------------------------------------
                            | RECORD YANG BELUM ADA
                            |--------------------------------------------------------------------------
                            */

                            $missing =
                                max(
                                    0,
                                    $totalSessions
                                    -
                                    $studentAttendances
                                        ->count()
                                );


                            /*
                            |--------------------------------------------------------------------------
                            | TOTAL ALFA SISWA
                            |--------------------------------------------------------------------------
                            */

                            $absent =
                                $explicitAbsent
                                +
                                $missing;


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