<?php

namespace App\Http\Controllers\Pelatih;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\Student;
use App\Models\TrainingSession;
use Carbon\Carbon;
use Illuminate\View\View;
use Throwable;

class DashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD PELATIH
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        /*
        |--------------------------------------------------------------------------
        | WAKTU SISTEM
        |--------------------------------------------------------------------------
        */

        $now =
            Carbon::now(
                'Asia/Jakarta'
            );

        $today =
            $now->toDateString();

        $currentTime =
            $now->format(
                'H:i:s'
            );


        /*
        |--------------------------------------------------------------------------
        | TOTAL ATLET AKTIF
        |--------------------------------------------------------------------------
        */

        $totalSiswa =
            Student::query()
                ->where(
                    'status',
                    'active'
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | LATIHAN HARI INI
        |--------------------------------------------------------------------------
        */

        $todayTrainingSessions =
            TrainingSession::query()
                ->with([
                    'attendances',
                ])
                ->whereDate(
                    'training_date',
                    $today
                )
                ->orderBy(
                    'start_time'
                )
                ->get();


        $todayTrainingCount =
            $todayTrainingSessions
                ->count();


        /*
        |--------------------------------------------------------------------------
        | SESI YANG SEDANG BERLANGSUNG
        |--------------------------------------------------------------------------
        */

        $activeSession =
            $todayTrainingSessions
                ->first(
                    function (
                        $session
                    ) use (
                        $now
                    ) {

                        $startsAt =
                            $this->sessionStartsAt(
                                $session
                            );

                        $endsAt =
                            $this->sessionEndsAt(
                                $session
                            );


                        if (
                            !$startsAt
                            ||
                            !$endsAt
                        ) {
                            return false;
                        }


                        return
                            $now->gte(
                                $startsAt
                            )
                            &&
                            $now->lt(
                                $endsAt
                            );
                    }
                );


        /*
        |--------------------------------------------------------------------------
        | SESI BERIKUTNYA HARI INI
        |--------------------------------------------------------------------------
        */

        $upcomingTodaySession =
            $todayTrainingSessions
                ->first(
                    function (
                        $session
                    ) use (
                        $now
                    ) {

                        $startsAt =
                            $this->sessionStartsAt(
                                $session
                            );


                        return
                            $startsAt
                            &&
                            $startsAt->gt(
                                $now
                            );
                    }
                );


        /*
        |--------------------------------------------------------------------------
        | SESI TERAKHIR HARI INI
        |--------------------------------------------------------------------------
        */

        $lastTodaySession =
            $todayTrainingSessions
                ->last();


        /*
        |--------------------------------------------------------------------------
        | SESI FOKUS DASHBOARD
        |--------------------------------------------------------------------------
        |
        | Prioritas:
        |
        | 1. Sedang berlangsung
        | 2. Akan berlangsung
        | 3. Sesi terakhir hari ini
        |
        */

        $focusSession =
            $activeSession
            ??
            $upcomingTodaySession
            ??
            $lastTodaySession;


        /*
        |--------------------------------------------------------------------------
        | STATUS SESI
        |--------------------------------------------------------------------------
        */

        $focusSessionStatus =
            'BELUM ADA LATIHAN';


        if ($focusSession) {

            $startsAt =
                $this->sessionStartsAt(
                    $focusSession
                );

            $endsAt =
                $this->sessionEndsAt(
                    $focusSession
                );


            if (
                $startsAt
                &&
                $endsAt
                &&
                $now->gte(
                    $startsAt
                )
                &&
                $now->lt(
                    $endsAt
                )
            ) {

                $focusSessionStatus =
                    'SEDANG BERLANGSUNG';

            } elseif (
                $startsAt
                &&
                $now->lt(
                    $startsAt
                )
            ) {

                $focusSessionStatus =
                    'SEGERA DIMULAI';

            } else {

                $focusSessionStatus =
                    'SELESAI';
            }
        }


        /*
        |--------------------------------------------------------------------------
        | TOTAL ATLET PADA CABANG SESI
        |--------------------------------------------------------------------------
        */

        $totalAtletSession =
            0;


        if (
            $focusSession
            &&
            filled(
                $focusSession->sport
            )
        ) {

            $totalAtletSession =
                Student::query()
                    ->where(
                        'status',
                        'active'
                    )
                    ->where(
                        'sport',
                        $focusSession->sport
                    )
                    ->count();
        }


        /*
        |--------------------------------------------------------------------------
        | PRESENSI SESI FOKUS
        |--------------------------------------------------------------------------
        */

        $focusAttendances =
            $focusSession
                ? $focusSession->attendances
                : collect();


        /*
        |--------------------------------------------------------------------------
        | HADIR
        |--------------------------------------------------------------------------
        |
        | present + late dianggap mengikuti latihan.
        |
        */

        $hadir =
            $focusAttendances
                ->whereIn(
                    'status',
                    [
                        'present',
                        'late',
                    ]
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | SAKIT
        |--------------------------------------------------------------------------
        */

        $sakit =
            $focusAttendances
                ->where(
                    'status',
                    'sick'
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | IZIN
        |--------------------------------------------------------------------------
        */

        $izin =
            $focusAttendances
                ->where(
                    'status',
                    'permission'
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | ALFA
        |--------------------------------------------------------------------------
        */

        $alfa =
            $focusAttendances
                ->where(
                    'status',
                    'absent'
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | JUMLAH YANG SUDAH TERCATAT
        |--------------------------------------------------------------------------
        */

        $tercatat =
            $hadir
            +
            $sakit
            +
            $izin
            +
            $alfa;


        /*
        |--------------------------------------------------------------------------
        | BELUM TERCATAT
        |--------------------------------------------------------------------------
        */

        $belumTercatat =
            max(
                0,
                $totalAtletSession
                -
                $tercatat
            );


        /*
        |--------------------------------------------------------------------------
        | PERSENTASE HADIR
        |--------------------------------------------------------------------------
        */

        $persentaseHadir =
            $totalAtletSession > 0
                ? round(
                    (
                        $hadir
                        /
                        $totalAtletSession
                    )
                    *
                    100
                )
                : 0;


        /*
        |--------------------------------------------------------------------------
        | LATIHAN BERIKUTNYA
        |--------------------------------------------------------------------------
        */

        $upcomingTrainingSessions =
            TrainingSession::query()
                ->where(
                    function (
                        $query
                    ) use (
                        $today,
                        $currentTime
                    ) {

                        /*
                        |--------------------------------------------------------------------------
                        | HARI SETELAH HARI INI
                        |--------------------------------------------------------------------------
                        */

                        $query
                            ->whereDate(
                                'training_date',
                                '>',
                                $today
                            )


                            /*
                            |--------------------------------------------------------------------------
                            | ATAU HARI INI TAPI BELUM DIMULAI
                            |--------------------------------------------------------------------------
                            */

                            ->orWhere(
                                function (
                                    $query
                                ) use (
                                    $today,
                                    $currentTime
                                ) {

                                    $query
                                        ->whereDate(
                                            'training_date',
                                            $today
                                        )
                                        ->where(
                                            'start_time',
                                            '>',
                                            $currentTime
                                        );
                                }
                            );
                    }
                )
                ->orderBy(
                    'training_date'
                )
                ->orderBy(
                    'start_time'
                )
                ->limit(
                    4
                )
                ->get();


        /*
        |--------------------------------------------------------------------------
        | JUMLAH PENGAJUAN LATIHAN PENDING
        |--------------------------------------------------------------------------
        */

        $pendingTrainingCount =
            LeaveRequest::query()
                ->where(
                    'attendance_scope',
                    'training'
                )
                ->where(
                    'status',
                    'pending'
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | PENGAJUAN LATIHAN TERBARU
        |--------------------------------------------------------------------------
        */

        $pendingTrainingRequests =
            LeaveRequest::query()
                ->with([
                    'student.user',
                    'student.class',
                    'trainingSession',
                ])
                ->where(
                    'attendance_scope',
                    'training'
                )
                ->where(
                    'status',
                    'pending'
                )
                ->latest()
                ->limit(
                    6
                )
                ->get();


        /*
        |--------------------------------------------------------------------------
        | JUMLAH ATLET PER CABANG
        |--------------------------------------------------------------------------
        */

        $sportCounts =
            Student::query()
                ->where(
                    'status',
                    'active'
                )
                ->whereIn(
                    'sport',
                    [
                        'Atletik',
                        'Bola Basket',
                        'Sepak Bola',
                        'Bola Voli',
                    ]
                )
                ->selectRaw(
                    'sport, COUNT(*) as total'
                )
                ->groupBy(
                    'sport'
                )
                ->pluck(
                    'total',
                    'sport'
                );


        /*
        |--------------------------------------------------------------------------
        | KIRIM DATA KE VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'pelatih.dashboard',
            [
                'totalSiswa' =>
                    $totalSiswa,

                'todayTrainingCount' =>
                    $todayTrainingCount,

                'focusSession' =>
                    $focusSession,

                'focusSessionStatus' =>
                    $focusSessionStatus,

                'totalAtletSession' =>
                    $totalAtletSession,

                'hadir' =>
                    $hadir,

                'sakit' =>
                    $sakit,

                'izin' =>
                    $izin,

                'alfa' =>
                    $alfa,

                'belumTercatat' =>
                    $belumTercatat,

                'persentaseHadir' =>
                    $persentaseHadir,

                'upcomingTrainingSessions' =>
                    $upcomingTrainingSessions,

                'pendingTrainingCount' =>
                    $pendingTrainingCount,

                'pendingTrainingRequests' =>
                    $pendingTrainingRequests,

                'sportCounts' =>
                    $sportCounts,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | WAKTU MULAI LATIHAN
    |--------------------------------------------------------------------------
    */

    private function sessionStartsAt(
        TrainingSession $session
    ): ?Carbon {

        if (
            !$session->training_date
            ||
            !$session->start_time
        ) {

            return null;
        }


        try {

            $date =
                Carbon::parse(
                    $session->training_date
                )->format(
                    'Y-m-d'
                );


            $time =
                Carbon::parse(
                    $session->start_time
                )->format(
                    'H:i:s'
                );


            return Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $date
                .
                ' '
                .
                $time,
                'Asia/Jakarta'
            );

        } catch (Throwable $exception) {

            return null;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | WAKTU SELESAI LATIHAN
    |--------------------------------------------------------------------------
    */

    private function sessionEndsAt(
        TrainingSession $session
    ): ?Carbon {

        if (
            !$session->training_date
            ||
            !$session->end_time
        ) {

            return null;
        }


        try {

            $date =
                Carbon::parse(
                    $session->training_date
                )->format(
                    'Y-m-d'
                );


            $time =
                Carbon::parse(
                    $session->end_time
                )->format(
                    'H:i:s'
                );


            return Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $date
                .
                ' '
                .
                $time,
                'Asia/Jakarta'
            );

        } catch (Throwable $exception) {

            return null;
        }
    }
}