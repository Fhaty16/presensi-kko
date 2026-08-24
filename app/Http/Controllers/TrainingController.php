<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\TrainingAttendance;
use App\Models\TrainingSession;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TrainingController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CATATAN ALFA OTOMATIS
    |--------------------------------------------------------------------------
    */

    private const AUTO_ABSENT_NOTE =
        'Alfa otomatis karena tidak melakukan presensi lebih dari 30 menit setelah latihan dimulai.';


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
    | HITUNG JAM MULAI SESI
    |--------------------------------------------------------------------------
    */

    private function getSessionStartsAt(
        TrainingSession $trainingSession
    ): ?Carbon {
        if (
            !$trainingSession->training_date
            || !$trainingSession->start_time
        ) {
            return null;
        }


        $date =
            Carbon::parse(
                $trainingSession->training_date
            )->format('Y-m-d');


        $startTime =
            Carbon::parse(
                $trainingSession->start_time,
                'Asia/Jakarta'
            )->format('H:i:s');


        return Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $date . ' ' . $startTime,
            'Asia/Jakarta'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | BUAT ALFA OTOMATIS JIKA SUDAH LEWAT +30 MENIT
    |--------------------------------------------------------------------------
    */

    private function markAutomaticAbsencesIfDue(
        TrainingSession $trainingSession
    ): int {
        if (
            !$trainingSession->sport
            || !$trainingSession->training_date
            || !$trainingSession->start_time
        ) {
            return 0;
        }


        $startsAt =
            $this->getSessionStartsAt(
                $trainingSession
            );


        if (!$startsAt) {
            return 0;
        }


        $alphaAt =
            $startsAt
                ->copy()
                ->addMinutes(30);


        $now =
            Carbon::now(
                'Asia/Jakarta'
            );


        /*
        |--------------------------------------------------------------------------
        | BELUM LEWAT BATAS ALFA
        |--------------------------------------------------------------------------
        */

        if (
            !$now->gt(
                $alphaAt
            )
        ) {
            return 0;
        }


        /*
        |--------------------------------------------------------------------------
        | SISWA AKTIF SESUAI CABOR
        |--------------------------------------------------------------------------
        */

        $students =
            Student::query()
                ->where(
                    'status',
                    'active'
                )
                ->where(
                    'sport',
                    $trainingSession->sport
                )
                ->get();


        $createdCount = 0;


        foreach (
            $students
            as $student
        ) {

            /*
            |--------------------------------------------------------------------------
            | FIRST OR CREATE
            |--------------------------------------------------------------------------
            |
            | Jika siswa sudah memiliki:
            |
            | Hadir
            | Terlambat
            | Izin
            | Sakit
            | Alfa
            |
            | record tersebut tidak akan ditimpa.
            |
            */

            $attendance =
                TrainingAttendance::firstOrCreate(
                    [
                        'training_session_id' =>
                            $trainingSession->id,

                        'student_id' =>
                            $student->id,
                    ],
                    [
                        'status' =>
                            'absent',

                        'checked_in_at' =>
                            null,

                        'notes' =>
                            self::AUTO_ABSENT_NOTE,
                    ]
                );


            if (
                $attendance->wasRecentlyCreated
            ) {
                $createdCount++;
            }
        }


        return $createdCount;
    }


    /*
    |--------------------------------------------------------------------------
    | HAPUS HANYA ALFA OTOMATIS
    |--------------------------------------------------------------------------
    */

    private function deleteAutomaticAbsences(
        TrainingSession $trainingSession
    ): int {
        return $trainingSession
            ->attendances()
            ->where(
                'status',
                'absent'
            )
            ->where(
                'notes',
                self::AUTO_ABSENT_NOTE
            )
            ->delete();
    }


    /*
    |--------------------------------------------------------------------------
    | DAFTAR SESI
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        $this->authorizeRole();


        $sessions =
            TrainingSession::query()
                ->with([
                    'creator',
                    'attendances',
                ])
                ->orderByDesc(
                    'training_date'
                )
                ->orderByDesc(
                    'start_time'
                )
                ->get();


        return view(
            'training.index',
            compact(
                'sessions'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FORM BUAT SESI
    |--------------------------------------------------------------------------
    */

    public function create(): View
    {
        $this->authorizeRole();


        $sports =
            $this->sports();


        return view(
            'training.create',
            compact(
                'sports'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SIMPAN SESI
    |--------------------------------------------------------------------------
    */

    public function store(
        Request $request
    ): RedirectResponse {
        $this->authorizeRole();


        $validated =
            $request->validate([
                'training_date' => [
                    'required',
                    'date',
                ],

                'sport' => [
                    'required',
                    'string',
                    'in:Atletik,Bola Basket,Sepak Bola,Bola Voli',
                ],

                'start_time' => [
                    'required',
                    'date_format:H:i',
                ],

                'end_time' => [
                    'required',
                    'date_format:H:i',
                    'after:start_time',
                ],

                'location' => [
                    'nullable',
                    'string',
                    'max:255',
                ],

                'notes' => [
                    'nullable',
                    'string',
                    'max:1000',
                ],
            ]);


        $trainingSession =
            TrainingSession::create([
                'training_date' =>
                    $validated['training_date'],

                'sport' =>
                    $validated['sport'],

                'start_time' =>
                    $validated['start_time'],

                'end_time' =>
                    $validated['end_time'],

                'location' =>
                    $validated['location']
                    ?? null,

                'notes' =>
                    $validated['notes']
                    ?? null,

                'created_by' =>
                    auth()->id(),
            ]);


        /*
        |--------------------------------------------------------------------------
        | JIKA JADWAL SUDAH LEWAT +30 MENIT
        |--------------------------------------------------------------------------
        */

        $automaticAbsentCount =
            $this->markAutomaticAbsencesIfDue(
                $trainingSession
            );


        $message =
            'Sesi latihan berhasil dibuat.';


        if (
            $automaticAbsentCount > 0
        ) {
            $message .=
                ' '
                . $automaticAbsentCount
                . ' siswa otomatis ditandai Alfa karena batas presensi sudah lewat.';
        }


        return redirect()
            ->route(
                'training.show',
                $trainingSession
            )
            ->with(
                'success',
                $message
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DETAIL SESI
    |--------------------------------------------------------------------------
    */

    public function show(
        TrainingSession $trainingSession
    ): View {
        $this->authorizeRole();


        $session =
            $trainingSession;


        /*
        |--------------------------------------------------------------------------
        | LOAD PRESENSI
        |--------------------------------------------------------------------------
        */

        $session->load([
            'creator',

            'attendances' =>
                function ($query) {

                    $query
                        ->with([
                            'student.user',
                            'student.class',
                        ])
                        ->orderByRaw(
                            'checked_in_at IS NULL'
                        )
                        ->orderBy(
                            'checked_in_at'
                        )
                        ->orderBy(
                            'id'
                        );
                },
        ]);


        /*
        |--------------------------------------------------------------------------
        | SEMUA SISWA SESUAI CABOR SESI
        |--------------------------------------------------------------------------
        |
        | Digunakan untuk menu Kelola Izin / Sakit.
        |
        */

        $sportStudents =
            Student::query()
                ->with([
                    'user',
                    'class',
                ])
                ->where(
                    'status',
                    'active'
                )
                ->where(
                    'sport',
                    $trainingSession->sport
                )
                ->get()
                ->sortBy(
                    fn ($student) =>
                        mb_strtolower(
                            $student->user?->name
                            ?? ''
                        )
                )
                ->values();


        /*
        |--------------------------------------------------------------------------
        | PRESENSI BERDASARKAN STUDENT ID
        |--------------------------------------------------------------------------
        */

        $attendanceByStudent =
            $session
                ->attendances
                ->keyBy(
                    'student_id'
                );


        /*
        |--------------------------------------------------------------------------
        | STATISTIK
        |--------------------------------------------------------------------------
        */

        $attendanceStats = [

            'present' =>
                $session
                    ->attendances
                    ->where(
                        'status',
                        'present'
                    )
                    ->count(),

            'late' =>
                $session
                    ->attendances
                    ->where(
                        'status',
                        'late'
                    )
                    ->count(),

            'permission' =>
                $session
                    ->attendances
                    ->where(
                        'status',
                        'permission'
                    )
                    ->count(),

            'sick' =>
                $session
                    ->attendances
                    ->where(
                        'status',
                        'sick'
                    )
                    ->count(),

            'absent' =>
                $session
                    ->attendances
                    ->where(
                        'status',
                        'absent'
                    )
                    ->count(),

        ];


        /*
        |--------------------------------------------------------------------------
        | DATANG
        |--------------------------------------------------------------------------
        */

        $attendanceStats['attended'] =
            $attendanceStats['present']
            + $attendanceStats['late'];


        /*
        |--------------------------------------------------------------------------
        | TOTAL
        |--------------------------------------------------------------------------
        */

        $attendanceStats['total'] =
            $session
                ->attendances
                ->count();


        return view(
            'training.show',
            compact(
                'session',
                'trainingSession',
                'attendanceStats',
                'sportStudents',
                'attendanceByStudent'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FORM EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(
        TrainingSession $trainingSession
    ): View {
        $this->authorizeRole();


        $session =
            $trainingSession;


        return view(
            'training.edit',
            compact(
                'session',
                'trainingSession'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE SESI
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        TrainingSession $trainingSession
    ): RedirectResponse {
        $this->authorizeRole();


        $validated =
            $request->validate([
                'training_date' => [
                    'required',
                    'date',
                ],

                'start_time' => [
                    'required',
                    'date_format:H:i',
                ],

                'end_time' => [
                    'required',
                    'date_format:H:i',
                    'after:start_time',
                ],

                'location' => [
                    'nullable',
                    'string',
                    'max:255',
                ],

                'notes' => [
                    'nullable',
                    'string',
                    'max:1000',
                ],
            ]);


        /*
        |--------------------------------------------------------------------------
        | DATA LAMA
        |--------------------------------------------------------------------------
        */

        $oldDate =
            Carbon::parse(
                $trainingSession->training_date
            )->format(
                'Y-m-d'
            );


        $oldStart =
            Carbon::parse(
                $trainingSession->start_time
            )->format(
                'H:i'
            );


        $oldEnd =
            Carbon::parse(
                $trainingSession->end_time
            )->format(
                'H:i'
            );


        /*
        |--------------------------------------------------------------------------
        | APAKAH JADWAL BERUBAH?
        |--------------------------------------------------------------------------
        */

        $scheduleChanged =
            $oldDate
                !== $validated['training_date']
            || $oldStart
                !== $validated['start_time']
            || $oldEnd
                !== $validated['end_time'];


        DB::transaction(
            function () use (
                $trainingSession,
                $validated,
                $scheduleChanged
            ) {

                /*
                |--------------------------------------------------------------------------
                | RESET ALFA OTOMATIS LAMA
                |--------------------------------------------------------------------------
                */

                if (
                    $scheduleChanged
                ) {
                    $this
                        ->deleteAutomaticAbsences(
                            $trainingSession
                        );
                }


                /*
                |--------------------------------------------------------------------------
                | UPDATE JADWAL
                |--------------------------------------------------------------------------
                */

                $trainingSession->update([
                    'training_date' =>
                        $validated['training_date'],

                    'start_time' =>
                        $validated['start_time'],

                    'end_time' =>
                        $validated['end_time'],

                    'location' =>
                        $validated['location']
                        ?? null,

                    'notes' =>
                        $validated['notes']
                        ?? null,
                ]);


                /*
                |--------------------------------------------------------------------------
                | MATIKAN QR LAMA
                |--------------------------------------------------------------------------
                */

                $trainingSession
                    ->barcodes()
                    ->where(
                        'is_active',
                        true
                    )
                    ->update([
                        'is_active' =>
                            false,
                    ]);
            }
        );


        $trainingSession->refresh();


        /*
        |--------------------------------------------------------------------------
        | HITUNG ULANG ALFA
        |--------------------------------------------------------------------------
        */

        $automaticAbsentCount =
            $this->markAutomaticAbsencesIfDue(
                $trainingSession
            );


        $message =
            'Jadwal latihan berhasil diperbarui.';


        if (
            $automaticAbsentCount > 0
        ) {
            $message .=
                ' '
                . $automaticAbsentCount
                . ' siswa otomatis ditandai Alfa berdasarkan jadwal terbaru.';
        }


        return redirect()
            ->route(
                'training.show',
                $trainingSession
            )
            ->with(
                'success',
                $message
            );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE STATUS IZIN / SAKIT
    |--------------------------------------------------------------------------
    */

    public function updateStudentStatus(
        Request $request,
        TrainingSession $trainingSession,
        Student $student
    ): RedirectResponse {
        $this->authorizeRole();


        /*
        |--------------------------------------------------------------------------
        | VALIDASI SISWA SESUAI CABOR
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $student->status === 'active'
            && $student->sport
                === $trainingSession->sport,
            422,
            'Siswa tidak terdaftar pada cabang olahraga sesi ini.'
        );


        /*
        |--------------------------------------------------------------------------
        | VALIDASI INPUT
        |--------------------------------------------------------------------------
        */

        $validated =
            $request->validate([
                'status' => [
                    'required',
                    'in:permission,sick',
                ],

                'notes' => [
                    'nullable',
                    'string',
                    'max:500',
                ],
            ]);


        /*
        |--------------------------------------------------------------------------
        | LABEL STATUS
        |--------------------------------------------------------------------------
        */

        $statusLabel =
            $validated['status']
                === 'permission'
                    ? 'Izin'
                    : 'Sakit';


        /*
        |--------------------------------------------------------------------------
        | CATATAN DEFAULT
        |--------------------------------------------------------------------------
        */

        $defaultNote =
            $validated['status']
                === 'permission'
                    ? 'Izin mengikuti latihan.'
                    : 'Sakit dan tidak dapat mengikuti latihan.';


        /*
        |--------------------------------------------------------------------------
        | SIMPAN / KOREKSI STATUS
        |--------------------------------------------------------------------------
        |
        | Bisa digunakan untuk:
        |
        | Alfa       → Izin
        | Alfa       → Sakit
        | Izin       → Sakit
        | Sakit      → Izin
        | Hadir      → Izin/Sakit
        | Terlambat  → Izin/Sakit
        |
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
                    $validated['status'],

                'checked_in_at' =>
                    null,

                'notes' =>
                    filled(
                        $validated['notes']
                        ?? null
                    )
                        ? $validated['notes']
                        : $defaultNote,
            ]
        );


        $student->loadMissing(
            'user'
        );


        return redirect()
            ->route(
                'training.show',
                $trainingSession
            )
            ->with(
                'success',
                ($student->user?->name
                    ?? 'Siswa')
                . ' berhasil diubah menjadi '
                . $statusLabel
                . '.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | HAPUS STATUS IZIN / SAKIT
    |--------------------------------------------------------------------------
    */

    public function clearStudentStatus(
        TrainingSession $trainingSession,
        Student $student
    ): RedirectResponse {
        $this->authorizeRole();


        /*
        |--------------------------------------------------------------------------
        | VALIDASI SISWA
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $student->status === 'active'
            && $student->sport
                === $trainingSession->sport,
            422,
            'Siswa tidak terdaftar pada cabang olahraga sesi ini.'
        );


        /*
        |--------------------------------------------------------------------------
        | CARI PRESENSI SISWA
        |--------------------------------------------------------------------------
        */

        $attendance =
            TrainingAttendance::query()
                ->where(
                    'training_session_id',
                    $trainingSession->id
                )
                ->where(
                    'student_id',
                    $student->id
                )
                ->first();


        /*
        |--------------------------------------------------------------------------
        | HANYA IZIN / SAKIT BOLEH DIHAPUS
        |--------------------------------------------------------------------------
        */

        if (
            !$attendance
            || !in_array(
                $attendance->status,
                [
                    'permission',
                    'sick',
                ],
                true
            )
        ) {
            return redirect()
                ->route(
                    'training.show',
                    $trainingSession
                )
                ->with(
                    'success',
                    'Tidak ada status Izin atau Sakit yang perlu dihapus.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | HAPUS STATUS
        |--------------------------------------------------------------------------
        */

        $attendance->delete();


        /*
        |--------------------------------------------------------------------------
        | CEK ALFA LAGI
        |--------------------------------------------------------------------------
        |
        | Jika status dihapus setelah +30 menit,
        | siswa akan langsung menjadi Alfa.
        |
        */

        $this->markAutomaticAbsencesIfDue(
            $trainingSession
        );


        return redirect()
            ->route(
                'training.show',
                $trainingSession
            )
            ->with(
                'success',
                'Status Izin/Sakit berhasil dihapus.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | HAPUS SESI
    |--------------------------------------------------------------------------
    */

    public function destroy(
        TrainingSession $trainingSession
    ): RedirectResponse {
        $this->authorizeRole();


        DB::transaction(
            function () use (
                $trainingSession
            ) {

                /*
                |--------------------------------------------------------------------------
                | HAPUS BARCODE
                |--------------------------------------------------------------------------
                */

                $trainingSession
                    ->barcodes()
                    ->delete();


                /*
                |--------------------------------------------------------------------------
                | HAPUS PRESENSI
                |--------------------------------------------------------------------------
                */

                $trainingSession
                    ->attendances()
                    ->delete();


                /*
                |--------------------------------------------------------------------------
                | HAPUS SESI
                |--------------------------------------------------------------------------
                */

                $trainingSession
                    ->delete();
            }
        );


        return redirect()
            ->route(
                'training.index'
            )
            ->with(
                'success',
                'Sesi latihan berhasil dihapus.'
            );
    }
}