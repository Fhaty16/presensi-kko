<?php

namespace App\Services;

use App\Jobs\SendWhatsAppNotification;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\WhatsAppNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;

class WhatsAppService
{
    /*
    |--------------------------------------------------------------------------
    | BUAT NOTIFIKASI PRESENSI
    |--------------------------------------------------------------------------
    |
    | Status yang dikirim:
    | present = Hadir
    | late    = Terlambat
    | absent  = Alfa
    |
    */
    public function createAttendanceNotification(
        Student $student,
        Attendance $attendance
    ): ?WhatsAppNotification {
        $parentPhone = $this->normalizePhone($student->parent_phone);

        if (!$parentPhone) {
            Log::warning(
                'WhatsApp tidak dibuat karena parent_phone kosong.',
                [
                    'student_id' => $student->id,
                    'nis' => $student->nis,
                    'attendance_id' => $attendance->id,
                ]
            );

            return null;
        }

        $attendanceStatus = strtolower((string) $attendance->status);

        if (
            !in_array(
                $attendanceStatus,
                ['present', 'late', 'absent'],
                true
            )
        ) {
            Log::info(
                'Status presensi tidak membutuhkan WhatsApp.',
                [
                    'student_id' => $student->id,
                    'attendance_id' => $attendance->id,
                    'status' => $attendanceStatus,
                ]
            );

            return null;
        }

        $eventKey =
            'school_attendance:'
            . $attendance->id
            . ':'
            . $attendanceStatus;

        $notificationType =
            $attendanceStatus === 'absent'
                ? 'absent'
                : 'check_in';

        $message = $this->buildAttendanceMessage(
            $student,
            $attendance
        );

        $notification = WhatsAppNotification::firstOrCreate(
            [
                'event_key' => $eventKey,
            ],
            [
                'student_id' => $student->id,
                'attendance_id' => $attendance->id,
                'notification_type' => $notificationType,
                'attendance_status' => $attendanceStatus,
                'recipient_phone' => $parentPhone,
                'message' => $message,
                'status' => 'pending',
                'attempts' => 0,
            ]
        );

        if ($notification->wasRecentlyCreated) {
            Log::info(
                'WHATSAPP NOTIFICATION CREATED',
                [
                    'notification_id' => $notification->id,
                    'student_id' => $student->id,
                    'nis' => $student->nis,
                    'attendance_id' => $attendance->id,
                    'recipient_phone' => $this->maskPhone(
                        $notification->recipient_phone
                    ),
                    'attendance_status' => $notification->attendance_status,
                ]
            );

            $this->dispatchNotificationJob(
                $notification,
                'WhatsApp Job berhasil didispatch.',
                'Gagal dispatch WhatsApp Job.'
            );
        } else {
            Log::info(
                'WhatsApp Notification sudah ada. Duplikat tidak dibuat.',
                [
                    'notification_id' => $notification->id,
                    'event_key' => $notification->event_key,
                    'status' => $notification->status,
                ]
            );
        }

        return $notification;
    }

    /*
    |--------------------------------------------------------------------------
    | BUAT NOTIFIKASI KOREKSI ALFA
    |--------------------------------------------------------------------------
    |
    | Digunakan ketika:
    |
    | absent -> permission
    | absent -> sick
    |
    | Jika pesan Alfa sebelumnya belum terkirim, pesan Alfa tersebut
    | dibatalkan dan tidak perlu mengirim correction.
    |
    */
    public function createAttendanceCorrectionNotification(
        Student $student,
        Attendance $attendance,
        string $previousStatus
    ): ?WhatsAppNotification {
        $previousStatus = strtolower(trim($previousStatus));
        $newStatus = strtolower((string) $attendance->status);

        if (
            $previousStatus !== 'absent'
            ||
            !in_array(
                $newStatus,
                ['permission', 'sick'],
                true
            )
        ) {
            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | CARI NOTIFIKASI ALFA SEBELUMNYA
        |--------------------------------------------------------------------------
        */
        $previousNotification = WhatsAppNotification::query()
            ->where('attendance_id', $attendance->id)
            ->where('notification_type', 'absent')
            ->where('attendance_status', 'absent')
            ->latest('id')
            ->first();

        /*
        |--------------------------------------------------------------------------
        | TIDAK ADA NOTIFIKASI ALFA
        |--------------------------------------------------------------------------
        */
        if (!$previousNotification) {
            Log::info(
                'WhatsApp correction tidak dibuat karena notification Alfa sebelumnya tidak ditemukan.',
                [
                    'student_id' => $student->id,
                    'attendance_id' => $attendance->id,
                    'new_status' => $newStatus,
                ]
            );

            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | ALFA BELUM TERKIRIM
        |--------------------------------------------------------------------------
        |
        | Jika masih pending/failed/skipped, jangan kirim correction.
        |
        | Pending/failed diubah menjadi skipped agar Job lama tidak lagi
        | mengirim informasi Alfa yang sudah tidak berlaku.
        |
        */
        if (
            in_array(
                $previousNotification->status,
                ['pending', 'failed', 'skipped'],
                true
            )
        ) {
            if ($previousNotification->status !== 'skipped') {
                $previousNotification->markAsSkipped(
                    'Notifikasi Alfa dibatalkan karena status presensi telah dikoreksi menjadi '
                    . strtoupper($newStatus)
                    . '.'
                );
            }

            Log::info(
                'WhatsApp Alfa dibatalkan karena belum terkirim dan presensi sudah dikoreksi.',
                [
                    'notification_id' => $previousNotification->id,
                    'student_id' => $student->id,
                    'attendance_id' => $attendance->id,
                    'new_status' => $newStatus,
                ]
            );

            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | ALFA SUDAH / SEDANG DIPROSES
        |--------------------------------------------------------------------------
        */
        if (
            !in_array(
                $previousNotification->status,
                ['sent', 'processing'],
                true
            )
        ) {
            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | NOMOR PENERIMA
        |--------------------------------------------------------------------------
        |
        | Prioritaskan nomor yang menerima pesan Alfa sebelumnya.
        |
        */
        $recipientPhone = $previousNotification->recipient_phone;

        if (!$recipientPhone) {
            $recipientPhone = $this->normalizePhone(
                $student->parent_phone
            );
        }

        if (!$recipientPhone) {
            Log::warning(
                'WhatsApp correction tidak dibuat karena nomor tujuan kosong.',
                [
                    'student_id' => $student->id,
                    'attendance_id' => $attendance->id,
                ]
            );

            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | EVENT KEY
        |--------------------------------------------------------------------------
        |
        | Contoh:
        |
        | school_attendance:190:correction:permission
        |
        */
        $eventKey =
            'school_attendance:'
            . $attendance->id
            . ':correction:'
            . $newStatus;

        $message = $this->buildAttendanceCorrectionMessage(
            $student,
            $attendance
        );

        $notification = WhatsAppNotification::firstOrCreate(
            [
                'event_key' => $eventKey,
            ],
            [
                'student_id' => $student->id,
                'attendance_id' => $attendance->id,
                'notification_type' => 'correction',
                'attendance_status' => $newStatus,
                'recipient_phone' => $recipientPhone,
                'message' => $message,
                'status' => 'pending',
                'attempts' => 0,
            ]
        );

        if ($notification->wasRecentlyCreated) {
            Log::info(
                'WHATSAPP CORRECTION CREATED',
                [
                    'notification_id' => $notification->id,
                    'student_id' => $student->id,
                    'attendance_id' => $attendance->id,
                    'previous_status' => $previousStatus,
                    'new_status' => $newStatus,
                    'recipient_phone' => $this->maskPhone(
                        $recipientPhone
                    ),
                ]
            );

            $this->dispatchNotificationJob(
                $notification,
                'WhatsApp Correction Job berhasil didispatch.',
                'Gagal dispatch WhatsApp Correction Job.'
            );
        } else {
            Log::info(
                'WhatsApp Correction sudah ada. Duplikat tidak dibuat.',
                [
                    'notification_id' => $notification->id,
                    'event_key' => $notification->event_key,
                    'status' => $notification->status,
                ]
            );
        }

        return $notification;
    }

    /*
    |--------------------------------------------------------------------------
    | DISPATCH JOB
    |--------------------------------------------------------------------------
    */
    private function dispatchNotificationJob(
        WhatsAppNotification $notification,
        string $successLog,
        string $failureLog
    ): void {
        try {
            SendWhatsAppNotification::dispatch(
                $notification->id
            )->afterCommit();

            Log::info(
                $successLog,
                [
                    'notification_id' => $notification->id,
                ]
            );
        } catch (Throwable $exception) {
            Log::error(
                $failureLog,
                [
                    'notification_id' => $notification->id,
                    'error' => $exception->getMessage(),
                ]
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | SEND NOTIFICATION KE FONNTE
    |--------------------------------------------------------------------------
    */
    public function sendNotification(
        WhatsAppNotification $notification
    ): void {
        $notification->refresh();

        /*
        |--------------------------------------------------------------------------
        | SUDAH SENT
        |--------------------------------------------------------------------------
        */
        if ($notification->status === 'sent') {
            Log::info(
                'WhatsApp tidak dikirim ulang karena sudah SENT.',
                [
                    'notification_id' => $notification->id,
                ]
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | SKIPPED
        |--------------------------------------------------------------------------
        */
        if ($notification->status === 'skipped') {
            Log::info(
                'WhatsApp tidak diproses karena status SKIPPED.',
                [
                    'notification_id' => $notification->id,
                ]
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | VALIDASI NOMOR
        |--------------------------------------------------------------------------
        */
        if (empty($notification->recipient_phone)) {
            $notification->markAsSkipped(
                'Nomor orang tua/wali kosong.'
            );

            Log::warning(
                'WhatsApp dilewati karena nomor tujuan kosong.',
                [
                    'notification_id' => $notification->id,
                ]
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | VALIDASI PESAN
        |--------------------------------------------------------------------------
        */
        if (empty($notification->message)) {
            $notification->markAsSkipped(
                'Isi pesan WhatsApp kosong.'
            );

            Log::warning(
                'WhatsApp dilewati karena isi pesan kosong.',
                [
                    'notification_id' => $notification->id,
                ]
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | FONNTE ENABLED
        |--------------------------------------------------------------------------
        */
        $fonnteEnabled = (bool) config(
            'services.fonnte.enabled',
            false
        );

        if (!$fonnteEnabled) {
            Log::warning(
                'Fonnte belum diaktifkan. WhatsApp tetap PENDING.',
                [
                    'notification_id' => $notification->id,
                    'recipient_phone' => $this->maskPhone(
                        $notification->recipient_phone
                    ),
                ]
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | TOKEN
        |--------------------------------------------------------------------------
        */
        $token = trim(
            (string) config(
                'services.fonnte.token',
                ''
            )
        );

        if ($token === '') {
            $errorMessage = 'FONNTE_TOKEN belum dikonfigurasi.';

            $notification->markAsFailed(
                $errorMessage
            );

            Log::error(
                'WhatsApp gagal karena token Fonnte kosong.',
                [
                    'notification_id' => $notification->id,
                ]
            );

            throw new RuntimeException(
                $errorMessage
            );
        }

        /*
        |--------------------------------------------------------------------------
        | ENDPOINT
        |--------------------------------------------------------------------------
        */
        $baseUrl = rtrim(
            (string) config(
                'services.fonnte.base_url',
                'https://api.fonnte.com'
            ),
            '/'
        );

        $endpoint = $baseUrl . '/send';

        $countryCode = (string) config(
            'services.fonnte.country_code',
            '62'
        );

        /*
        |--------------------------------------------------------------------------
        | PROCESSING
        |--------------------------------------------------------------------------
        */
        $notification->markAsProcessing();

        Log::info(
            'WHATSAPP FONNTE SEND START',
            [
                'notification_id' => $notification->id,
                'student_id' => $notification->student_id,
                'attendance_id' => $notification->attendance_id,
                'notification_type' => $notification->notification_type,
                'recipient_phone' => $this->maskPhone(
                    $notification->recipient_phone
                ),
                'attendance_status' => $notification->attendance_status,
                'attempts' => $notification->attempts,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | REQUEST KE FONNTE
        |--------------------------------------------------------------------------
        */
        try {
            $response = Http::withHeaders(
                [
                    'Authorization' => $token,
                    'Accept' => 'application/json',
                ]
            )
                ->asMultipart()
                ->connectTimeout(10)
                ->timeout(30)
                ->post(
                    $endpoint,
                    [
                        'target' =>
                            (string) $notification->recipient_phone,

                        'message' =>
                            (string) $notification->message,

                        'countryCode' =>
                            $countryCode,
                    ]
                );
        } catch (Throwable $exception) {
            $errorMessage =
                'Gagal terhubung ke Fonnte: '
                . $exception->getMessage();

            $notification->markAsFailed(
                $errorMessage
            );

            Log::error(
                'WHATSAPP FONNTE CONNECTION ERROR',
                [
                    'notification_id' => $notification->id,
                    'recipient_phone' => $this->maskPhone(
                        $notification->recipient_phone
                    ),
                    'error' => $exception->getMessage(),
                ]
            );

            throw $exception;
        }

        /*
        |--------------------------------------------------------------------------
        | HTTP ERROR
        |--------------------------------------------------------------------------
        */
        if (!$response->successful()) {
            $errorMessage =
                'Fonnte HTTP Error '
                . $response->status()
                . '.';

            $notification->markAsFailed(
                $errorMessage
            );

            Log::error(
                'WHATSAPP FONNTE HTTP ERROR',
                [
                    'notification_id' => $notification->id,
                    'http_status' => $response->status(),
                    'response' => $response->body(),
                ]
            );

            throw new RuntimeException(
                $errorMessage
            );
        }

        /*
        |--------------------------------------------------------------------------
        | RESPONSE JSON
        |--------------------------------------------------------------------------
        */
        $responseData = $response->json();

        if (!is_array($responseData)) {
            $errorMessage =
                'Response Fonnte bukan JSON yang valid.';

            $notification->markAsFailed(
                $errorMessage
            );

            Log::error(
                'WHATSAPP FONNTE INVALID RESPONSE',
                [
                    'notification_id' => $notification->id,
                    'response' => $response->body(),
                ]
            );

            throw new RuntimeException(
                $errorMessage
            );
        }

        /*
        |--------------------------------------------------------------------------
        | CEK STATUS FONNTE
        |--------------------------------------------------------------------------
        */
        if (
            !$this->isSuccessfulFonnteResponse(
                $responseData
            )
        ) {
            $reason =
                $responseData['reason']
                ?? $responseData['detail']
                ?? $responseData['message']
                ?? 'Fonnte menolak request pengiriman.';

            $errorMessage =
                'Fonnte gagal: '
                . (string) $reason;

            $notification->markAsFailed(
                $errorMessage
            );

            Log::error(
                'WHATSAPP FONNTE REJECTED',
                [
                    'notification_id' => $notification->id,
                    'recipient_phone' => $this->maskPhone(
                        $notification->recipient_phone
                    ),
                    'reason' => (string) $reason,
                    'process' => $responseData['process'] ?? null,
                    'request_id' => $responseData['requestid'] ?? null,
                ]
            );

            throw new RuntimeException(
                $errorMessage
            );
        }

        /*
        |--------------------------------------------------------------------------
        | PROVIDER MESSAGE ID
        |--------------------------------------------------------------------------
        */
        $providerMessageId =
            $this->extractProviderMessageId(
                $responseData,
                $notification
            );

        /*
        |--------------------------------------------------------------------------
        | SENT
        |--------------------------------------------------------------------------
        */
        $notification->markAsSent(
            $providerMessageId
        );

        if ($notification->error_message !== null) {
            $notification->forceFill(
                [
                    'error_message' => null,
                ]
            )->save();
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE WA_SENT
        |--------------------------------------------------------------------------
        */
        if ($notification->attendance_id) {
            Attendance::query()
                ->whereKey(
                    $notification->attendance_id
                )
                ->update(
                    [
                        'wa_sent' => true,
                    ]
                );
        }

        Log::info(
            'WHATSAPP FONNTE BERHASIL',
            [
                'notification_id' => $notification->id,
                'notification_type' => $notification->notification_type,
                'provider_message_id' => $providerMessageId,
                'recipient_phone' => $this->maskPhone(
                    $notification->recipient_phone
                ),
                'process' => $responseData['process'] ?? null,
                'request_id' => $responseData['requestid'] ?? null,
                'detail' => $responseData['detail'] ?? null,
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CEK RESPONSE FONNTE SUKSES
    |--------------------------------------------------------------------------
    */
    private function isSuccessfulFonnteResponse(
        array $responseData
    ): bool {
        $status =
            $responseData['status']
            ?? false;

        if (
            $status === true
            ||
            $status === 1
            ||
            $status === '1'
        ) {
            return true;
        }

        return
            is_string($status)
            &&
            strtolower(
                trim($status)
            ) === 'true';
    }

    /*
    |--------------------------------------------------------------------------
    | EXTRACT PROVIDER MESSAGE ID
    |--------------------------------------------------------------------------
    */
    private function extractProviderMessageId(
        array $responseData,
        WhatsAppNotification $notification
    ): string {
        $messageIds =
            $responseData['id']
            ?? null;

        if (
            is_array($messageIds)
            &&
            isset($messageIds[0])
            &&
            $messageIds[0] !== null
            &&
            $messageIds[0] !== ''
        ) {
            return
                'FONNTE-MSG-'
                . (string) $messageIds[0];
        }

        if (
            !is_array($messageIds)
            &&
            $messageIds !== null
            &&
            $messageIds !== ''
        ) {
            return
                'FONNTE-MSG-'
                . (string) $messageIds;
        }

        $requestId =
            $responseData['requestid']
            ?? null;

        if (
            $requestId !== null
            &&
            $requestId !== ''
        ) {
            return
                'FONNTE-REQ-'
                . (string) $requestId;
        }

        return
            'FONNTE-NOTIF-'
            . $notification->id
            . '-'
            . now('Asia/Jakarta')->timestamp;
    }

    /*
    |--------------------------------------------------------------------------
    | BUILD ATTENDANCE CORRECTION MESSAGE
    |--------------------------------------------------------------------------
    */
    private function buildAttendanceCorrectionMessage(
        Student $student,
        Attendance $attendance
    ): string {
        $student->loadMissing(
            'user'
        );

        $studentName =
            $student->user?->name
            ?? 'Siswa';

        $attendanceDate =
            $attendance->attendance_date
            ?? $attendance->created_at;

        if ($attendanceDate) {
            $formattedDate =
                Carbon::parse(
                    $attendanceDate
                )
                    ->locale('id')
                    ->translatedFormat(
                        'd F Y'
                    );
        } else {
            $formattedDate =
                now('Asia/Jakarta')
                    ->locale('id')
                    ->translatedFormat(
                        'd F Y'
                    );
        }

        $status =
            strtolower(
                (string) $attendance->status
            );

        $statusLabel =
            $status === 'sick'
                ? 'SAKIT'
                : 'IZIN';

        return
            "Yth. Orang Tua/Wali {$studentName},\n\n"
            . "Kami informasikan bahwa status presensi {$studentName} "
            . "yang sebelumnya tercatat ALFA telah diperbarui menjadi "
            . "{$statusLabel} setelah pengajuan disetujui.\n\n"
            . "Tanggal: {$formattedDate}\n"
            . "Status terbaru: {$statusLabel}\n\n"
            . "Mohon abaikan pemberitahuan ALFA sebelumnya.\n\n"
            . "Pesan ini dikirim otomatis oleh Sistem Presensi KKO SMANDA.";
    }

    /*
    |--------------------------------------------------------------------------
    | BUILD ATTENDANCE MESSAGE
    |--------------------------------------------------------------------------
    */
    private function buildAttendanceMessage(
        Student $student,
        Attendance $attendance
    ): string {
        $student->loadMissing(
            'user'
        );

        $studentName =
            $student->user?->name
            ?? 'Siswa';

        $attendanceDate =
            $attendance->attendance_date
            ?? $attendance->date
            ?? $attendance->created_at;

        if ($attendanceDate) {
            $formattedDate =
                Carbon::parse(
                    $attendanceDate
                )
                    ->locale('id')
                    ->translatedFormat(
                        'd F Y'
                    );
        } else {
            $formattedDate =
                now('Asia/Jakarta')
                    ->locale('id')
                    ->translatedFormat(
                        'd F Y'
                    );
        }

        $status =
            strtolower(
                (string) $attendance->status
            );

        /*
        |--------------------------------------------------------------------------
        | HADIR
        |--------------------------------------------------------------------------
        */
        if ($status === 'present') {
            $time =
                $this->formatAttendanceTime(
                    $attendance
                );

            return
                "Yth. Orang Tua/Wali {$studentName},\n\n"
                . "Kami informasikan bahwa {$studentName} telah tercatat HADIR "
                . "di SMA Negeri 2 Cilacap.\n\n"
                . "Tanggal: {$formattedDate}\n"
                . "Waktu: {$time} WIB\n\n"
                . "Pesan ini dikirim otomatis oleh Sistem Presensi KKO SMANDA.";
        }

        /*
        |--------------------------------------------------------------------------
        | TERLAMBAT
        |--------------------------------------------------------------------------
        */
        if ($status === 'late') {
            $time =
                $this->formatAttendanceTime(
                    $attendance
                );

            return
                "Yth. Orang Tua/Wali {$studentName},\n\n"
                . "Kami informasikan bahwa {$studentName} telah tercatat "
                . "TERLAMBAT hadir di SMA Negeri 2 Cilacap.\n\n"
                . "Tanggal: {$formattedDate}\n"
                . "Waktu: {$time} WIB\n\n"
                . "Pesan ini dikirim otomatis oleh Sistem Presensi KKO SMANDA.";
        }

        /*
        |--------------------------------------------------------------------------
        | ALFA
        |--------------------------------------------------------------------------
        */
        return
            "Yth. Orang Tua/Wali {$studentName},\n\n"
            . "Kami informasikan bahwa hingga batas waktu presensi, "
            . "{$studentName} belum tercatat hadir di sekolah dan tercatat ALFA.\n\n"
            . "Tanggal: {$formattedDate}\n"
            . "Batas Presensi: 07.00 WIB\n\n"
            . "Pesan ini dikirim otomatis oleh Sistem Presensi KKO SMANDA.";
    }

    /*
    |--------------------------------------------------------------------------
    | FORMAT WAKTU
    |--------------------------------------------------------------------------
    */
    private function formatAttendanceTime(
        Attendance $attendance
    ): string {
        if ($attendance->check_in_time) {
            try {
                return Carbon::parse(
                    $attendance->check_in_time
                )->format(
                    'H:i'
                );
            } catch (Throwable $exception) {
                return substr(
                    (string) $attendance->check_in_time,
                    0,
                    5
                );
            }
        }

        return now(
            'Asia/Jakarta'
        )->format(
            'H:i'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | NORMALIZE PHONE
    |--------------------------------------------------------------------------
    */
    private function normalizePhone(
        ?string $phone
    ): ?string {
        if (!$phone) {
            return null;
        }

        $phone =
            preg_replace(
                '/[^0-9]/',
                '',
                $phone
            );

        if (!$phone) {
            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | 08... -> 628...
        |--------------------------------------------------------------------------
        */
        if (
            str_starts_with(
                $phone,
                '0'
            )
        ) {
            $phone =
                '62'
                . substr(
                    $phone,
                    1
                );
        }

        /*
        |--------------------------------------------------------------------------
        | 8... -> 628...
        |--------------------------------------------------------------------------
        */
        elseif (
            str_starts_with(
                $phone,
                '8'
            )
        ) {
            $phone =
                '62'
                . $phone;
        }

        /*
        |--------------------------------------------------------------------------
        | PREFIX HARUS 62
        |--------------------------------------------------------------------------
        */
        if (
            !str_starts_with(
                $phone,
                '62'
            )
        ) {
            Log::warning(
                'Format nomor WhatsApp tidak dikenali.',
                [
                    'phone' =>
                        $this->maskPhone(
                            $phone
                        ),
                ]
            );

            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | PANJANG NOMOR
        |--------------------------------------------------------------------------
        */
        if (
            strlen($phone) < 10
            ||
            strlen($phone) > 16
        ) {
            Log::warning(
                'Panjang nomor WhatsApp tidak valid.',
                [
                    'phone' =>
                        $this->maskPhone(
                            $phone
                        ),
                ]
            );

            return null;
        }

        return $phone;
    }

    /*
    |--------------------------------------------------------------------------
    | MASK PHONE UNTUK LOG
    |--------------------------------------------------------------------------
    */
    private function maskPhone(
        ?string $phone
    ): ?string {
        if (!$phone) {
            return null;
        }

        $length =
            strlen(
                $phone
            );

        if ($length <= 7) {
            return
                substr(
                    $phone,
                    0,
                    2
                )
                . '***';
        }

        return
            substr(
                $phone,
                0,
                5
            )
            . str_repeat(
                '*',
                max(
                    3,
                    $length - 8
                )
            )
            . substr(
                $phone,
                -3
            );
    }
}