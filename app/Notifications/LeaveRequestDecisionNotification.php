<?php

namespace App\Notifications;

use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LeaveRequestDecisionNotification extends Notification
{
    use Queueable;

    public function __construct(
        public LeaveRequest $leaveRequest
    ) {
    }

    public function via(object $notifiable): array
    {
        return [
            'database',
        ];
    }

    public function toArray(object $notifiable): array
    {
        $isApproved =
            $this->leaveRequest->status === 'approved';

        $typeLabel =
            $this->leaveRequest->type === 'sick'
                ? 'Sakit'
                : 'Izin';

        $scopeLabel =
            $this->leaveRequest->attendance_scope === 'training'
                ? 'Latihan KKO'
                : 'Presensi Sekolah';

        $period =
            $this->buildPeriod();

        $title =
            $isApproved
                ? 'Pengajuan Disetujui'
                : 'Pengajuan Ditolak';

        $message =
            'Pengajuan '
            . $typeLabel
            . ' untuk '
            . $scopeLabel
            . ' '
            . $period
            . ' telah '
            . (
                $isApproved
                    ? 'disetujui'
                    : 'ditolak'
            )
            . ' oleh Guru KKO.';

        return [

            'leave_request_id' =>
                $this->leaveRequest->id,

            'status' =>
                $this->leaveRequest->status,

            'title' =>
                $title,

            'message' =>
                $message,

            'type' =>
                $this->leaveRequest->type,

            'type_label' =>
                $typeLabel,

            'attendance_scope' =>
                $this->leaveRequest->attendance_scope,

            'scope_label' =>
                $scopeLabel,

            'period' =>
                $period,

        ];
    }

    private function buildPeriod(): string
    {
        /*
        |--------------------------------------------------------------------------
        | LATIHAN KKO
        |--------------------------------------------------------------------------
        */

        if (
            $this->leaveRequest->attendance_scope === 'training'
            &&
            $this->leaveRequest->trainingSession
        ) {

            $date =
                Carbon::parse(
                    $this->leaveRequest
                        ->trainingSession
                        ->training_date
                )
                    ->locale('id')
                    ->translatedFormat('d F Y');

            return
                'tanggal '
                . $date;
        }


        /*
        |--------------------------------------------------------------------------
        | PRESENSI SEKOLAH
        |--------------------------------------------------------------------------
        */

        $startDate =
            Carbon::parse(
                $this->leaveRequest->start_date
            );

        $endDate =
            Carbon::parse(
                $this->leaveRequest->end_date
            );

        if (
            $startDate->toDateString()
            ===
            $endDate->toDateString()
        ) {

            return
                'tanggal '
                . $startDate
                    ->locale('id')
                    ->translatedFormat('d F Y');
        }

        return
            'tanggal '
            . $startDate
                ->locale('id')
                ->translatedFormat('d F Y')
            . ' sampai '
            . $endDate
                ->locale('id')
                ->translatedFormat('d F Y');
    }
}