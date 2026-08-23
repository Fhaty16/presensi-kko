<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\LeaveRequest;
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
        $pendingRequests = LeaveRequest::with([
                'student.user',
                'student.class',
            ])
            ->where('status', 'pending')
            ->latest()
            ->get();


        $recentRequests = LeaveRequest::with([
                'student.user',
                'student.class',
            ])
            ->whereIn('status', [
                'approved',
                'rejected',
            ])
            ->latest('reviewed_at')
            ->take(10)
            ->get();


        $pendingCount = LeaveRequest::where(
            'status',
            'pending'
        )->count();


        $approvedCount = LeaveRequest::where(
            'status',
            'approved'
        )->count();


        $rejectedCount = LeaveRequest::where(
            'status',
            'rejected'
        )->count();


        return view(
            'guru.leave-requests.index',
            compact(
                'pendingRequests',
                'recentRequests',
                'pendingCount',
                'approvedCount',
                'rejectedCount',
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

        if ($leaveRequest->status !== 'pending') {

            return back()->with(
                'error',
                'Pengajuan ini sudah pernah diproses.'
            );
        }


        DB::transaction(function () use ($leaveRequest) {

            /*
            |--------------------------------------------------------------------------
            | UBAH STATUS PENGAJUAN
            |--------------------------------------------------------------------------
            */

            $leaveRequest->update([

                'status' => 'approved',

                'reviewed_at' => now(),

            ]);


            /*
            |--------------------------------------------------------------------------
            | STATUS PRESENSI
            |--------------------------------------------------------------------------
            |
            | permission -> Izin
            | sick       -> Sakit
            |
            */

            $attendanceStatus =
                $leaveRequest->type === 'sick'
                    ? 'sick'
                    : 'permission';


            /*
            |--------------------------------------------------------------------------
            | RENTANG TANGGAL
            |--------------------------------------------------------------------------
            */

            $startDate =
                Carbon::parse(
                    $leaveRequest->start_date
                )->startOfDay();


            $endDate =
                Carbon::parse(
                    $leaveRequest->end_date
                )->startOfDay();


            $currentDate =
                $startDate->copy();


            while (
                $currentDate->lte($endDate)
            ) {

                /*
                |--------------------------------------------------------------------------
                | HANYA SENIN - JUMAT
                |--------------------------------------------------------------------------
                */

                if ($currentDate->isWeekday()) {

                    $existingAttendance =
                        Attendance::where(
                            'student_id',
                            $leaveRequest->student_id
                        )
                        ->whereDate(
                            'attendance_date',
                            $currentDate->toDateString()
                        )
                        ->first();


                    /*
                    |--------------------------------------------------------------------------
                    | BELUM ADA PRESENSI
                    |--------------------------------------------------------------------------
                    */

                    if (!$existingAttendance) {

                        Attendance::create([

                            'student_id' =>
                                $leaveRequest->student_id,

                            'barcode_id' =>
                                null,

                            'attendance_date' =>
                                $currentDate->toDateString(),

                            'check_in_time' =>
                                null,

                            'status' =>
                                $attendanceStatus,

                            'notes' =>
                                $this->buildAttendanceNote(
                                    $leaveRequest
                                ),

                            'wa_sent' =>
                                false,

                        ]);

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | SUDAH ALFA
                    |--------------------------------------------------------------------------
                    |
                    | Jika Auto Alfa sudah membuat status absent,
                    | maka setelah izin disetujui status Alfa
                    | diubah menjadi Izin / Sakit.
                    |
                    */

                    elseif (
                        $existingAttendance->status
                        === 'absent'
                    ) {

                        $existingAttendance->update([

                            'barcode_id' =>
                                null,

                            'check_in_time' =>
                                null,

                            'status' =>
                                $attendanceStatus,

                            'notes' =>
                                $this->buildAttendanceNote(
                                    $leaveRequest
                                ),

                        ]);

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | HADIR / TERLAMBAT TIDAK DITIMPA
                    |--------------------------------------------------------------------------
                    |
                    | Jika siswa sudah scan kehadiran,
                    | data hadir tetap dipertahankan.
                    |
                    */

                }


                $currentDate->addDay();
            }

        });


        return back()->with(
            'success',
            'Pengajuan berhasil disetujui.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | TOLAK PENGAJUAN
    |--------------------------------------------------------------------------
    */

    public function reject(
        LeaveRequest $leaveRequest
    ): RedirectResponse {

        if ($leaveRequest->status !== 'pending') {

            return back()->with(
                'error',
                'Pengajuan ini sudah pernah diproses.'
            );
        }


        $leaveRequest->update([

            'status' => 'rejected',

            'reviewed_at' => now(),

        ]);


        return back()->with(
            'success',
            'Pengajuan berhasil ditolak.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CATATAN PRESENSI
    |--------------------------------------------------------------------------
    */

    private function buildAttendanceNote(
        LeaveRequest $leaveRequest
    ): string {

        $type =
            $leaveRequest->type === 'sick'
                ? 'Sakit'
                : 'Izin';


        return
            $type
            . ' berdasarkan pengajuan siswa yang telah disetujui. '
            . 'Alasan: '
            . $leaveRequest->reason;
    }
}