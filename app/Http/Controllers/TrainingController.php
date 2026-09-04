<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\TrainingAttendance;
use App\Models\TrainingSession;
use App\Services\TrainingAttendanceService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TrainingController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CONSTRUCTOR
    |--------------------------------------------------------------------------
    |
    | Semua proses Alfa otomatis latihan dipusatkan pada:
    |
    | TrainingAttendanceService
    |
    */

    public function __construct(
        private readonly TrainingAttendanceService $trainingAttendanceService
    ) {
    }


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
    |
    | Pengelolaan latihan hanya dapat dilakukan oleh:
    |
    | - Guru
    | - Pelatih
    |
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
    | DAFTAR SESI LATIHAN
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        $this->authorizeRole();


        /*
        |--------------------------------------------------------------------------
        | AMBIL SESI
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | SINKRONISASI ALFA
        |--------------------------------------------------------------------------
        |
        | Scheduler merupakan proses utama.
        |
        | Bagian ini menjadi fallback jika scheduler development sedang
        | tidak berjalan.
        |
        */

        foreach (
            $sessions
            as $session
        ) {

            $createdCount =
                $this
                    ->trainingAttendanceService
                    ->markAutomaticAbsencesIfDue(
                        $session
                    );


            /*
            |--------------------------------------------------------------------------
            | REFRESH ATTENDANCE
            |--------------------------------------------------------------------------
            */

            if (
                $createdCount > 0
            ) {

                $session->load(
                    'attendances'
                );
            }
        }


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
                    ??
                    null,

                'notes' =>
                    $validated['notes']
                    ??
                    null,

                'created_by' =>
                    auth()->id(),
            ]);


        /*
        |--------------------------------------------------------------------------
        | CEK ALFA OTOMATIS
        |--------------------------------------------------------------------------
        |
        | Berguna jika Guru/Pelatih membuat sesi dengan waktu yang sudah
        | melewati batas Alfa.
        |
        */

        $automaticAbsentCount =
            $this
                ->trainingAttendanceService
                ->markAutomaticAbsencesIfDue(
                    $trainingSession
                );


        /*
        |--------------------------------------------------------------------------
        | PESAN
        |--------------------------------------------------------------------------
        */

        $message =
            'Sesi latihan berhasil dibuat.';


        if (
            $automaticAbsentCount > 0
        ) {

            $message .=
                ' '
                .
                $automaticAbsentCount
                .
                ' siswa otomatis ditandai Alfa karena batas presensi sudah lewat.';
        }


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | SINKRONISASI ALFA
        |--------------------------------------------------------------------------
        |
        | Scheduler tetap merupakan mekanisme utama.
        |
        | Ini menjadi fallback saat halaman detail dibuka.
        |
        */

        $this
            ->trainingAttendanceService
            ->markAutomaticAbsencesIfDue(
                $trainingSession
            );


        /*
        |--------------------------------------------------------------------------
        | SESSION
        |--------------------------------------------------------------------------
        */

        $session =
            $trainingSession;


        /*
        |--------------------------------------------------------------------------
        | LOAD PRESENSI
        |--------------------------------------------------------------------------
        |
        | Dilakukan setelah sinkronisasi Alfa agar statistik menggunakan
        | data terbaru.
        |
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
                            ??
                            ''
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
        | STATISTIK PRESENSI
        |--------------------------------------------------------------------------
        */

        $attendanceStats = [

            /*
            |--------------------------------------------------------------------------
            | HADIR
            |--------------------------------------------------------------------------
            */

            'present' =>
                $session
                    ->attendances
                    ->where(
                        'status',
                        'present'
                    )
                    ->count(),


            /*
            |--------------------------------------------------------------------------
            | TERLAMBAT
            |--------------------------------------------------------------------------
            */

            'late' =>
                $session
                    ->attendances
                    ->where(
                        'status',
                        'late'
                    )
                    ->count(),


            /*
            |--------------------------------------------------------------------------
            | IZIN
            |--------------------------------------------------------------------------
            */

            'permission' =>
                $session
                    ->attendances
                    ->where(
                        'status',
                        'permission'
                    )
                    ->count(),


            /*
            |--------------------------------------------------------------------------
            | SAKIT
            |--------------------------------------------------------------------------
            */

            'sick' =>
                $session
                    ->attendances
                    ->where(
                        'status',
                        'sick'
                    )
                    ->count(),


            /*
            |--------------------------------------------------------------------------
            | ALFA
            |--------------------------------------------------------------------------
            */

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
        |
        | Datang = Hadir + Terlambat.
        |
        */

        $attendanceStats['attended'] =
            $attendanceStats['present']
            +
            $attendanceStats['late'];


        /*
        |--------------------------------------------------------------------------
        | TOTAL PRESENSI TERCATAT
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
                'attendanceStats',
                'sportStudents',
                'attendanceByStudent'
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
    | UPDATE SESI
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
            )
                ->format(
                    'Y-m-d'
                );


        $oldStart =
            Carbon::parse(
                $trainingSession->start_time
            )
                ->format(
                    'H:i'
                );


        $oldEnd =
            Carbon::parse(
                $trainingSession->end_time
            )
                ->format(
                    'H:i'
                );


        /*
        |--------------------------------------------------------------------------
        | CEK PERUBAHAN JADWAL
        |--------------------------------------------------------------------------
        */

        $scheduleChanged =
            $oldDate
            !==
            $validated['training_date']

            ||

            $oldStart
            !==
            $validated['start_time']

            ||

            $oldEnd
            !==
            $validated['end_time'];


        /*
        |--------------------------------------------------------------------------
        | TRANSACTION
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
                | HAPUS ALFA OTOMATIS LAMA
                |--------------------------------------------------------------------------
                |
                | Hanya Alfa otomatis yang dihapus.
                |
                | Alfa manual tetap dipertahankan.
                |
                */

                if (
                    $scheduleChanged
                ) {

                    $this
                        ->trainingAttendanceService
                        ->deleteAutomaticAbsences(
                            $trainingSession
                        );
                }


                /*
                |--------------------------------------------------------------------------
                | UPDATE SESI
                |--------------------------------------------------------------------------
                */

                $trainingSession
                    ->update([
                        'training_date' =>
                            $validated['training_date'],

                        'start_time' =>
                            $validated['start_time'],

                        'end_time' =>
                            $validated['end_time'],

                        'location' =>
                            $validated['location']
                            ??
                            null,

                        'notes' =>
                            $validated['notes']
                            ??
                            null,
                    ]);


                /*
                |--------------------------------------------------------------------------
                | MATIKAN QR LAMA
                |--------------------------------------------------------------------------
                |
                | QR lama tidak boleh digunakan setelah jadwal diperbarui.
                |
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
        | REFRESH MODEL
        |--------------------------------------------------------------------------
        */

        $trainingSession
            ->refresh();


        /*
        |--------------------------------------------------------------------------
        | HITUNG ULANG ALFA
        |--------------------------------------------------------------------------
        */

        $automaticAbsentCount =
            $this
                ->trainingAttendanceService
                ->markAutomaticAbsencesIfDue(
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
                .
                $automaticAbsentCount
                .
                ' siswa otomatis ditandai Alfa berdasarkan jadwal terbaru.';
        }


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

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
    | UPDATE STATUS PRESENSI
    |--------------------------------------------------------------------------
    |
    | Status manual:
    |
    | permission = Izin
    | sick       = Sakit
    | present    = Hadir
    | absent     = Alfa
    |
    | late tetap berasal dari mekanisme scan QR.
    |
    */

    public function updateStudentStatus(
        Request $request,
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
            $student->status
            ===
            'active'
            &&
            $student->sport
            ===
            $trainingSession->sport,
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
                    'in:permission,sick,present,absent',
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
            match (
                $validated['status']
            ) {

                'permission' =>
                    'Izin',

                'sick' =>
                    'Sakit',

                'present' =>
                    'Hadir',

                'absent' =>
                    'Alfa',

                default =>
                    '-',
            };


        /*
        |--------------------------------------------------------------------------
        | CATATAN DEFAULT
        |--------------------------------------------------------------------------
        |
        | Catatan Alfa manual dibuat berbeda dari AUTO_ABSENT_NOTE milik
        | TrainingAttendanceService.
        |
        | Dengan begitu Alfa manual tidak akan ikut dihapus saat jadwal
        | latihan berubah.
        |
        */

        $defaultNote =
            match (
                $validated['status']
            ) {

                'permission' =>
                    'Izin mengikuti latihan.',

                'sick' =>
                    'Sakit dan tidak dapat mengikuti latihan.',

                'present' =>
                    'Hadir ditetapkan secara manual oleh Guru/Pelatih.',

                'absent' =>
                    'Alfa ditetapkan secara manual oleh Guru/Pelatih.',

                default =>
                    null,
            };


        /*
        |--------------------------------------------------------------------------
        | SIMPAN / KOREKSI STATUS
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
                    $validated['status'],

                'checked_in_at' =>
                    null,

                'notes' =>
                    filled(
                        $validated['notes']
                        ??
                        null
                    )
                        ? $validated['notes']
                        : $defaultNote,
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | LOAD USER
        |--------------------------------------------------------------------------
        */

        $student
            ->loadMissing(
                'user'
            );


        $studentName =
            $student->user?->name
            ??
            'Siswa';


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'training.show',
                $trainingSession
            )
            ->with(
                'success',
                $studentName
                .
                ' berhasil diubah menjadi '
                .
                $statusLabel
                .
                '.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | HAPUS STATUS PRESENSI
    |--------------------------------------------------------------------------
    |
    | Status yang dapat dihapus:
    |
    | - Izin
    | - Sakit
    | - Hadir
    | - Alfa
    |
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
            $student->status
            ===
            'active'
            &&
            $student->sport
            ===
            $trainingSession->sport,
            422,
            'Siswa tidak terdaftar pada cabang olahraga sesi ini.'
        );


        /*
        |--------------------------------------------------------------------------
        | CARI PRESENSI
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
        | TIDAK ADA STATUS
        |--------------------------------------------------------------------------
        */

        if (
            !$attendance
        ) {

            return redirect()
                ->route(
                    'training.show',
                    $trainingSession
                )
                ->with(
                    'success',
                    'Tidak ada status presensi yang perlu dihapus.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | STATUS YANG DAPAT DIHAPUS
        |--------------------------------------------------------------------------
        */

        if (
            !in_array(
                $attendance->status,
                [
                    'permission',
                    'sick',
                    'present',
                    'absent',
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
                    'Status presensi tersebut tidak dapat dihapus secara manual.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | HAPUS STATUS
        |--------------------------------------------------------------------------
        */

        $attendance
            ->delete();


        /*
        |--------------------------------------------------------------------------
        | CEK ALFA KEMBALI
        |--------------------------------------------------------------------------
        |
        | Jika status dihapus setelah batas +30 menit, service akan
        | mengecek kembali siswa tersebut.
        |
        */

        $this
            ->trainingAttendanceService
            ->markAutomaticAbsencesIfDue(
                $trainingSession
            );


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'training.show',
                $trainingSession
            )
            ->with(
                'success',
                'Status presensi siswa berhasil dihapus.'
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