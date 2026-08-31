<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\SchoolSchedule;
use Carbon\Carbon;
use Illuminate\View\View;

class ScheduleController extends Controller
{
    public function index(): View
    {
        /*
        |--------------------------------------------------------------------------
        | USER LOGIN
        |--------------------------------------------------------------------------
        */
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | SISWA
        |--------------------------------------------------------------------------
        */
        $student = $user
            ->student()
            ->with('class')
            ->first();

        if (!$student) {
            abort(
                404,
                'Data siswa tidak ditemukan.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | WAKTU SEKARANG
        |--------------------------------------------------------------------------
        */
        $now = Carbon::now(
            'Asia/Jakarta'
        );

        $currentDay =
            (int) $now->dayOfWeekIso;

        $currentTime =
            $now->format('H:i:s');

        /*
        |--------------------------------------------------------------------------
        | SEMUA JADWAL KELAS
        |--------------------------------------------------------------------------
        */
        $allSchedules =
            SchoolSchedule::query()
                ->with('subject')
                ->where(
                    'class_id',
                    $student->class_id
                )
                ->where(
                    'status',
                    true
                )
                ->orderBy(
                    'day_of_week'
                )
                ->orderBy(
                    'start_time'
                )
                ->get();

        /*
        |--------------------------------------------------------------------------
        | KELOMPOKKAN BERDASARKAN HARI
        |--------------------------------------------------------------------------
        */
        $schedulesByDay =
            $allSchedules
                ->groupBy(
                    'day_of_week'
                );

        /*
        |--------------------------------------------------------------------------
        | JADWAL HARI INI
        |--------------------------------------------------------------------------
        */
        $todaySchedules =
            $allSchedules
                ->where(
                    'day_of_week',
                    $currentDay
                )
                ->values();

        /*
        |--------------------------------------------------------------------------
        | JADWAL YANG SEDANG BERLANGSUNG
        |--------------------------------------------------------------------------
        */
        $currentSchedule = null;

        if (
            $currentDay >= 1
            &&
            $currentDay <= 5
        ) {
            $currentSchedule =
                SchoolSchedule::query()
                    ->with('subject')
                    ->where(
                        'class_id',
                        $student->class_id
                    )
                    ->where(
                        'day_of_week',
                        $currentDay
                    )
                    ->where(
                        'status',
                        true
                    )
                    ->where(
                        'start_time',
                        '<=',
                        $currentTime
                    )
                    ->where(
                        'end_time',
                        '>',
                        $currentTime
                    )
                    ->orderBy(
                        'start_time'
                    )
                    ->first();
        }

        /*
        |--------------------------------------------------------------------------
        | JADWAL BERIKUTNYA HARI INI
        |--------------------------------------------------------------------------
        */
        $nextSchedule = null;

        if (
            $currentDay >= 1
            &&
            $currentDay <= 5
        ) {
            $nextSchedule =
                SchoolSchedule::query()
                    ->with('subject')
                    ->where(
                        'class_id',
                        $student->class_id
                    )
                    ->where(
                        'day_of_week',
                        $currentDay
                    )
                    ->where(
                        'status',
                        true
                    )
                    ->where(
                        'start_time',
                        '>',
                        $currentTime
                    )
                    ->orderBy(
                        'start_time'
                    )
                    ->first();
        }

        /*
        |--------------------------------------------------------------------------
        | NAMA HARI
        |--------------------------------------------------------------------------
        */
        $dayLabels = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
        ];

        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */
        return view(
            'siswa.schedule.index',
            compact(
                'student',
                'now',
                'currentDay',
                'currentTime',
                'allSchedules',
                'schedulesByDay',
                'todaySchedules',
                'currentSchedule',
                'nextSchedule',
                'dayLabels'
            )
        );
    }
}