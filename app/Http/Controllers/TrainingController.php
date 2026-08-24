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
    |
    | Digunakan juga untuk membedakan Alfa otomatis
    | dengan Alfa yang mungkin dimasukkan secara manual.
    |
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
        /*
        |--------------------------------------------------------------------------
        | VALIDASI DATA SESI
        |--------------------------------------------------------------------------
        */

        if (
            !$trainingSession->sport
            || !$trainingSession->training_date
            || !$trainingSession->start_time
        ) {
            return 0;
        }


        /*
        |--------------------------------------------------------------------------
        | HITUNG BATAS ALFA
        |--------------------------------------------------------------------------
        */

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
        | BELUM LEWAT 30 MENIT
        |--------------------------------------------------------------------------
        |
        | Tepat di +30 menit masih belum Alfa.
        | Alfa dimulai setelah +30 menit.
        |
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
        | AMBIL SISWA AKTIF SESUAI CABOR
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


        /*
        |--------------------------------------------------------------------------
        | PROSES SETIAP SISWA
        |--------------------------------------------------------------------------
        */

        foreach (
            $students
            as $student
        ) {

            /*
            |--------------------------------------------------------------------------
            | JANGAN TIMPA STATUS YANG SUDAH ADA
            |--------------------------------------------------------------------------
            |
            | Jika siswa sudah:
            |
            | - Hadir
            | - Terlambat
            | - Izin
            | - Sakit
            | - Alfa
            |
            | maka tidak dibuat record baru.
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
    |
    | Digunakan saat jadwal diubah.
    |
    | Hadir, Terlambat, Izin, Sakit, dan Alfa manual
    | tidak akan dihapus.
    |
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
    | DAFTAR SESI LATIHAN
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
    | SIMPAN SESI LATIHAN
    |--------------------------------------------------------------------------
    */

    public function store(
        Request $request
    ): RedirectResponse {
        $this->authorizeRole();


        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | BUAT SESI
        |--------------------------------------------------------------------------
        */

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
        | CEK ALFA LANGSUNG
        |--------------------------------------------------------------------------
        |
        | Kalau jadwal yang dibuat ternyata sudah lewat
        | 30 menit dari waktu mulai, Alfa langsung dibuat.
        |
        */

        $automaticAbsentCount =
            $this->markAutomaticAbsencesIfDue(
                $trainingSession
            );


        /*
        |--------------------------------------------------------------------------
        | PESAN BERHASIL
        |--------------------------------------------------------------------------
        */

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
    | DETAIL SESI LATIHAN
    |--------------------------------------------------------------------------
    */

    public function show(
        TrainingSession $trainingSession
    ): View {
        $this->authorizeRole();


        /*
        |--------------------------------------------------------------------------
        | ALIAS VIEW
        |--------------------------------------------------------------------------
        */

        $session =
            $trainingSession;


        /*
        |--------------------------------------------------------------------------
        | LOAD DATA
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
        | STATISTIK PRESENSI
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
        | DATANG = HADIR + TERLAMBAT
        |--------------------------------------------------------------------------
        */

        $attendanceStats['attended'] =
            $attendanceStats['present']
            + $attendanceStats['late'];


        /*
        |--------------------------------------------------------------------------
        | TOTAL RECORD
        |--------------------------------------------------------------------------
        */

        $attendanceStats['total'] =
            $session
                ->attendances
                ->count();


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'training.show',
            compact(
                'session',
                'trainingSession',
                'attendanceStats'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FORM EDIT SESI
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
    | UPDATE SESI LATIHAN
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        TrainingSession $trainingSession
    ): RedirectResponse {
        $this->authorizeRole();


        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

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
        | DATA JADWAL LAMA
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
        | CEK APAKAH WAKTU JADWAL BERUBAH
        |--------------------------------------------------------------------------
        */

        $scheduleChanged =
            $oldDate
                !== $validated['training_date']
            || $oldStart
                !== $validated['start_time']
            || $oldEnd
                !== $validated['end_time'];


        /*
        |--------------------------------------------------------------------------
        | UPDATE DALAM TRANSACTION
        |--------------------------------------------------------------------------
        */

        DB::transaction(
            function () use (
                $trainingSession,
                $validated,
                $scheduleChanged
            ) {

                /*
                |--------------------------------------------------------------------------
                | JIKA JADWAL BERUBAH, HAPUS ALFA OTOMATIS LAMA
                |--------------------------------------------------------------------------
                |
                | Contoh:
                |
                | Awalnya 22:00 → sudah Alfa
                | kemudian diubah menjadi 23:00
                |
                | Alfa otomatis lama harus dihapus.
                |
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
                | MATIKAN BARCODE LAMA
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


        /*
        |--------------------------------------------------------------------------
        | REFRESH DATA
        |--------------------------------------------------------------------------
        */

        $trainingSession->refresh();


        /*
        |--------------------------------------------------------------------------
        | HITUNG ULANG ALFA
        |--------------------------------------------------------------------------
        |
        | Jika jadwal baru ternyata sudah lewat +30 menit,
        | Alfa langsung dibuat kembali.
        |
        */

        $automaticAbsentCount =
            $this->markAutomaticAbsencesIfDue(
                $trainingSession
            );


        /*
        |--------------------------------------------------------------------------
        | PESAN
        |--------------------------------------------------------------------------
        */

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
    | HAPUS SESI LATIHAN
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