<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceRecapController extends Controller
{
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | TANGGAL REKAP
        |--------------------------------------------------------------------------
        */

        $dateInput = $request->query('date');

        try {
            $selectedDate = $dateInput
                ? Carbon::createFromFormat('Y-m-d', $dateInput, 'Asia/Jakarta')
                : Carbon::now('Asia/Jakarta');
        } catch (\Throwable $e) {
            $selectedDate = Carbon::now('Asia/Jakarta');
        }

        $date = $selectedDate->format('Y-m-d');


        /*
        |--------------------------------------------------------------------------
        | SISWA AKTIF
        |--------------------------------------------------------------------------
        */

        $students = Student::with([
                'user',
                'class',
            ])
            ->where('status', 'active')
            ->get()
            ->sortBy(function ($student) {
                return strtolower(
                    $student->user?->name ?? ''
                );
            })
            ->values();


        /*
        |--------------------------------------------------------------------------
        | PRESENSI PADA TANGGAL TERPILIH
        |--------------------------------------------------------------------------
        */

        $attendances = Attendance::whereDate(
                'attendance_date',
                $date
            )
            ->get()
            ->keyBy('student_id');


        /*
        |--------------------------------------------------------------------------
        | DATA REKAP PER SISWA
        |--------------------------------------------------------------------------
        */

        $recaps = $students->map(function ($student) use ($attendances) {

            $attendance = $attendances->get($student->id);

            $status = $attendance?->status;

            $statusLabel = match ($status) {

                'present' => 'Hadir',

                'late' => 'Terlambat',

                'permission' => 'Izin',

                'sick' => 'Sakit',

                'absent' => 'Alfa',

                default => 'Belum Presensi',

            };

            $statusClass = match ($status) {

                'present' => 'present',

                'late' => 'late',

                'permission' => 'permission',

                'sick' => 'sick',

                'absent' => 'absent',

                default => 'not-yet',

            };

            return [
                'student' => $student,

                'attendance' => $attendance,

                'status' => $status,

                'status_label' => $statusLabel,

                'status_class' => $statusClass,
            ];
        });


        /*
        |--------------------------------------------------------------------------
        | STATISTIK
        |--------------------------------------------------------------------------
        */

        $totalSiswa = $students->count();

        $hadir = $recaps
            ->whereIn('status', [
                'present',
                'late',
            ])
            ->count();

        $terlambat = $recaps
            ->where('status', 'late')
            ->count();

        $sakit = $recaps
            ->where('status', 'sick')
            ->count();

        $izin = $recaps
            ->where('status', 'permission')
            ->count();

        $alfa = $recaps
            ->where('status', 'absent')
            ->count();

        $belumPresensi = $recaps
            ->whereNull('status')
            ->count();

        $persentaseHadir = $totalSiswa > 0
            ? round(($hadir / $totalSiswa) * 100)
            : 0;


        /*
        |--------------------------------------------------------------------------
        | KIRIM KE VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'guru.attendance-recap.index',
            compact(
                'date',
                'selectedDate',
                'recaps',
                'totalSiswa',
                'hadir',
                'terlambat',
                'sakit',
                'izin',
                'alfa',
                'belumPresensi',
                'persentaseHadir'
            )
        );
    }
}