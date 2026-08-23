<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\TrainingAttendance;
use App\Models\TrainingSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TrainingAttendanceController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CEK ROLE
    |--------------------------------------------------------------------------
    */

    private function authorizeRole(): void
    {
        abort_unless(
            auth()->check()
            &&
            in_array(
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
    | FORM INPUT KEHADIRAN
    |--------------------------------------------------------------------------
    */

    public function edit(
        TrainingSession $trainingSession
    ) {
        $this->authorizeRole();


        $students = Student::with([
                'user',
                'class',
            ])
            ->where('status', 'active')
            ->get()
            ->sortBy(
                fn ($student) =>
                    strtolower(
                        $student->user?->name ?? ''
                    )
            )
            ->values();


        $existingAttendances =
            TrainingAttendance::where(
                'training_session_id',
                $trainingSession->id
            )
            ->get()
            ->keyBy('student_id');


        $trainingSession->load([
            'creator',
        ]);


        return view(
            'training.attendance',
            compact(
                'trainingSession',
                'students',
                'existingAttendances'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SIMPAN KEHADIRAN
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        TrainingSession $trainingSession
    ) {
        $this->authorizeRole();


        $validated = $request->validate([

            'attendance' => [
                'required',
                'array',
                'min:1',
            ],

            'attendance.*.student_id' => [
                'required',
                'integer',
                'exists:students,id',
            ],

            'attendance.*.status' => [
                'required',
                Rule::in([
                    'present',
                    'permission',
                    'sick',
                    'absent',
                ]),
            ],

            'attendance.*.notes' => [
                'nullable',
                'string',
                'max:500',
            ],

        ]);


        DB::transaction(function () use (
            $validated,
            $trainingSession
        ) {

            foreach (
                $validated['attendance']
                as $attendanceData
            ) {

                /*
                |--------------------------------------------------------------------------
                | PASTIKAN SISWA MASIH AKTIF
                |--------------------------------------------------------------------------
                */

                $student = Student::where(
                        'id',
                        $attendanceData['student_id']
                    )
                    ->where(
                        'status',
                        'active'
                    )
                    ->firstOrFail();


                /*
                |--------------------------------------------------------------------------
                | SIMPAN / UPDATE
                |--------------------------------------------------------------------------
                */

                TrainingAttendance::updateOrCreate(

                    [
                        'training_session_id' =>
                            $trainingSession->id,

                        'student_id' =>
                            $student->id,
                    ],

                    [
                        'status' =>
                            $attendanceData['status'],

                        'notes' =>
                            $attendanceData['notes']
                            ?? null,
                    ]

                );

            }

        });


        return redirect()
            ->route(
                'training.show',
                $trainingSession
            )
            ->with(
                'success',
                'Kehadiran latihan berhasil disimpan.'
            );
    }
}