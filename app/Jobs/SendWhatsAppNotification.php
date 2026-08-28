<?php

namespace App\Jobs;

use App\Models\WhatsAppNotification;
use App\Services\WhatsAppService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Support\Facades\Log;
use Throwable;

class SendWhatsAppNotification implements ShouldQueue
{
    use Queueable;


    /*
    |--------------------------------------------------------------------------
    | JUMLAH PERCOBAAN
    |--------------------------------------------------------------------------
    */

    public int $tries = 3;


    /*
    |--------------------------------------------------------------------------
    | TIMEOUT
    |--------------------------------------------------------------------------
    */

    public int $timeout = 30;


    /*
    |--------------------------------------------------------------------------
    | ID NOTIFIKASI
    |--------------------------------------------------------------------------
    */

    public int $notificationId;


    /*
    |--------------------------------------------------------------------------
    | CONSTRUCTOR
    |--------------------------------------------------------------------------
    */

    public function __construct(
        int $notificationId
    ) {
        $this->notificationId =
            $notificationId;
    }


    /*
    |--------------------------------------------------------------------------
    | ANTI DOUBLE PROCESS
    |--------------------------------------------------------------------------
    |
    | Job dengan notification_id yang sama tidak boleh diproses
    | secara bersamaan.
    |
    */

    public function middleware(): array
    {
        return [
            (
                new WithoutOverlapping(
                    'whatsapp-notification-'
                    . $this->notificationId
                )
            )->expireAfter(
                120
            ),
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | BACKOFF
    |--------------------------------------------------------------------------
    |
    | Jika gagal:
    |
    | retry 1 = 1 menit
    | retry 2 = 5 menit
    | retry 3 = 15 menit
    |
    */

    public function backoff(): array
    {
        return [
            60,
            300,
            900,
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | HANDLE
    |--------------------------------------------------------------------------
    */

    public function handle(
        WhatsAppService $whatsAppService
    ): void {
        /*
        |--------------------------------------------------------------------------
        | AMBIL NOTIFIKASI
        |--------------------------------------------------------------------------
        */

        $notification =
            WhatsAppNotification::query()
                ->with([
                    'student.user',
                    'attendance',
                ])
                ->find(
                    $this->notificationId
                );


        /*
        |--------------------------------------------------------------------------
        | DATA SUDAH TIDAK ADA
        |--------------------------------------------------------------------------
        */

        if (
            !$notification
        ) {
            Log::warning(
                'WhatsApp Job dilewati karena notification tidak ditemukan.',
                [
                    'notification_id' =>
                        $this->notificationId,
                ]
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | SUDAH SENT
        |--------------------------------------------------------------------------
        */

        if (
            $notification->status
            === 'sent'
        ) {
            Log::info(
                'WhatsApp Job dilewati karena sudah terkirim.',
                [
                    'notification_id' =>
                        $notification->id,
                ]
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | SKIPPED
        |--------------------------------------------------------------------------
        */

        if (
            $notification->status
            === 'skipped'
        ) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | KIRIM
        |--------------------------------------------------------------------------
        */

        $whatsAppService
            ->sendNotification(
                $notification
            );
    }


    /*
    |--------------------------------------------------------------------------
    | FAILED
    |--------------------------------------------------------------------------
    |
    | Dipanggil Laravel jika seluruh retry gagal.
    |
    */

    public function failed(
        ?Throwable $exception
    ): void {
        $notification =
            WhatsAppNotification::find(
                $this->notificationId
            );


        if (
            $notification
            &&
            $notification->status
            !== 'sent'
        ) {
            $notification
                ->markAsFailed(
                    $exception?->getMessage()
                    ?? 'Job WhatsApp gagal.'
                );
        }


        Log::error(
            'WhatsApp Job gagal setelah seluruh percobaan.',
            [
                'notification_id' =>
                    $this->notificationId,

                'error' =>
                    $exception?->getMessage(),
            ]
        );
    }
}