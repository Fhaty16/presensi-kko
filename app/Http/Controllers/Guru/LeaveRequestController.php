<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\TrainingAttendance;
use App\Notifications\LeaveRequestDecisionNotification;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class LeaveRequestController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DAFTAR PENGAJUAN IZIN / SAKIT
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        /*
        |--------------------------------------------------------------------------
        | PENGAJUAN MENUNGGU
        |--------------------------------------------------------------------------
        */

        $pendingRequests =
            LeaveRequest::query()
                ->with([
                    'student.user',
                    'student.class',
                    'trainingSession',
                ])
                ->where(
                    'status',
                    'pending'
                )
                ->latest()
                ->get();


        /*
        |--------------------------------------------------------------------------
        | RIWAYAT TERBARU
        |--------------------------------------------------------------------------
        */

        $recentRequests =
            LeaveRequest::query()
                ->with([
                    'student.user',
                    'student.class',
                    'trainingSession',
                ])
                ->whereIn(
                    'status',
                    [
                        'approved',
                        'rejected',
                    ]
                )
                ->latest(
                    'reviewed_at'
                )
                ->take(10)
                ->get();


        /*
        |--------------------------------------------------------------------------
        | STATISTIK
        |--------------------------------------------------------------------------
        */

        $pendingCount =
            LeaveRequest::query()
                ->where(
                    'status',
                    'pending'
                )
                ->count();


        $approvedCount =
            LeaveRequest::query()
                ->where(
                    'status',
                    'approved'
                )
                ->count();


        $rejectedCount =
            LeaveRequest::query()
                ->where(
                    'status',
                    'rejected'
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'guru.leave-requests.index',
            compact(
                'pendingRequests',
                'recentRequests',
                'pendingCount',
                'approvedCount',
                'rejectedCount'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SETUJUI PENGAJUAN
    |--------------------------------------------------------------------------
    */

    public function approve(
        LeaveRequest $leaveRequest
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | VALIDASI STATUS
        |--------------------------------------------------------------------------
        */

        if (
            $leaveRequest->status
            !== 'pending'
        ) {

            return back()
                ->with(
                    'error',
                    'Pengajuan ini sudah pernah diproses.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | LOAD RELASI
        |--------------------------------------------------------------------------
        */

        $leaveRequest->loadMissing([
            'student.user',
            'student.class',
            'trainingSession',
        ]);


        /*
        |--------------------------------------------------------------------------
        | VALIDASI SISWA
        |--------------------------------------------------------------------------
        */

        if (
            !$leaveRequest->student
        ) {

            return back()
                ->with(
                    'error',
                    'Data siswa pada pengajuan tidak ditemukan.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDASI LATIHAN
        |--------------------------------------------------------------------------
        */

        if (
            $leaveRequest->attendance_scope
            === 'training'
            &&
            !$leaveRequest->trainingSession
        ) {

            return back()
                ->with(
                    'error',
                    'Sesi latihan pada pengajuan ini tidak ditemukan.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | TRANSACTION
        |--------------------------------------------------------------------------
        */

        DB::transaction(
            function () use (
                $leaveRequest
            ) {

                /*
                |--------------------------------------------------------------------------
                | STATUS PRESENSI
                |--------------------------------------------------------------------------
                |
                | permission = Izin
                | sick       = Sakit
                |
                */

                $attendanceStatus =
                    $leaveRequest->type
                    === 'sick'
                        ? 'sick'
                        : 'permission';


                /*
                |--------------------------------------------------------------------------
                | PENGAJUAN LATIHAN
                |--------------------------------------------------------------------------
                */

                if (
                    $leaveRequest->attendance_scope
                    === 'training'
                ) {

                    $this
                        ->approveTrainingRequest(
                            $leaveRequest,
                            $attendanceStatus
                        );

                } else {

                    /*
                    |--------------------------------------------------------------------------
                    | PENGAJUAN SEKOLAH
                    |--------------------------------------------------------------------------
                    */

                    $this
                        ->approveSchoolRequest(
                            $leaveRequest,
                            $attendanceStatus
                        );
                }


                /*
                |--------------------------------------------------------------------------
                | UPDATE STATUS PENGAJUAN
                |--------------------------------------------------------------------------
                |
                | reviewed_by TIDAK digunakan karena kolom tersebut
                | belum tersedia pada database leave_requests.
                |
                */

                $leaveRequest->update([

                    'status' =>
                        'approved',

                    'reviewed_at' =>
                        now(),

                ]);
            }
        );


        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA TERBARU
        |--------------------------------------------------------------------------
        */

        $processedRequest =
            $leaveRequest
                ->fresh([
                    'student.user',
                    'student.class',
                    'trainingSession',
                ]);


        /*
        |--------------------------------------------------------------------------
        | KIRIM NOTIFIKASI
        |--------------------------------------------------------------------------
        |
        | Dilakukan setelah transaction selesai.
        |
        | Jadi jika notifikasi gagal, data presensi dan status
        | pengajuan yang sudah berhasil tidak ikut rollback.
        |
        */

        if ($processedRequest) {

            $this
                ->sendDecisionNotification(
                    $processedRequest
                );
        }


        /*
        |--------------------------------------------------------------------------
        | MESSAGE
        |--------------------------------------------------------------------------
        */

        $destination =
            $leaveRequest->attendance_scope
            === 'training'
                ? 'latihan KKO'
                : 'presensi sekolah';


        return back()
            ->with(
                'success',
                'Pengajuan '
                . $destination
                . ' berhasil disetujui.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SETUJUI PENGAJUAN SEKOLAH
    |--------------------------------------------------------------------------
    */

    private function approveSchoolRequest(
        LeaveRequest $leaveRequest,
        string $attendanceStatus
    ): void {

        /*
        |--------------------------------------------------------------------------
        | TANGGAL MULAI
        |--------------------------------------------------------------------------
        */

        $startDate =
            Carbon::parse(
                $leaveRequest->start_date
            )
                ->startOfDay();


        /*
        |--------------------------------------------------------------------------
        | TANGGAL SELESAI
        |--------------------------------------------------------------------------
        */

        $endDate =
            Carbon::parse(
                $leaveRequest->end_date
            )
                ->startOfDay();


        /*
        |--------------------------------------------------------------------------
        | LOOP TANGGAL
        |--------------------------------------------------------------------------
        */

        $currentDate =
            $startDate->copy();


        while (
            $currentDate->lte(
                $endDate
            )
        ) {

            /*
            |--------------------------------------------------------------------------
            | HANYA SENIN - JUMAT
            |--------------------------------------------------------------------------
            */

            if (
                $currentDate->isWeekday()
            ) {

                /*
                |--------------------------------------------------------------------------
                | CARI PRESENSI SISWA
                |--------------------------------------------------------------------------
                */

                $existingAttendance =
                    Attendance::query()
                        ->where(
                            'student_id',
                            $leaveRequest->student_id
                        )
                        ->whereDate(
                            'attendance_date',
                            $currentDate
                                ->toDateString()
                        )
                        ->first();


                /*
                |--------------------------------------------------------------------------
                | BELUM ADA PRESENSI
                |--------------------------------------------------------------------------
                */

                if (
                    !$existingAttendance
                ) {

                    Attendance::create([

                        'student_id' =>
                            $leaveRequest
                                ->student_id,

                        'barcode_id' =>
                            null,

                        'attendance_date' =>
                            $currentDate
                                ->toDateString(),

                        'check_in_time' =>
                            null,

                        'status' =>
                            $attendanceStatus,

                        'notes' =>
                            $this
                                ->buildSchoolAttendanceNote(
                                    $leaveRequest
                                ),

                        'wa_sent' =>
                            false,

                    ]);


                /*
                |--------------------------------------------------------------------------
                | SUDAH TERLANJUR ALFA
                |--------------------------------------------------------------------------
                |
                | Jika Auto-Alfa sudah berjalan sebelum Guru menyetujui
                | surat izin/sakit, status Alfa akan dikoreksi.
                |
                */

                } elseif (
                    $existingAttendance->status
                    === 'absent'
                ) {

                    $existingAttendance
                        ->update([

                            'barcode_id' =>
                                null,

                            'check_in_time' =>
                                null,

                            'status' =>
                                $attendanceStatus,

                            'notes' =>
                                $this
                                    ->buildSchoolAttendanceNote(
                                        $leaveRequest
                                    ),

                        ]);
                }


                /*
                |--------------------------------------------------------------------------
                | STATUS LAIN TIDAK DITIMPA
                |--------------------------------------------------------------------------
                |
                | present
                | late
                | permission
                | sick
                |
                | Tetap dipertahankan.
                |
                */
            }


            /*
            |--------------------------------------------------------------------------
            | TANGGAL BERIKUTNYA
            |--------------------------------------------------------------------------
            */

            $currentDate
                ->addDay();
        }
    }


    /*
    |--------------------------------------------------------------------------
    | SETUJUI PENGAJUAN LATIHAN KKO
    |--------------------------------------------------------------------------
    */

    private function approveTrainingRequest(
        LeaveRequest $leaveRequest,
        string $attendanceStatus
    ): void {

        /*
        |--------------------------------------------------------------------------
        | SESI LATIHAN
        |--------------------------------------------------------------------------
        */

        $trainingSession =
            $leaveRequest
                ->trainingSession;


        /*
        |--------------------------------------------------------------------------
        | CARI PRESENSI SISWA
        |--------------------------------------------------------------------------
        */

        $existingAttendance =
            TrainingAttendance::query()
                ->where(
                    'training_session_id',
                    $trainingSession->id
                )
                ->where(
                    'student_id',
                    $leaveRequest->student_id
                )
                ->first();


        /*
        |--------------------------------------------------------------------------
        | BELUM ADA PRESENSI
        |--------------------------------------------------------------------------
        */

        if (
            !$existingAttendance
        ) {

            TrainingAttendance::create([

                'training_session_id' =>
                    $trainingSession->id,

                'student_id' =>
                    $leaveRequest
                        ->student_id,

                'status' =>
                    $attendanceStatus,

                'checked_in_at' =>
                    null,

                'notes' =>
                    $this
                        ->buildTrainingAttendanceNote(
                            $leaveRequest
                        ),

            ]);


            return;
        }


        /*
        |--------------------------------------------------------------------------
        | SUDAH ALFA
        |--------------------------------------------------------------------------
        */

        if (
            $existingAttendance->status
            === 'absent'
        ) {

            $existingAttendance
                ->update([

                    'status' =>
                        $attendanceStatus,

                    'checked_in_at' =>
                        null,

                    'notes' =>
                        $this
                            ->buildTrainingAttendanceNote(
                                $leaveRequest
                            ),

                ]);


            return;
        }


        /*
        |--------------------------------------------------------------------------
        | STATUS LAIN TIDAK DITIMPA
        |--------------------------------------------------------------------------
        |
        | present
        | late
        | permission
        | sick
        |
        */
    }


    /*
    |--------------------------------------------------------------------------
    | TOLAK PENGAJUAN
    |--------------------------------------------------------------------------
    */

    public function reject(
        LeaveRequest $leaveRequest
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | VALIDASI STATUS
        |--------------------------------------------------------------------------
        */

        if (
            $leaveRequest->status
            !== 'pending'
        ) {

            return back()
                ->with(
                    'error',
                    'Pengajuan ini sudah pernah diproses.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | LOAD RELASI
        |--------------------------------------------------------------------------
        */

        $leaveRequest->loadMissing([
            'student.user',
            'student.class',
            'trainingSession',
        ]);


        /*
        |--------------------------------------------------------------------------
        | VALIDASI SISWA
        |--------------------------------------------------------------------------
        */

        if (
            !$leaveRequest->student
        ) {

            return back()
                ->with(
                    'error',
                    'Data siswa pada pengajuan tidak ditemukan.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE STATUS
        |--------------------------------------------------------------------------
        |
        | Pengajuan ditolak tidak membuat Attendance.
        |
        | reviewed_by TIDAK digunakan karena kolom belum tersedia.
        |
        */

        $leaveRequest->update([

            'status' =>
                'rejected',

            'reviewed_at' =>
                now(),

        ]);


        /*
        |--------------------------------------------------------------------------
        | DATA TERBARU
        |--------------------------------------------------------------------------
        */

        $processedRequest =
            $leaveRequest
                ->fresh([
                    'student.user',
                    'student.class',
                    'trainingSession',
                ]);


        /*
        |--------------------------------------------------------------------------
        | KIRIM NOTIFIKASI
        |--------------------------------------------------------------------------
        */

        if ($processedRequest) {

            $this
                ->sendDecisionNotification(
                    $processedRequest
                );
        }


        /*
        |--------------------------------------------------------------------------
        | MESSAGE
        |--------------------------------------------------------------------------
        */

        $destination =
            $leaveRequest->attendance_scope
            === 'training'
                ? 'latihan KKO'
                : 'presensi sekolah';


        return back()
            ->with(
                'success',
                'Pengajuan '
                . $destination
                . ' berhasil ditolak.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | KIRIM NOTIFIKASI KE SISWA
    |--------------------------------------------------------------------------
    */

    private function sendDecisionNotification(
        LeaveRequest $leaveRequest
    ): void {

        try {

            /*
            |--------------------------------------------------------------------------
            | LOAD RELASI
            |--------------------------------------------------------------------------
            */

            $leaveRequest
                ->loadMissing([
                    'student.user',
                    'student.class',
                    'trainingSession',
                ]);


            /*
            |--------------------------------------------------------------------------
            | USER SISWA
            |--------------------------------------------------------------------------
            */

            $user =
                $leaveRequest
                    ->student
                    ?->user;


            /*
            |--------------------------------------------------------------------------
            | JIKA USER TIDAK ADA
            |--------------------------------------------------------------------------
            */

            if (!$user) {

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | DATABASE NOTIFICATION
            |--------------------------------------------------------------------------
            */

            $user
                ->notify(
                    new LeaveRequestDecisionNotification(
                        $leaveRequest
                    )
                );

        } catch (Throwable $exception) {

            /*
            |--------------------------------------------------------------------------
            | LOG ERROR
            |--------------------------------------------------------------------------
            |
            | Notifikasi yang gagal tidak boleh membuat proses
            | Setujui / Tolak ikut gagal.
            |
            */

            report(
                $exception
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | CATATAN PRESENSI SEKOLAH
    |--------------------------------------------------------------------------
    */

    private function buildSchoolAttendanceNote(
        LeaveRequest $leaveRequest
    ): string {

        /*
        |--------------------------------------------------------------------------
        | LABEL
        |--------------------------------------------------------------------------
        */

        $type =
            $leaveRequest->type
            === 'sick'
                ? 'Sakit'
                : 'Izin';


        /*
        |--------------------------------------------------------------------------
        | CATATAN
        |--------------------------------------------------------------------------
        */

        return
            $type
            . ' berdasarkan pengajuan siswa yang telah disetujui. '
            . 'Alasan: '
            . $leaveRequest->reason;
    }


    /*
    |--------------------------------------------------------------------------
    | CATATAN PRESENSI LATIHAN
    |--------------------------------------------------------------------------
    */

    private function buildTrainingAttendanceNote(
        LeaveRequest $leaveRequest
    ): string {

        /*
        |--------------------------------------------------------------------------
        | LABEL
        |--------------------------------------------------------------------------
        */

        $type =
            $leaveRequest->type
            === 'sick'
                ? 'Sakit'
                : 'Izin';


        /*
        |--------------------------------------------------------------------------
        | CATATAN
        |--------------------------------------------------------------------------
        */

        return
            $type
            . ' latihan berdasarkan pengajuan siswa yang telah disetujui. '
            . 'Alasan: '
            . $leaveRequest->reason;
    }
}