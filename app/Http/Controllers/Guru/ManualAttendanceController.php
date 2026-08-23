<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ManualAttendanceController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN INPUT MANUAL
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $dateInput = $request->query('date');

        try {
            $selectedDate = $dateInput
                ? Carbon::createFromFormat(
                    'Y-m-d',
                    $dateInput,
                    'Asia/Jakarta'
                )
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
        | PRESENSI TANGGAL TERPILIH
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
        | KIRIM KE VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'guru.manual-attendance.index',
            compact(
                'date',
                'selectedDate',
                'students',
                'attendances'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SIMPAN / UBAH PRESENSI
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => [
                'required',
                'integer',
                'exists:students,id',
            ],

            'attendance_date' => [
                'required',
                'date_format:Y-m-d',
            ],

            'status' => [
                'required',
                Rule::in([
                    'present',
                    'late',
                    'permission',
                    'sick',
                    'absent',
                ]),
            ],

            'check_in_time' => [
                'nullable',
                'date_format:H:i',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:500',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | PASTIKAN SISWA AKTIF
        |--------------------------------------------------------------------------
        */

        $student = Student::where('id', $validated['student_id'])
            ->where('status', 'active')
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | JAM MASUK
        |--------------------------------------------------------------------------
        |
        | Sakit / Izin / Alfa tidak mempunyai jam masuk.
        |
        */

        $checkInTime = in_array(
            $validated['status'],
            [
                'present',
                'late',
            ],
            true
        )
            ? ($validated['check_in_time'] ?? null)
            : null;


        /*
        |--------------------------------------------------------------------------
        | CATATAN DEFAULT
        |--------------------------------------------------------------------------
        */

        $notes = $validated['notes'] ?? null;

        if (!$notes) {
            $notes = match ($validated['status']) {
                'present' => 'Presensi diinput manual oleh Guru.',
                'late' => 'Status terlambat diinput manual oleh Guru.',
                'permission' => 'Status izin diinput manual oleh Guru.',
                'sick' => 'Status sakit diinput manual oleh Guru.',
                'absent' => 'Status alfa diinput manual oleh Guru.',
                default => null,
            };
        }


        /*
        |--------------------------------------------------------------------------
        | CREATE ATAU UPDATE
        |--------------------------------------------------------------------------
        |
        | Kombinasi student_id + attendance_date sudah unik.
        | Karena itu updateOrCreate mencegah data presensi ganda.
        |
        */

        Attendance::updateOrCreate(
            [
                'student_id' => $student->id,

                'attendance_date' =>
                    $validated['attendance_date'],
            ],
            [
                'check_in_time' => $checkInTime,

                'status' => $validated['status'],

                'notes' => $notes,

                'wa_sent' => false,
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | KEMBALI KE TANGGAL YANG SAMA
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'guru.attendance.manual',
                [
                    'date' =>
                        $validated['attendance_date'],
                ]
            )
            ->with(
                'success',
                'Presensi siswa berhasil disimpan.'
            );
    }
}