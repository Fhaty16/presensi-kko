<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\TrainingAttendance;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

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
        | CEK STATUS
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
        | LOAD RELATIONSHIP
        |--------------------------------------------------------------------------
        */

        $leaveRequest->loadMissing([
            'student',
            'trainingSession',
        ]);


        /*
        |--------------------------------------------------------------------------
        | VALIDASI PENGAJUAN LATIHAN
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
                | PRESENSI LATIHAN KKO
                |--------------------------------------------------------------------------
                */

                if (
                    $leaveRequest
                        ->attendance_scope
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
                    | PRESENSI SEKOLAH
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
                | UBAH STATUS PENGAJUAN
                |--------------------------------------------------------------------------
                |
                | Dilakukan setelah proses presensi berhasil.
                | Jika terjadi error, transaction akan rollback semuanya.
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
        | RENTANG TANGGAL
        |--------------------------------------------------------------------------
        */

        $startDate =
            Carbon::parse(
                $leaveRequest->start_date
            )
                ->startOfDay();


        $endDate =
            Carbon::parse(
                $leaveRequest->end_date
            )
                ->startOfDay();


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
                | SUDAH ALFA
                |--------------------------------------------------------------------------
                |
                | Jika sistem Alfa otomatis sudah membuat absent,
                | pengajuan yang disetujui mengoreksinya menjadi
                | Izin / Sakit.
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
                | tetap dipertahankan.
                |
                */
            }


            $currentDate->addDay();
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

        $trainingSession =
            $leaveRequest
                ->trainingSession;


        /*
        |--------------------------------------------------------------------------
        | CARI PRESENSI LATIHAN SISWA
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
        |
        | Contoh:
        |
        | siswa tidak scan
        | ↓
        | +30 menit
        | ↓
        | sistem membuat Alfa
        | ↓
        | Guru baru menyetujui surat izin
        | ↓
        | Alfa berubah menjadi Izin / Sakit
        |
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
        | STATUS YANG SUDAH ADA TIDAK DITIMPA
        |--------------------------------------------------------------------------
        |
        | present
        | late
        | permission
        | sick
        |
        | Misalnya siswa ternyata sudah melakukan scan,
        | data kehadiran tersebut tetap dipertahankan.
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
        | CEK STATUS
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
        | TOLAK
        |--------------------------------------------------------------------------
        |
        | Tidak membuat Attendance maupun TrainingAttendance.
        |
        */

        $leaveRequest->update([

            'status' =>
                'rejected',

            'reviewed_at' =>
                now(),

        ]);


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
    | CATATAN PRESENSI SEKOLAH
    |--------------------------------------------------------------------------
    */

    private function buildSchoolAttendanceNote(
        LeaveRequest $leaveRequest
    ): string {

        $type =
            $leaveRequest->type
                === 'sick'
                    ? 'Sakit'
                    : 'Izin';


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

        $type =
            $leaveRequest->type
                === 'sick'
                    ? 'Sakit'
                    : 'Izin';


        return
            $type
            . ' latihan berdasarkan pengajuan siswa yang telah disetujui. '
            . 'Alasan: '
            . $leaveRequest->reason;
    }
}