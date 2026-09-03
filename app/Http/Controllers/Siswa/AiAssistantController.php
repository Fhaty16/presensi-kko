<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\SchoolSchedule;
use App\Services\GroqService;
use App\Services\StudentAttendanceAiContextService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Throwable;

class AiAssistantController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SERVICE
    |--------------------------------------------------------------------------
    */

    public function __construct(
        protected GroqService $groqService,
        protected StudentAttendanceAiContextService $attendanceContextService
    ) {
    }


    /*
    |--------------------------------------------------------------------------
    | HALAMAN KKO AI
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        $user =
            auth()->user();


        $student =
            $user
                ->student()
                ->with([
                    'user',
                    'class',
                ])
                ->first();


        if (!$student) {
            abort(
                404,
                'Data siswa tidak ditemukan.'
            );
        }


        return view(
            'siswa.ai.index',
            [
                'user' =>
                    $user,

                'student' =>
                    $student,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CHAT
    |--------------------------------------------------------------------------
    */

    public function chat(
        Request $request
    ): JsonResponse
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI PESAN
        |--------------------------------------------------------------------------
        */

        $validated =
            $request->validate([
                'message' => [
                    'required',
                    'string',
                    'max:1000',
                ],
            ]);


        $message =
            trim(
                $validated['message']
            );


        /*
        |--------------------------------------------------------------------------
        | USER LOGIN
        |--------------------------------------------------------------------------
        */

        $user =
            auth()->user();


        /*
        |--------------------------------------------------------------------------
        | DATA SISWA
        |--------------------------------------------------------------------------
        |
        | Penting:
        | Data siswa selalu berasal dari user yang sedang login.
        |
        | Siswa tidak boleh mengirim student_id sendiri.
        |
        */

        $student =
            $user
                ->student()
                ->with([
                    'user',
                    'class',
                ])
                ->first();


        if (!$student) {
            return response()->json(
                [
                    'success' =>
                        false,

                    'message' =>
                        'Data siswa tidak ditemukan.',
                ],
                404
            );
        }


        try {

            /*
            |--------------------------------------------------------------------------
            | CONTEXT JADWAL
            |--------------------------------------------------------------------------
            */

            $scheduleContext =
                $this->buildScheduleContext(
                    $student
                );


            /*
            |--------------------------------------------------------------------------
            | CONTEXT PRESENSI
            |--------------------------------------------------------------------------
            */

            $attendanceContext =
                $this
                    ->attendanceContextService
                    ->build(
                        $student
                    );


            /*
            |--------------------------------------------------------------------------
            | GABUNGKAN CONTEXT
            |--------------------------------------------------------------------------
            */

            $context =
                $this->buildAiContext(
                    scheduleContext:
                        $scheduleContext,

                    attendanceContext:
                        $attendanceContext
                );


            /*
            |--------------------------------------------------------------------------
            | KIRIM KE GROQ
            |--------------------------------------------------------------------------
            */

            $answer =
                $this
                    ->groqService
                    ->chat(
                        $message,
                        $context
                    );


            /*
            |--------------------------------------------------------------------------
            | RESPONSE
            |--------------------------------------------------------------------------
            */

            return response()->json([
                'success' =>
                    true,

                'answer' =>
                    $answer,
            ]);

        } catch (Throwable $exception) {

            /*
            |--------------------------------------------------------------------------
            | LOG ERROR
            |--------------------------------------------------------------------------
            */

            Log::error(
                'KKO AI Assistant gagal memproses pesan.',
                [
                    'user_id' =>
                        $user->id,

                    'student_id' =>
                        $student->id,

                    'message' =>
                        $message,

                    'exception' =>
                        $exception->getMessage(),
                ]
            );


            /*
            |--------------------------------------------------------------------------
            | RESPONSE ERROR
            |--------------------------------------------------------------------------
            */

            return response()->json(
                [
                    'success' =>
                        false,

                    'message' =>
                        'Maaf, KKO AI sedang mengalami kendala. Silakan coba kembali.',
                ],
                500
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | BUILD CONTEXT UTAMA
    |--------------------------------------------------------------------------
    */

    private function buildAiContext(
        string $scheduleContext,
        string $attendanceContext
    ): string
    {
        return <<<CONTEXT
=== IDENTITAS KKO AI ===

Kamu adalah KKO AI Assistant milik Sistem KKO SMANDA.

Tugasmu adalah membantu siswa berdasarkan data resmi yang diberikan oleh sistem.

Jawab menggunakan Bahasa Indonesia yang:
- sopan,
- ramah,
- singkat,
- jelas,
- mudah dipahami siswa.


=== ATURAN PALING PENTING ===

1. Gunakan DATA SISTEM sebagai sumber kebenaran.

2. Jangan mengarang:
   - jadwal,
   - mata pelajaran,
   - waktu,
   - status presensi,
   - jumlah hadir,
   - jumlah alfa,
   - jumlah izin,
   - jumlah sakit,
   - maupun data siswa lainnya.

3. Jika data tidak tersedia, katakan bahwa data tersebut belum tersedia di sistem.

4. Hanya jawab informasi milik siswa yang sedang login.

5. Jangan memberikan data siswa lain.

6. Jangan mengatakan bahwa kamu melihat database secara langsung.

7. Jangan menyebut istilah teknis seperti:
   - database,
   - query,
   - SQL,
   - controller,
   - model,
   - API,
   kecuali siswa memang menanyakannya.

8. Jika pertanyaan berkaitan dengan jadwal, gunakan DATA JADWAL.

9. Jika pertanyaan berkaitan dengan kehadiran atau presensi, gunakan DATA PRESENSI.

10. Jika pertanyaan membutuhkan kedua data tersebut, kamu boleh menggabungkannya.

11. Jangan mengganti fakta yang diberikan sistem dengan pengetahuan umum.

12. Jika siswa bertanya "sekarang", gunakan tanggal dan waktu yang diberikan sistem.

13. Waktu yang digunakan adalah WIB / Asia Jakarta.

14. Jawaban tidak perlu terlalu panjang kecuali siswa meminta penjelasan lengkap.


{$scheduleContext}


{$attendanceContext}


=== CONTOH CARA MENJAWAB ===

Jika siswa bertanya:
"Sekarang saya pelajaran apa?"

Jawab berdasarkan jadwal yang sedang berlangsung.


Jika siswa bertanya:
"Hari ini saya sudah presensi belum?"

Jawab berdasarkan PRESENSI HARI INI.


Jika siswa bertanya:
"Minggu ini saya alfa berapa kali?"

Jawab berdasarkan REKAP MINGGU INI.


Jika siswa bertanya:
"Saya izin hari apa?"

Gunakan DETAIL PRESENSI MINGGU INI.


Jika siswa bertanya:
"Setelah ini pelajaran apa?"

Gunakan jadwal setelah waktu sekarang.


Jika siswa bertanya:
"Hari ini saya pulang jam berapa?"

Gunakan waktu berakhir jadwal terakhir pada hari ini.


Jika data tidak tersedia:

Jangan menebak.

Katakan secara natural bahwa informasi tersebut belum tersedia di Sistem KKO SMANDA.
CONTEXT;
    }


    /*
    |--------------------------------------------------------------------------
    | BUILD CONTEXT JADWAL
    |--------------------------------------------------------------------------
    */

    private function buildScheduleContext(
        $student
    ): string
    {
        /*
        |--------------------------------------------------------------------------
        | WAKTU SEKARANG
        |--------------------------------------------------------------------------
        */

        $now =
            Carbon::now(
                'Asia/Jakarta'
            );


        $currentDay =
            (int)
            $now->dayOfWeekIso;


        $currentTime =
            $now->format(
                'H:i:s'
            );


        /*
        |--------------------------------------------------------------------------
        | LABEL HARI
        |--------------------------------------------------------------------------
        */

        $dayLabels = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu',
        ];


        $currentDayLabel =
            $dayLabels[
                $currentDay
            ]
            ??
            '-';


        /*
        |--------------------------------------------------------------------------
        | JADWAL HARI INI
        |--------------------------------------------------------------------------
        */

        $todaySchedules =
            SchoolSchedule::query()
                ->with(
                    'subject'
                )
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
                ->orderBy(
                    'start_time'
                )
                ->get();


        /*
        |--------------------------------------------------------------------------
        | JADWAL SEKARANG
        |--------------------------------------------------------------------------
        */

        $currentSchedule =
            $todaySchedules
                ->first(
                    function (
                        $schedule
                    ) use (
                        $currentTime
                    ) {

                        return
                            $schedule->start_time
                                <=
                                $currentTime
                            &&
                            $schedule->end_time
                                >
                                $currentTime;

                    }
                );


        /*
        |--------------------------------------------------------------------------
        | JADWAL BERIKUTNYA
        |--------------------------------------------------------------------------
        */

        $nextSchedule =
            $todaySchedules
                ->first(
                    function (
                        $schedule
                    ) use (
                        $currentTime
                    ) {

                        return
                            $schedule->start_time
                                >
                                $currentTime;

                    }
                );


        /*
        |--------------------------------------------------------------------------
        | PELAJARAN BERIKUTNYA
        |--------------------------------------------------------------------------
        |
        | Berbeda dengan nextSchedule.
        |
        | nextSchedule bisa berupa:
        | - istirahat
        | - ISHOMA
        | - activity
        |
        | nextLesson khusus mencari pelajaran.
        |
        */

        $nextLesson =
            $todaySchedules
                ->first(
                    function (
                        $schedule
                    ) use (
                        $currentTime
                    ) {

                        return
                            $schedule->start_time
                                >
                                $currentTime
                            &&
                            $schedule->schedule_type
                                ===
                                'lesson';

                    }
                );


        /*
        |--------------------------------------------------------------------------
        | JADWAL BESOK
        |--------------------------------------------------------------------------
        */

        $tomorrow =
            $now
                ->copy()
                ->addDay();


        $tomorrowDay =
            (int)
            $tomorrow
                ->dayOfWeekIso;


        $tomorrowDayLabel =
            $dayLabels[
                $tomorrowDay
            ]
            ??
            '-';


        $tomorrowSchedules =
            collect();


        if (
            $tomorrowDay >= 1
            &&
            $tomorrowDay <= 5
        ) {

            $tomorrowSchedules =
                SchoolSchedule::query()
                    ->with(
                        'subject'
                    )
                    ->where(
                        'class_id',
                        $student->class_id
                    )
                    ->where(
                        'day_of_week',
                        $tomorrowDay
                    )
                    ->where(
                        'status',
                        true
                    )
                    ->orderBy(
                        'start_time'
                    )
                    ->get();

        }


        /*
        |--------------------------------------------------------------------------
        | FORMAT JADWAL HARI INI
        |--------------------------------------------------------------------------
        */

        $todayLines =
            $todaySchedules
                ->map(
                    function (
                        $schedule
                    ) {

                        return
                            '- '
                            .
                            $this
                                ->formatScheduleLine(
                                    $schedule
                                );

                    }
                )
                ->implode(
                    PHP_EOL
                );


        if (
            $todayLines
            ===
            ''
        ) {

            $todayLines =
                '- Tidak ada jadwal sekolah.';

        }


        /*
        |--------------------------------------------------------------------------
        | FORMAT JADWAL BESOK
        |--------------------------------------------------------------------------
        */

        $tomorrowLines =
            $tomorrowSchedules
                ->map(
                    function (
                        $schedule
                    ) {

                        return
                            '- '
                            .
                            $this
                                ->formatScheduleLine(
                                    $schedule
                                );

                    }
                )
                ->implode(
                    PHP_EOL
                );


        if (
            $tomorrowLines
            ===
            ''
        ) {

            $tomorrowLines =
                '- Tidak ada jadwal sekolah.';

        }


        /*
        |--------------------------------------------------------------------------
        | JADWAL SEKARANG
        |--------------------------------------------------------------------------
        */

        $currentScheduleText =
            $currentSchedule
                ?
                $this
                    ->formatScheduleLine(
                        $currentSchedule
                    )
                :
                'Tidak ada jadwal yang sedang berlangsung.';


        /*
        |--------------------------------------------------------------------------
        | JADWAL BERIKUTNYA
        |--------------------------------------------------------------------------
        */

        $nextScheduleText =
            $nextSchedule
                ?
                $this
                    ->formatScheduleLine(
                        $nextSchedule
                    )
                :
                'Tidak ada jadwal berikutnya hari ini.';


        /*
        |--------------------------------------------------------------------------
        | PELAJARAN BERIKUTNYA
        |--------------------------------------------------------------------------
        */

        $nextLessonText =
            $nextLesson
                ?
                $this
                    ->formatScheduleLine(
                        $nextLesson
                    )
                :
                'Tidak ada pelajaran berikutnya hari ini.';


        /*
        |--------------------------------------------------------------------------
        | JAM PULANG
        |--------------------------------------------------------------------------
        */

        $lastSchedule =
            $todaySchedules
                ->last();


        $schoolEndTime =
            $lastSchedule
                ?
                Carbon::parse(
                    $lastSchedule->end_time
                )
                    ->format(
                        'H:i'
                    )
                :
                '-';


        /*
        |--------------------------------------------------------------------------
        | CONTEXT
        |--------------------------------------------------------------------------
        */

        return <<<SCHEDULE
=== DATA JADWAL SISWA ===

Nama siswa: {$student->user?->name}
Kelas: {$student->class?->name}

Tanggal sekarang: {$now->locale('id')->translatedFormat('l, d F Y')}
Hari sekarang: {$currentDayLabel}
Waktu sekarang: {$now->format('H:i')} WIB

JADWAL YANG SEDANG BERLANGSUNG:
{$currentScheduleText}

JADWAL BERIKUTNYA:
{$nextScheduleText}

PELAJARAN BERIKUTNYA:
{$nextLessonText}

JAM SELESAI SEKOLAH HARI INI:
{$schoolEndTime} WIB

JADWAL HARI INI:
{$todayLines}

JADWAL BESOK ({$tomorrowDayLabel}):
{$tomorrowLines}

ATURAN DATA JADWAL:
- Gunakan jadwal di atas sebagai sumber kebenaran.
- Jangan mengarang mata pelajaran.
- Jangan mengarang jam pelajaran.
- Jika schedule_type adalah break, itu adalah waktu istirahat.
- Jika schedule_type adalah activity, itu adalah kegiatan sekolah.
- Jika schedule_type adalah lesson, itu adalah pelajaran.
- Untuk pertanyaan "pelajaran berikutnya", prioritaskan schedule_type lesson.
- Untuk pertanyaan "jadwal berikutnya", break atau activity juga boleh disebut.
- Jika hari Sabtu atau Minggu dan tidak ada jadwal, katakan tidak ada jadwal sekolah.
SCHEDULE;
    }


    /*
    |--------------------------------------------------------------------------
    | FORMAT SATU JADWAL
    |--------------------------------------------------------------------------
    */

    private function formatScheduleLine(
        $schedule
    ): string
    {
        /*
        |--------------------------------------------------------------------------
        | JAM
        |--------------------------------------------------------------------------
        */

        $startTime =
            Carbon::parse(
                $schedule->start_time
            )
                ->format(
                    'H:i'
                );


        $endTime =
            Carbon::parse(
                $schedule->end_time
            )
                ->format(
                    'H:i'
                );


        /*
        |--------------------------------------------------------------------------
        | NAMA JADWAL
        |--------------------------------------------------------------------------
        */

        $name =
            match (
                $schedule->schedule_type
            ) {

                'lesson' =>
                    $schedule->subject?->name
                    ??
                    $schedule->label
                    ??
                    'Pelajaran',

                'break' =>
                    $schedule->label
                    ??
                    'Istirahat',

                'activity' =>
                    $schedule->label
                    ??
                    'Kegiatan',

                default =>
                    $schedule->subject?->name
                    ??
                    $schedule->label
                    ??
                    'Jadwal',

            };


        /*
        |--------------------------------------------------------------------------
        | TYPE
        |--------------------------------------------------------------------------
        */

        $typeLabel =
            match (
                $schedule->schedule_type
            ) {

                'lesson' =>
                    'Pelajaran',

                'break' =>
                    'Istirahat',

                'activity' =>
                    'Kegiatan',

                default =>
                    'Jadwal',

            };


        /*
        |--------------------------------------------------------------------------
        | DETAIL TAMBAHAN
        |--------------------------------------------------------------------------
        */

        $details =
            [];


        if (
            filled(
                $schedule->teacher_name
            )
        ) {

            $details[] =
                'Guru: '
                .
                $schedule->teacher_name;

        }


        if (
            filled(
                $schedule->room
            )
        ) {

            $details[] =
                'Ruang: '
                .
                $schedule->room;

        }


        /*
        |--------------------------------------------------------------------------
        | HASIL
        |--------------------------------------------------------------------------
        */

        $result =
            $startTime
            .
            '-'
            .
            $endTime
            .
            ' WIB | '
            .
            $name
            .
            ' | '
            .
            $typeLabel;


        if (
            !empty(
                $details
            )
        ) {

            $result .=
                ' | '
                .
                implode(
                    ', ',
                    $details
                );

        }


        return $result;
    }
}