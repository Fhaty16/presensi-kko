<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\TrainingSession;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttendanceHistoryController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | RIWAYAT PRESENSI SISWA
    |--------------------------------------------------------------------------
    |
    | Satu halaman untuk:
    |
    | - Presensi Sekolah
    | - Presensi Latihan KKO
    |
    | Pemilihan tab menggunakan query:
    |
    | ?type=school
    | ?type=training
    |
    */

    public function index(
        Request $request
    ): View {

        /*
        |--------------------------------------------------------------------------
        | SISWA LOGIN
        |--------------------------------------------------------------------------
        */

        $student =
            Student::query()
                ->with([
                    'user',
                    'class',
                ])
                ->where(
                    'user_id',
                    auth()->id()
                )
                ->where(
                    'status',
                    'active'
                )
                ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | TAB AKTIF
        |--------------------------------------------------------------------------
        |
        | school   = Presensi Sekolah
        | training = Presensi Latihan
        |
        */

        $activeType =
            $request->query(
                'type',
                'school'
            );


        if (
            !in_array(
                $activeType,
                [
                    'school',
                    'training',
                ],
                true
            )
        ) {
            $activeType =
                'school';
        }


        /*
        |--------------------------------------------------------------------------
        | BULAN YANG DIPILIH
        |--------------------------------------------------------------------------
        */

        $monthInput =
            $request->query(
                'month'
            );


        try {

            $selectedMonth =
                $monthInput
                    ? Carbon::createFromFormat(
                        'Y-m',
                        $monthInput,
                        'Asia/Jakarta'
                    )
                        ->startOfMonth()
                    : Carbon::now(
                        'Asia/Jakarta'
                    )
                        ->startOfMonth();

        } catch (\Throwable $e) {

            $selectedMonth =
                Carbon::now(
                    'Asia/Jakarta'
                )
                    ->startOfMonth();
        }


        /*
        |--------------------------------------------------------------------------
        | VALUE INPUT BULAN
        |--------------------------------------------------------------------------
        */

        $month =
            $selectedMonth
                ->format(
                    'Y-m'
                );


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
        | ================================================================
        | PRESENSI SEKOLAH
        | ================================================================
        |--------------------------------------------------------------------------
        */


        /*
        |--------------------------------------------------------------------------
        | RIWAYAT PRESENSI SEKOLAH
        |--------------------------------------------------------------------------
        */

        $schoolAttendances =
            Attendance::query()
                ->where(
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
                ->orderByDesc(
                    'attendance_date'
                )
                ->get();


        /*
        |--------------------------------------------------------------------------
        | HADIR SEKOLAH
        |--------------------------------------------------------------------------
        */

        $schoolPresent =
            $schoolAttendances
                ->where(
                    'status',
                    'present'
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | TERLAMBAT SEKOLAH
        |--------------------------------------------------------------------------
        */

        $schoolLate =
            $schoolAttendances
                ->where(
                    'status',
                    'late'
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | SAKIT SEKOLAH
        |--------------------------------------------------------------------------
        */

        $schoolSick =
            $schoolAttendances
                ->where(
                    'status',
                    'sick'
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | IZIN SEKOLAH
        |--------------------------------------------------------------------------
        */

        $schoolPermission =
            $schoolAttendances
                ->where(
                    'status',
                    'permission'
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | ALFA SEKOLAH
        |--------------------------------------------------------------------------
        */

        $schoolAbsent =
            $schoolAttendances
                ->where(
                    'status',
                    'absent'
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | STATISTIK SEKOLAH
        |--------------------------------------------------------------------------
        */

        $schoolStats = [

            'present' =>
                $schoolPresent,

            'late' =>
                $schoolLate,

            'sick' =>
                $schoolSick,

            'permission' =>
                $schoolPermission,

            'absent' =>
                $schoolAbsent,

            'total' =>
                $schoolAttendances
                    ->count(),

        ];


        /*
        |--------------------------------------------------------------------------
        | ================================================================
        | PRESENSI LATIHAN
        | ================================================================
        |--------------------------------------------------------------------------
        */


        /*
        |--------------------------------------------------------------------------
        | CABANG OLAHRAGA SISWA
        |--------------------------------------------------------------------------
        */

        $sport =
            $student->sport;


        /*
        |--------------------------------------------------------------------------
        | DEFAULT SESI & RIWAYAT LATIHAN
        |--------------------------------------------------------------------------
        */

        $trainingSessions =
            collect();


        $trainingHistory =
            collect();


        $trainingStats = [

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
        | JIKA SISWA MEMILIKI CABANG OLAHRAGA
        |--------------------------------------------------------------------------
        */

        if ($sport) {

            /*
            |--------------------------------------------------------------------------
            | AMBIL SESI LATIHAN SESUAI CABANG & BULAN
            |--------------------------------------------------------------------------
            */

            $trainingSessions =
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
                        $selectedMonth->year
                    )
                    ->whereMonth(
                        'training_date',
                        $selectedMonth->month
                    )
                    ->orderBy(
                        'training_date',
                        'desc'
                    )
                    ->orderBy(
                        'start_time',
                        'desc'
                    )
                    ->get();


            /*
            |--------------------------------------------------------------------------
            | HANYA SESI YANG SUDAH LEWAT BATAS +30 MENIT
            |--------------------------------------------------------------------------
            |
            | Contoh:
            |
            | Mulai latihan : 14:00
            |
            | Sampai:
            |
            | 14:30:00
            |
            | masih dalam periode presensi.
            |
            | Setelah melewati batas tersebut, sesi masuk ke riwayat final.
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


                            $trainingDate =
                                Carbon::parse(
                                    $session->training_date
                                )
                                    ->format(
                                        'Y-m-d'
                                    );


                            $startTime =
                                Carbon::parse(
                                    $session->start_time
                                )
                                    ->format(
                                        'H:i:s'
                                    );


                            $startsAt =
                                Carbon::createFromFormat(
                                    'Y-m-d H:i:s',
                                    $trainingDate
                                    . ' '
                                    . $startTime,
                                    'Asia/Jakarta'
                                );


                            $attendanceClosesAt =
                                $startsAt
                                    ->copy()
                                    ->addMinutes(
                                        30
                                    );


                            return $now->gt(
                                $attendanceClosesAt
                            );
                        }
                    )
                    ->values();


            /*
            |--------------------------------------------------------------------------
            | RIWAYAT LATIHAN PER SESI
            |--------------------------------------------------------------------------
            */

            $trainingHistory =
                $trainingSessions
                    ->map(
                        function (
                            TrainingSession $session
                        ) use (
                            $student
                        ) {

                            /*
                            |--------------------------------------------------------------------------
                            | PRESENSI SISWA PADA SESI
                            |--------------------------------------------------------------------------
                            */

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
            | HADIR LATIHAN
            |--------------------------------------------------------------------------
            */

            $trainingPresent =
                $trainingHistory
                    ->where(
                        'status',
                        'present'
                    )
                    ->count();


            /*
            |--------------------------------------------------------------------------
            | TERLAMBAT LATIHAN
            |--------------------------------------------------------------------------
            */

            $trainingLate =
                $trainingHistory
                    ->where(
                        'status',
                        'late'
                    )
                    ->count();


            /*
            |--------------------------------------------------------------------------
            | IZIN LATIHAN
            |--------------------------------------------------------------------------
            */

            $trainingPermission =
                $trainingHistory
                    ->where(
                        'status',
                        'permission'
                    )
                    ->count();


            /*
            |--------------------------------------------------------------------------
            | SAKIT LATIHAN
            |--------------------------------------------------------------------------
            */

            $trainingSick =
                $trainingHistory
                    ->where(
                        'status',
                        'sick'
                    )
                    ->count();


            /*
            |--------------------------------------------------------------------------
            | ALFA LATIHAN
            |--------------------------------------------------------------------------
            */

            $trainingAbsent =
                $trainingHistory
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

            $trainingAttended =
                $trainingPresent
                +
                $trainingLate;


            /*
            |--------------------------------------------------------------------------
            | TOTAL SESI
            |--------------------------------------------------------------------------
            */

            $totalTrainingSessions =
                $trainingSessions
                    ->count();


            /*
            |--------------------------------------------------------------------------
            | PERSENTASE KEHADIRAN LATIHAN
            |--------------------------------------------------------------------------
            */

            $trainingPercentage =
                $totalTrainingSessions > 0
                    ? round(
                        (
                            $trainingAttended
                            /
                            $totalTrainingSessions
                        )
                        *
                        100,
                        1
                    )
                    : 0;


            /*
            |--------------------------------------------------------------------------
            | STATISTIK LATIHAN
            |--------------------------------------------------------------------------
            */

            $trainingStats = [

                'sessions' =>
                    $totalTrainingSessions,

                'present' =>
                    $trainingPresent,

                'late' =>
                    $trainingLate,

                'permission' =>
                    $trainingPermission,

                'sick' =>
                    $trainingSick,

                'absent' =>
                    $trainingAbsent,

                'attended' =>
                    $trainingAttended,

                'percentage' =>
                    $trainingPercentage,

            ];
        }


        /*
        |--------------------------------------------------------------------------
        | ================================================================
        | KOMPATIBILITAS VIEW LAMA
        | ================================================================
        |--------------------------------------------------------------------------
        |
        | Variabel ini sementara dipertahankan agar halaman Presensi
        | Sekolah lama tidak error sebelum Blade kita gabungkan.
        |
        */

        $attendances =
            $schoolAttendances;


        $hadir =
            $schoolPresent;


        $terlambat =
            $schoolLate;


        $sakit =
            $schoolSick;


        $izin =
            $schoolPermission;


        $alfa =
            $schoolAbsent;


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'siswa.attendance-history',
            compact(
                'student',

                'activeType',

                'selectedMonth',
                'month',

                'schoolAttendances',
                'schoolStats',

                'sport',
                'trainingSessions',
                'trainingHistory',
                'trainingStats',

                /*
                |--------------------------------------------------------------------------
                | Sementara untuk view lama
                |--------------------------------------------------------------------------
                */

                'attendances',
                'hadir',
                'terlambat',
                'sakit',
                'izin',
                'alfa'
            )
        );
    }
}