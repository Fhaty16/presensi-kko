<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;

class StudentAttendanceAiContextService
{
    /*
    |--------------------------------------------------------------------------
    | BUILD CONTEXT
    |--------------------------------------------------------------------------
    */

    public function build(Student $student): string
    {
        $now = Carbon::now('Asia/Jakarta');

        $today = $now
            ->copy()
            ->startOfDay();

        $startOfWeek = $now
            ->copy()
            ->startOfWeek(Carbon::MONDAY)
            ->startOfDay();

        $endOfWeek = $now
            ->copy()
            ->endOfWeek(Carbon::SUNDAY)
            ->endOfDay();


        /*
        |--------------------------------------------------------------------------
        | PRESENSI HARI INI
        |--------------------------------------------------------------------------
        */

        $todayAttendance = Attendance::query()
            ->where(
                'student_id',
                $student->id
            )
            ->whereDate(
                'attendance_date',
                $today->toDateString()
            )
            ->first();


        /*
        |--------------------------------------------------------------------------
        | PRESENSI MINGGU INI
        |--------------------------------------------------------------------------
        */

        $weeklyAttendances = Attendance::query()
            ->where(
                'student_id',
                $student->id
            )
            ->whereBetween(
                'attendance_date',
                [
                    $startOfWeek->toDateString(),
                    $endOfWeek->toDateString(),
                ]
            )
            ->orderBy(
                'attendance_date'
            )
            ->get();


        /*
        |--------------------------------------------------------------------------
        | HITUNG STATUS
        |--------------------------------------------------------------------------
        */

        $presentCount = $weeklyAttendances
            ->where(
                'status',
                'present'
            )
            ->count();

        $lateCount = $weeklyAttendances
            ->where(
                'status',
                'late'
            )
            ->count();

        $permissionCount = $weeklyAttendances
            ->where(
                'status',
                'permission'
            )
            ->count();

        $sickCount = $weeklyAttendances
            ->where(
                'status',
                'sick'
            )
            ->count();

        $absentCount = $weeklyAttendances
            ->where(
                'status',
                'absent'
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | STATUS HARI INI
        |--------------------------------------------------------------------------
        */

        $todayStatus = $todayAttendance
            ? $this->statusLabel(
                $todayAttendance->status
            )
            : 'Belum ada data presensi';


        /*
        |--------------------------------------------------------------------------
        | JAM MASUK
        |--------------------------------------------------------------------------
        */

        $checkInTime = '-';

        if (
            $todayAttendance
            &&
            $todayAttendance->check_in_time
        ) {
            $checkInTime = Carbon::parse(
                $todayAttendance->check_in_time
            )->format('H:i') . ' WIB';
        }


        /*
        |--------------------------------------------------------------------------
        | DETAIL MINGGUAN
        |--------------------------------------------------------------------------
        */

        $weeklyDetail = $weeklyAttendances
            ->map(
                function (Attendance $attendance) {

                    $date = Carbon::parse(
                        $attendance->attendance_date
                    )
                        ->locale('id')
                        ->translatedFormat(
                            'l, d F Y'
                        );

                    $status = $this->statusLabel(
                        $attendance->status
                    );

                    $time = '-';

                    if (
                        $attendance->check_in_time
                    ) {
                        $time = Carbon::parse(
                            $attendance->check_in_time
                        )->format('H:i') . ' WIB';
                    }

                    return
                        '- '
                        . $date
                        . ': '
                        . $status
                        . ', jam masuk '
                        . $time;
                }
            )
            ->implode("\n");


        if ($weeklyDetail === '') {
            $weeklyDetail =
                '- Belum ada data presensi minggu ini.';
        }


        /*
        |--------------------------------------------------------------------------
        | CONTEXT UNTUK GROQ
        |--------------------------------------------------------------------------
        */

        return implode(
            "\n",
            [
                '=== DATA PRESENSI SISWA ===',

                'Nama siswa: '
                    . (
                        $student->user?->name
                        ?? 'Siswa'
                    ),

                'NIS: '
                    . (
                        $student->nis
                        ?? '-'
                    ),

                'Kelas: '
                    . (
                        $student->class?->name
                        ?? '-'
                    ),

                '',

                'Tanggal sekarang: '
                    . $now
                        ->locale('id')
                        ->translatedFormat(
                            'l, d F Y'
                        ),

                'Waktu sekarang: '
                    . $now->format('H:i')
                    . ' WIB',

                '',

                'PRESENSI HARI INI:',

                'Status: '
                    . $todayStatus,

                'Jam masuk: '
                    . $checkInTime,

                '',

                'REKAP MINGGU INI:',

                'Hadir: '
                    . $presentCount,

                'Terlambat: '
                    . $lateCount,

                'Izin: '
                    . $permissionCount,

                'Sakit: '
                    . $sickCount,

                'Alfa: '
                    . $absentCount,

                'Total data presensi: '
                    . $weeklyAttendances->count(),

                '',

                'DETAIL PRESENSI MINGGU INI:',

                $weeklyDetail,

                '',

                'ATURAN UNTUK AI:',

                '- Gunakan data presensi di atas sebagai sumber kebenaran.',

                '- Jangan mengarang status atau jam presensi yang tidak tersedia.',

                '- Jika status hari ini belum ada, katakan bahwa belum ada data presensi hari ini.',

                '- present berarti Hadir.',

                '- late berarti Terlambat.',

                '- permission berarti Izin.',

                '- sick berarti Sakit.',

                '- absent berarti Alfa.',

                '- Hanya jawab data milik siswa yang sedang login.',
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STATUS LABEL
    |--------------------------------------------------------------------------
    */

    private function statusLabel(
        ?string $status
    ): string {
        return match ($status) {

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
                'Belum ada data presensi',

        };
    }
}