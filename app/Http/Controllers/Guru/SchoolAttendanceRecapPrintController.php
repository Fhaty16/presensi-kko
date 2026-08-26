<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SchoolAttendanceRecapPrintController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN CETAK / PDF REKAP PRESENSI SEKOLAH
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
        | VALIDASI TANGGAL
        |--------------------------------------------------------------------------
        */

        $validated =
            $request->validate([
                'date' => [
                    'required',
                    'date_format:Y-m-d',
                ],
            ]);


        /*
        |--------------------------------------------------------------------------
        | TANGGAL REKAP
        |--------------------------------------------------------------------------
        */

        $date =
            $validated['date'];


        $selectedDate =
            Carbon::createFromFormat(
                'Y-m-d',
                $date,
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
        | PRESENSI TANGGAL TERPILIH
        |--------------------------------------------------------------------------
        */

        $attendances =
            Attendance::query()
                ->whereDate(
                    'attendance_date',
                    $date
                )
                ->get()
                ->keyBy(
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
                        $attendances
                    ) {
                        /*
                        |--------------------------------------------------------------------------
                        | DATA ATTENDANCE
                        |--------------------------------------------------------------------------
                        */

                        $attendance =
                            $attendances
                                ->get(
                                    $student->id
                                );


                        $status =
                            $attendance?->status;


                        /*
                        |--------------------------------------------------------------------------
                        | LABEL STATUS
                        |--------------------------------------------------------------------------
                        */

                        $statusLabel =
                            match (
                                $status
                            ) {
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
                                    'Belum Presensi',
                            };


                        /*
                        |--------------------------------------------------------------------------
                        | JAM MASUK
                        |--------------------------------------------------------------------------
                        */

                        $checkInTime =
                            $attendance?->check_in_time
                                ? Carbon::parse(
                                    $attendance->check_in_time,
                                    'Asia/Jakarta'
                                )->format(
                                    'H:i'
                                )
                                : '-';


                        /*
                        |--------------------------------------------------------------------------
                        | RETURN
                        |--------------------------------------------------------------------------
                        */

                        return [
                            'student' =>
                                $student,

                            'attendance' =>
                                $attendance,

                            'status' =>
                                $status,

                            'status_label' =>
                                $statusLabel,

                            'check_in_time' =>
                                $checkInTime,

                            'notes' =>
                                $attendance?->notes
                                ?? '-',
                        ];
                    }
                )
                ->values();


        /*
        |--------------------------------------------------------------------------
        | TOTAL SISWA
        |--------------------------------------------------------------------------
        */

        $totalSiswa =
            $students
                ->count();


        /*
        |--------------------------------------------------------------------------
        | HADIR
        |--------------------------------------------------------------------------
        */

        $hadir =
            $recaps
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

        $terlambat =
            $recaps
                ->where(
                    'status',
                    'late'
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | TOTAL DATANG
        |--------------------------------------------------------------------------
        */

        $datang =
            $hadir
            +
            $terlambat;


        /*
        |--------------------------------------------------------------------------
        | IZIN
        |--------------------------------------------------------------------------
        */

        $izin =
            $recaps
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

        $sakit =
            $recaps
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

        $alfa =
            $recaps
                ->where(
                    'status',
                    'absent'
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | BELUM PRESENSI
        |--------------------------------------------------------------------------
        */

        $belumPresensi =
            $recaps
                ->whereNull(
                    'status'
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | PERSENTASE KEHADIRAN
        |--------------------------------------------------------------------------
        */

        $persentaseHadir =
            $totalSiswa > 0
                ? round(
                    (
                        $datang
                        /
                        $totalSiswa
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
            'total' =>
                $totalSiswa,

            'present' =>
                $hadir,

            'late' =>
                $terlambat,

            'attended' =>
                $datang,

            'permission' =>
                $izin,

            'sick' =>
                $sakit,

            'absent' =>
                $alfa,

            'not_yet' =>
                $belumPresensi,

            'percentage' =>
                $persentaseHadir,
        ];


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'guru.attendance-recap.print',
            compact(
                'date',
                'selectedDate',
                'students',
                'recaps',
                'stats'
            )
        );
    }
}