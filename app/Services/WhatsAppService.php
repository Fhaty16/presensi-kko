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
    | Student
    |    ↓
    | Attendance
    |    ↓
    | whatsapp_notifications
    |    ↓
    | pending
    |    ↓
    | SendWhatsAppNotification Job
    |    ↓
    | WhatsAppService
    |    ↓
    | Fonnte API
    |
    */

    public function createAttendanceNotification(
        Student $student,
        Attendance $attendance
    ): ?WhatsAppNotification {
        /*
        |--------------------------------------------------------------------------
        | NORMALISASI NOMOR ORANG TUA
        |--------------------------------------------------------------------------
        */

        $parentPhone = $this->normalizePhone(
            $student->parent_phone
        );

        /*
        |--------------------------------------------------------------------------
        | NOMOR ORANG TUA KOSONG
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | STATUS PRESENSI
        |--------------------------------------------------------------------------
        */

        $attendanceStatus = strtolower(
            (string) $attendance->status
        );

        /*
        |--------------------------------------------------------------------------
        | STATUS YANG MENDAPAT WHATSAPP
        |--------------------------------------------------------------------------
        |
        | present = Hadir
        | late    = Terlambat
        | absent  = Alfa
        |
        */

        if (
            !in_array(
                $attendanceStatus,
                [
                    'present',
                    'late',
                    'absent',
                ],
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

        /*
        |--------------------------------------------------------------------------
        | EVENT KEY
        |--------------------------------------------------------------------------
        |
        | Contoh:
        |
        | school_attendance:154:absent
        |
        | UNIQUE event_key mencegah notifikasi yang sama dibuat dua kali.
        |
        */

        $eventKey =
            'school_attendance:'
            . $attendance->id
            . ':'
            . $attendanceStatus;

        /*
        |--------------------------------------------------------------------------
        | JENIS NOTIFIKASI
        |--------------------------------------------------------------------------
        */

        $notificationType =
            $attendanceStatus === 'absent'
                ? 'absent'
                : 'check_in';

        /*
        |--------------------------------------------------------------------------
        | SUSUN PESAN
        |--------------------------------------------------------------------------
        */

        $message = $this->buildAttendanceMessage(
            $student,
            $attendance
        );

        /*
        |--------------------------------------------------------------------------
        | FIRST OR CREATE
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | NOTIFICATION BARU
        |--------------------------------------------------------------------------
        */

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
                    'attendance_status' =>
                        $notification->attendance_status,
                ]
            );

            /*
            |--------------------------------------------------------------------------
            | DISPATCH JOB OTOMATIS
            |--------------------------------------------------------------------------
            */

            try {
                SendWhatsAppNotification::dispatch(
                    $notification->id
                )->afterCommit();

                Log::info(
                    'WhatsApp Job berhasil didispatch.',
                    [
                        'notification_id' =>
                            $notification->id,
                    ]
                );
            } catch (Throwable $exception) {
                /*
                |--------------------------------------------------------------------------
                | JANGAN HAPUS NOTIFICATION
                |--------------------------------------------------------------------------
                |
                | Notification tetap pending jika dispatch gagal.
                |
                */

                Log::error(
                    'Gagal dispatch WhatsApp Job.',
                    [
                        'notification_id' =>
                            $notification->id,

                        'error' =>
                            $exception->getMessage(),
                    ]
                );
            }
        } else {
            /*
            |--------------------------------------------------------------------------
            | DUPLIKAT
            |--------------------------------------------------------------------------
            */

            Log::info(
                'WhatsApp Notification sudah ada. Duplikat tidak dibuat.',
                [
                    'notification_id' =>
                        $notification->id,

                    'event_key' =>
                        $notification->event_key,

                    'status' =>
                        $notification->status,
                ]
            );
        }

        return $notification;
    }

    /*
    |--------------------------------------------------------------------------
    | SEND NOTIFICATION
    |--------------------------------------------------------------------------
    |
    | Dipanggil oleh:
    |
    | SendWhatsAppNotification Job
    |
    | Provider:
    |
    | Fonnte API
    |
    */

    public function sendNotification(
        WhatsAppNotification $notification
    ): void {
        /*
        |--------------------------------------------------------------------------
        | REFRESH DATA
        |--------------------------------------------------------------------------
        */

        $notification->refresh();

        /*
        |--------------------------------------------------------------------------
        | SUDAH TERKIRIM
        |--------------------------------------------------------------------------
        */

        if ($notification->status === 'sent') {
            Log::info(
                'WhatsApp tidak dikirim ulang karena sudah SENT.',
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

        if ($notification->status === 'skipped') {
            Log::info(
                'WhatsApp tidak diproses karena status SKIPPED.',
                [
                    'notification_id' =>
                        $notification->id,
                ]
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | VALIDASI NOMOR TUJUAN
        |--------------------------------------------------------------------------
        */

        if (empty($notification->recipient_phone)) {
            $notification->markAsSkipped(
                'Nomor orang tua/wali kosong.'
            );

            Log::warning(
                'WhatsApp dilewati karena nomor tujuan kosong.',
                [
                    'notification_id' =>
                        $notification->id,
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
                    'notification_id' =>
                        $notification->id,
                ]
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | CEK FONNTE ENABLED
        |--------------------------------------------------------------------------
        |
        | Jika false, notification TETAP pending.
        |
        | Ini penting supaya kita tidak mengirim WhatsApp sungguhan
        | sebelum sistem sengaja diaktifkan.
        |
        */

        $fonnteEnabled = (bool) config(
            'services.fonnte.enabled',
            false
        );

        if (!$fonnteEnabled) {
            Log::warning(
                'Fonnte belum diaktifkan. WhatsApp tetap PENDING.',
                [
                    'notification_id' =>
                        $notification->id,

                    'recipient_phone' =>
                        $this->maskPhone(
                            $notification->recipient_phone
                        ),
                ]
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | AMBIL TOKEN
        |--------------------------------------------------------------------------
        */

        $token = trim(
            (string) config(
                'services.fonnte.token',
                ''
            )
        );

        if ($token === '') {
            $errorMessage =
                'FONNTE_TOKEN belum dikonfigurasi.';

            $notification->markAsFailed(
                $errorMessage
            );

            Log::error(
                'WhatsApp gagal karena token Fonnte kosong.',
                [
                    'notification_id' =>
                        $notification->id,
                ]
            );

            throw new RuntimeException(
                $errorMessage
            );
        }

        /*
        |--------------------------------------------------------------------------
        | BASE URL
        |--------------------------------------------------------------------------
        */

        $baseUrl = rtrim(
            (string) config(
                'services.fonnte.base_url',
                'https://api.fonnte.com'
            ),
            '/'
        );

        $endpoint =
            $baseUrl
            . '/send';

        /*
        |--------------------------------------------------------------------------
        | COUNTRY CODE
        |--------------------------------------------------------------------------
        */

        $countryCode = (string) config(
            'services.fonnte.country_code',
            '62'
        );

        /*
        |--------------------------------------------------------------------------
        | STATUS PROCESSING
        |--------------------------------------------------------------------------
        |
        | attempts bertambah melalui markAsProcessing().
        |
        */

        $notification->markAsProcessing();

        /*
        |--------------------------------------------------------------------------
        | LOG SEBELUM KIRIM
        |--------------------------------------------------------------------------
        |
        | TOKEN TIDAK PERNAH DITULIS KE LOG.
        |
        */

        Log::info(
            'WHATSAPP FONNTE SEND START',
            [
                'notification_id' =>
                    $notification->id,

                'student_id' =>
                    $notification->student_id,

                'attendance_id' =>
                    $notification->attendance_id,

                'recipient_phone' =>
                    $this->maskPhone(
                        $notification->recipient_phone
                    ),

                'attendance_status' =>
                    $notification->attendance_status,

                'attempts' =>
                    $notification->attempts,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | REQUEST KE FONNTE
        |--------------------------------------------------------------------------
        |
        | POST:
        | https://api.fonnte.com/send
        |
        | Header:
        | Authorization: TOKEN
        |
        | Multipart:
        | target
        | message
        | countryCode
        |
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
                    'notification_id' =>
                        $notification->id,

                    'recipient_phone' =>
                        $this->maskPhone(
                            $notification->recipient_phone
                        ),

                    'error' =>
                        $exception->getMessage(),
                ]
            );

            /*
            |--------------------------------------------------------------------------
            | THROW ULANG
            |--------------------------------------------------------------------------
            |
            | Agar Laravel Queue menjalankan retry sesuai konfigurasi Job.
            |
            */

            throw $exception;
        }

        /*
        |--------------------------------------------------------------------------
        | VALIDASI HTTP RESPONSE
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
                    'notification_id' =>
                        $notification->id,

                    'http_status' =>
                        $response->status(),

                    'response' =>
                        $response->body(),
                ]
            );

            throw new RuntimeException(
                $errorMessage
            );
        }

        /*
        |--------------------------------------------------------------------------
        | JSON RESPONSE
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
                    'notification_id' =>
                        $notification->id,

                    'response' =>
                        $response->body(),
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
        |
        | HTTP 200 belum tentu sukses.
        |
        | Contoh gagal:
        |
        | {
        |   "status": false,
        |   "reason": "invalid token"
        | }
        |
        */

        $isSuccess = $this->isSuccessfulFonnteResponse(
            $responseData
        );

        if (!$isSuccess) {
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
                    'notification_id' =>
                        $notification->id,

                    'recipient_phone' =>
                        $this->maskPhone(
                            $notification->recipient_phone
                        ),

                    'reason' =>
                        (string) $reason,

                    'process' =>
                        $responseData['process']
                        ?? null,

                    'request_id' =>
                        $responseData['requestid']
                        ?? null,
                ]
            );

            throw new RuntimeException(
                $errorMessage
            );
        }

        /*
        |--------------------------------------------------------------------------
        | AMBIL PROVIDER MESSAGE ID
        |--------------------------------------------------------------------------
        |
        | Contoh response Fonnte:
        |
        | "id": [
        |     175967136
        | ]
        |
        | Jika id tidak tersedia, gunakan requestid.
        |
        */

        $providerMessageId =
            $this->extractProviderMessageId(
                $responseData,
                $notification
            );

        /*
        |--------------------------------------------------------------------------
        | MARK AS SENT
        |--------------------------------------------------------------------------
        |
        | Di sini "sent" berarti request sudah DITERIMA oleh Fonnte.
        |
        | Fonnte dapat mengembalikan:
        |
        | process = pending
        |
        | yang berarti pesan sudah masuk antrean provider.
        |
        */

        $notification->markAsSent(
            $providerMessageId
        );

        /*
        |--------------------------------------------------------------------------
        | BERSIHKAN ERROR LAMA
        |--------------------------------------------------------------------------
        |
        | Berguna jika request sebelumnya pernah gagal kemudian berhasil
        | pada retry berikutnya.
        |
        */

        if ($notification->error_message !== null) {
            $notification->forceFill(
                [
                    'error_message' => null,
                ]
            )->save();
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE ATTENDANCE.WA_SENT
        |--------------------------------------------------------------------------
        |
        | Hanya TRUE setelah Fonnte menerima request dengan status sukses.
        |
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

        /*
        |--------------------------------------------------------------------------
        | LOG SUKSES
        |--------------------------------------------------------------------------
        */

        Log::info(
            'WHATSAPP FONNTE BERHASIL',
            [
                'notification_id' =>
                    $notification->id,

                'provider_message_id' =>
                    $providerMessageId,

                'recipient_phone' =>
                    $this->maskPhone(
                        $notification->recipient_phone
                    ),

                'process' =>
                    $responseData['process']
                    ?? null,

                'request_id' =>
                    $responseData['requestid']
                    ?? null,

                'detail' =>
                    $responseData['detail']
                    ?? null,
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

        if ($status === true) {
            return true;
        }

        if ($status === 1) {
            return true;
        }

        if ($status === '1') {
            return true;
        }

        if (
            is_string($status)
            &&
            strtolower(trim($status))
            === 'true'
        ) {
            return true;
        }

        return false;
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
        /*
        |--------------------------------------------------------------------------
        | FONNTE MESSAGE ID
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | ID LANGSUNG
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | REQUEST ID
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | FALLBACK ID
        |--------------------------------------------------------------------------
        */

        return
            'FONNTE-NOTIF-'
            . $notification->id
            . '-'
            . now('Asia/Jakarta')->timestamp;
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
        /*
        |--------------------------------------------------------------------------
        | LOAD USER
        |--------------------------------------------------------------------------
        */

        $student->loadMissing(
            'user'
        );

        /*
        |--------------------------------------------------------------------------
        | NAMA SISWA
        |--------------------------------------------------------------------------
        */

        $studentName =
            $student->user?->name
            ?? 'Siswa';

        /*
        |--------------------------------------------------------------------------
        | TANGGAL PRESENSI
        |--------------------------------------------------------------------------
        */

        $attendanceDate =
            $attendance->attendance_date
            ?? $attendance->date
            ?? $attendance->created_at;

        /*
        |--------------------------------------------------------------------------
        | FORMAT TANGGAL
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | STATUS
        |--------------------------------------------------------------------------
        */

        $status = strtolower(
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
        /*
        |--------------------------------------------------------------------------
        | KOSONG
        |--------------------------------------------------------------------------
        */

        if (!$phone) {
            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | HAPUS SELAIN ANGKA
        |--------------------------------------------------------------------------
        */

        $phone = preg_replace(
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
        | WAJIB PREFIX 62
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
        | VALIDASI PANJANG
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
    |
    | Nomor asli tetap dipakai untuk pengiriman.
    |
    | Tetapi storage/logs/laravel.log tidak perlu menyimpan
    | seluruh nomor orang tua/wali.
    |
    | Contoh:
    |
    | 628123456789
    |
    | menjadi:
    |
    | 62812*****789
    |
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