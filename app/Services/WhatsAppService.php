<?php

namespace App\Services;

use App\Jobs\SendWhatsAppNotification;
use App\Models\Attendance;
use App\Models\AttendanceSetting;
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
    | TIMEZONE
    |--------------------------------------------------------------------------
    */

    private const TIMEZONE =
        'Asia/Jakarta';


    /*
    |--------------------------------------------------------------------------
    | BUAT NOTIFIKASI PRESENSI
    |--------------------------------------------------------------------------
    */

    public function createAttendanceNotification(
        Student $student,
        Attendance $attendance
    ): ?WhatsAppNotification {

        /*
        |--------------------------------------------------------------------------
        | NOMOR ORANG TUA
        |--------------------------------------------------------------------------
        */

        $parentPhone =
            $this->normalizePhone(
                $student->parent_phone
            );


        if (
            !$parentPhone
        ) {

            Log::warning(
                'WhatsApp tidak dibuat karena parent_phone kosong.',
                [
                    'student_id' =>
                        $student->id,

                    'nis' =>
                        $student->nis,

                    'attendance_id' =>
                        $attendance->id,
                ]
            );


            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | STATUS PRESENSI
        |--------------------------------------------------------------------------
        */

        $attendanceStatus =
            strtolower(
                (string) $attendance->status
            );


        /*
        |--------------------------------------------------------------------------
        | STATUS YANG MENDAPAT WHATSAPP
        |--------------------------------------------------------------------------
        |
        | present = Hadir
        | late    = Data lama Terlambat
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
                    'student_id' =>
                        $student->id,

                    'attendance_id' =>
                        $attendance->id,

                    'status' =>
                        $attendanceStatus,
                ]
            );


            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | EVENT KEY
        |--------------------------------------------------------------------------
        */

        $eventKey =
            'school_attendance:'
            .
            $attendance->id
            .
            ':'
            .
            $attendanceStatus;


        /*
        |--------------------------------------------------------------------------
        | TYPE
        |--------------------------------------------------------------------------
        */

        $notificationType =
            $attendanceStatus === 'absent'
                ? 'absent'
                : 'check_in';


        /*
        |--------------------------------------------------------------------------
        | PESAN
        |--------------------------------------------------------------------------
        */

        $message =
            $this->buildAttendanceMessage(
                $student,
                $attendance
            );


        /*
        |--------------------------------------------------------------------------
        | FIRST OR CREATE
        |--------------------------------------------------------------------------
        |
        | event_key mencegah notifikasi ganda.
        |
        */

        $notification =
            WhatsAppNotification::firstOrCreate(
                [
                    'event_key' =>
                        $eventKey,
                ],
                [
                    'student_id' =>
                        $student->id,

                    'attendance_id' =>
                        $attendance->id,

                    'notification_type' =>
                        $notificationType,

                    'attendance_status' =>
                        $attendanceStatus,

                    'recipient_phone' =>
                        $parentPhone,

                    'message' =>
                        $message,

                    'status' =>
                        'pending',

                    'attempts' =>
                        0,
                ]
            );


        /*
        |--------------------------------------------------------------------------
        | NOTIFIKASI BARU
        |--------------------------------------------------------------------------
        */

        if (
            $notification
                ->wasRecentlyCreated
        ) {

            Log::info(
                'WHATSAPP NOTIFICATION CREATED',
                [
                    'notification_id' =>
                        $notification->id,

                    'student_id' =>
                        $student->id,

                    'nis' =>
                        $student->nis,

                    'attendance_id' =>
                        $attendance->id,

                    'recipient_phone' =>
                        $this->maskPhone(
                            $notification
                                ->recipient_phone
                        ),

                    'attendance_status' =>
                        $notification
                            ->attendance_status,
                ]
            );


            /*
            |--------------------------------------------------------------------------
            | DISPATCH JOB
            |--------------------------------------------------------------------------
            */

            try {

                SendWhatsAppNotification::dispatch(
                    $notification->id
                )
                    ->afterCommit();


                Log::info(
                    'WhatsApp Job berhasil didispatch.',
                    [
                        'notification_id' =>
                            $notification->id,
                    ]
                );

            } catch (
                Throwable $exception
            ) {

                Log::error(
                    'Gagal dispatch WhatsApp Job.',
                    [
                        'notification_id' =>
                            $notification->id,

                        'error' =>
                            $exception
                                ->getMessage(),
                    ]
                );
            }

        } else {

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
    | KIRIM NOTIFIKASI
    |--------------------------------------------------------------------------
    */

    public function sendNotification(
        WhatsAppNotification $notification
    ): void {

        /*
        |--------------------------------------------------------------------------
        | REFRESH
        |--------------------------------------------------------------------------
        */

        $notification->refresh();


        /*
        |--------------------------------------------------------------------------
        | SUDAH SENT
        |--------------------------------------------------------------------------
        */

        if (
            $notification->status
            ===
            'sent'
        ) {

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

        if (
            $notification->status
            ===
            'skipped'
        ) {

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
        | VALIDASI NOMOR
        |--------------------------------------------------------------------------
        */

        if (
            empty(
                $notification
                    ->recipient_phone
            )
        ) {

            $notification
                ->markAsSkipped(
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

        if (
            empty(
                $notification
                    ->message
            )
        ) {

            $notification
                ->markAsSkipped(
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
        | FONNTE ENABLED
        |--------------------------------------------------------------------------
        */

        $fonnteEnabled =
            (bool) config(
                'services.fonnte.enabled',
                false
            );


        if (
            !$fonnteEnabled
        ) {

            Log::warning(
                'Fonnte belum diaktifkan. WhatsApp tetap PENDING.',
                [
                    'notification_id' =>
                        $notification->id,

                    'recipient_phone' =>
                        $this->maskPhone(
                            $notification
                                ->recipient_phone
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

        $token =
            trim(
                (string) config(
                    'services.fonnte.token',
                    ''
                )
            );


        if (
            $token === ''
        ) {

            $errorMessage =
                'FONNTE_TOKEN belum dikonfigurasi.';


            $notification
                ->markAsFailed(
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

        $baseUrl =
            rtrim(
                (string) config(
                    'services.fonnte.base_url',
                    'https://api.fonnte.com'
                ),
                '/'
            );


        $endpoint =
            $baseUrl
            .
            '/send';


        /*
        |--------------------------------------------------------------------------
        | COUNTRY CODE
        |--------------------------------------------------------------------------
        */

        $countryCode =
            (string) config(
                'services.fonnte.country_code',
                '62'
            );


        /*
        |--------------------------------------------------------------------------
        | PROCESSING
        |--------------------------------------------------------------------------
        */

        $notification
            ->markAsProcessing();


        /*
        |--------------------------------------------------------------------------
        | LOG
        |--------------------------------------------------------------------------
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
                        $notification
                            ->recipient_phone
                    ),

                'attendance_status' =>
                    $notification
                        ->attendance_status,

                'attempts' =>
                    $notification
                        ->attempts,
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | REQUEST FONNTE
        |--------------------------------------------------------------------------
        */

        try {

            $response =
                Http::withHeaders([
                    'Authorization' =>
                        $token,

                    'Accept' =>
                        'application/json',
                ])
                    ->asMultipart()
                    ->connectTimeout(
                        10
                    )
                    ->timeout(
                        30
                    )
                    ->post(
                        $endpoint,
                        [
                            'target' =>
                                (string) $notification
                                    ->recipient_phone,

                            'message' =>
                                (string) $notification
                                    ->message,

                            'countryCode' =>
                                $countryCode,
                        ]
                    );

        } catch (
            Throwable $exception
        ) {

            $errorMessage =
                'Gagal terhubung ke Fonnte: '
                .
                $exception
                    ->getMessage();


            $notification
                ->markAsFailed(
                    $errorMessage
                );


            Log::error(
                'WHATSAPP FONNTE CONNECTION ERROR',
                [
                    'notification_id' =>
                        $notification->id,

                    'recipient_phone' =>
                        $this->maskPhone(
                            $notification
                                ->recipient_phone
                        ),

                    'error' =>
                        $exception
                            ->getMessage(),
                ]
            );


            throw $exception;
        }


        /*
        |--------------------------------------------------------------------------
        | HTTP ERROR
        |--------------------------------------------------------------------------
        */

        if (
            !$response
                ->successful()
        ) {

            $errorMessage =
                'Fonnte HTTP Error '
                .
                $response
                    ->status()
                .
                '.';


            $notification
                ->markAsFailed(
                    $errorMessage
                );


            Log::error(
                'WHATSAPP FONNTE HTTP ERROR',
                [
                    'notification_id' =>
                        $notification->id,

                    'http_status' =>
                        $response
                            ->status(),

                    'response' =>
                        $response
                            ->body(),
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

        $responseData =
            $response
                ->json();


        if (
            !is_array(
                $responseData
            )
        ) {

            $errorMessage =
                'Response Fonnte bukan JSON yang valid.';


            $notification
                ->markAsFailed(
                    $errorMessage
                );


            Log::error(
                'WHATSAPP FONNTE INVALID RESPONSE',
                [
                    'notification_id' =>
                        $notification->id,

                    'response' =>
                        $response
                            ->body(),
                ]
            );


            throw new RuntimeException(
                $errorMessage
            );
        }


        /*
        |--------------------------------------------------------------------------
        | STATUS FONNTE
        |--------------------------------------------------------------------------
        */

        $isSuccess =
            $this
                ->isSuccessfulFonnteResponse(
                    $responseData
                );


        if (
            !$isSuccess
        ) {

            $reason =
                $responseData[
                    'reason'
                ]
                ??
                $responseData[
                    'detail'
                ]
                ??
                $responseData[
                    'message'
                ]
                ??
                'Fonnte menolak request pengiriman.';


            $errorMessage =
                'Fonnte gagal: '
                .
                (string) $reason;


            $notification
                ->markAsFailed(
                    $errorMessage
                );


            Log::error(
                'WHATSAPP FONNTE REJECTED',
                [
                    'notification_id' =>
                        $notification->id,

                    'recipient_phone' =>
                        $this->maskPhone(
                            $notification
                                ->recipient_phone
                        ),

                    'reason' =>
                        (string) $reason,

                    'process' =>
                        $responseData[
                            'process'
                        ]
                        ??
                        null,

                    'request_id' =>
                        $responseData[
                            'requestid'
                        ]
                        ??
                        null,
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
            $this
                ->extractProviderMessageId(
                    $responseData,
                    $notification
                );


        /*
        |--------------------------------------------------------------------------
        | SENT
        |--------------------------------------------------------------------------
        */

        $notification
            ->markAsSent(
                $providerMessageId
            );


        /*
        |--------------------------------------------------------------------------
        | BERSIHKAN ERROR
        |--------------------------------------------------------------------------
        */

        if (
            $notification
                ->error_message
            !==
            null
        ) {

            $notification
                ->forceFill([
                    'error_message' =>
                        null,
                ])
                ->save();
        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE ATTENDANCE
        |--------------------------------------------------------------------------
        */

        if (
            $notification
                ->attendance_id
        ) {

            Attendance::query()
                ->whereKey(
                    $notification
                        ->attendance_id
                )
                ->update([
                    'wa_sent' =>
                        true,
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | LOG BERHASIL
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
                        $notification
                            ->recipient_phone
                    ),

                'process' =>
                    $responseData[
                        'process'
                    ]
                    ??
                    null,

                'request_id' =>
                    $responseData[
                        'requestid'
                    ]
                    ??
                    null,

                'detail' =>
                    $responseData[
                        'detail'
                    ]
                    ??
                    null,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | RESPONSE FONNTE BERHASIL
    |--------------------------------------------------------------------------
    */

    private function isSuccessfulFonnteResponse(
        array $responseData
    ): bool {

        $status =
            $responseData[
                'status'
            ]
            ??
            false;


        if (
            $status === true
            ||
            $status === 1
            ||
            $status === '1'
        ) {

            return true;
        }


        if (
            is_string(
                $status
            )
            &&
            strtolower(
                trim(
                    $status
                )
            )
            ===
            'true'
        ) {

            return true;
        }


        return false;
    }


    /*
    |--------------------------------------------------------------------------
    | PROVIDER MESSAGE ID
    |--------------------------------------------------------------------------
    */

    private function extractProviderMessageId(
        array $responseData,
        WhatsAppNotification $notification
    ): string {

        /*
        |--------------------------------------------------------------------------
        | FONNTE MESSAGE ID ARRAY
        |--------------------------------------------------------------------------
        */

        $messageIds =
            $responseData[
                'id'
            ]
            ??
            null;


        if (
            is_array(
                $messageIds
            )
            &&
            isset(
                $messageIds[0]
            )
            &&
            $messageIds[0] !== null
            &&
            $messageIds[0] !== ''
        ) {

            return
                'FONNTE-MSG-'
                .
                (string) $messageIds[0];
        }


        /*
        |--------------------------------------------------------------------------
        | MESSAGE ID LANGSUNG
        |--------------------------------------------------------------------------
        */

        if (
            !is_array(
                $messageIds
            )
            &&
            $messageIds !== null
            &&
            $messageIds !== ''
        ) {

            return
                'FONNTE-MSG-'
                .
                (string) $messageIds;
        }


        /*
        |--------------------------------------------------------------------------
        | REQUEST ID
        |--------------------------------------------------------------------------
        */

        $requestId =
            $responseData[
                'requestid'
            ]
            ??
            null;


        if (
            $requestId !== null
            &&
            $requestId !== ''
        ) {

            return
                'FONNTE-REQ-'
                .
                (string) $requestId;
        }


        /*
        |--------------------------------------------------------------------------
        | FALLBACK
        |--------------------------------------------------------------------------
        */

        return
            'FONNTE-NOTIF-'
            .
            $notification->id
            .
            '-'
            .
            now(
                self::TIMEZONE
            )
                ->timestamp;
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
        | USER
        |--------------------------------------------------------------------------
        */

        $student
            ->loadMissing(
                'user'
            );


        /*
        |--------------------------------------------------------------------------
        | NAMA
        |--------------------------------------------------------------------------
        */

        $studentName =
            $student
                ->user?->name
            ??
            'Siswa';


        /*
        |--------------------------------------------------------------------------
        | TANGGAL
        |--------------------------------------------------------------------------
        */

        $attendanceDate =
            $attendance
                ->attendance_date
            ??
            $attendance
                ->date
            ??
            $attendance
                ->created_at;


        if (
            $attendanceDate
        ) {

            $formattedDate =
                Carbon::parse(
                    $attendanceDate
                )
                    ->locale(
                        'id'
                    )
                    ->translatedFormat(
                        'd F Y'
                    );

        } else {

            $formattedDate =
                now(
                    self::TIMEZONE
                )
                    ->locale(
                        'id'
                    )
                    ->translatedFormat(
                        'd F Y'
                    );
        }


        /*
        |--------------------------------------------------------------------------
        | STATUS
        |--------------------------------------------------------------------------
        */

        $status =
            strtolower(
                (string) $attendance
                    ->status
            );


        /*
        |--------------------------------------------------------------------------
        | HADIR
        |--------------------------------------------------------------------------
        */

        if (
            $status === 'present'
        ) {

            $time =
                $this
                    ->formatAttendanceTime(
                        $attendance
                    );


            return
                "Yth. Orang Tua/Wali {$studentName},\n\n"
                .
                "Kami informasikan bahwa {$studentName} telah tercatat HADIR "
                .
                "di SMA Negeri 2 Cilacap.\n\n"
                .
                "Tanggal: {$formattedDate}\n"
                .
                "Waktu: {$time} WIB\n\n"
                .
                "Pesan ini dikirim otomatis oleh Sistem Presensi KKO SMANDA.";
        }


        /*
        |--------------------------------------------------------------------------
        | DATA TERLAMBAT LAMA
        |--------------------------------------------------------------------------
        |
        | Scanner sekolah baru tidak lagi membuat status late.
        |
        | Ini dipertahankan hanya agar data lama tetap kompatibel.
        |
        */

        if (
            $status === 'late'
        ) {

            $time =
                $this
                    ->formatAttendanceTime(
                        $attendance
                    );


            return
                "Yth. Orang Tua/Wali {$studentName},\n\n"
                .
                "Kami informasikan bahwa {$studentName} telah tercatat "
                .
                "TERLAMBAT hadir di SMA Negeri 2 Cilacap.\n\n"
                .
                "Tanggal: {$formattedDate}\n"
                .
                "Waktu: {$time} WIB\n\n"
                .
                "Pesan ini dikirim otomatis oleh Sistem Presensi KKO SMANDA.";
        }


        /*
        |--------------------------------------------------------------------------
        | ALFA - WAKTU DINAMIS
        |--------------------------------------------------------------------------
        */

        $schoolTimes =
            $this
                ->getSchoolAttendanceTimes();


        return
            "Yth. Orang Tua/Wali {$studentName},\n\n"
            .
            "Kami informasikan bahwa hingga batas waktu presensi, "
            .
            "{$studentName} belum tercatat hadir di sekolah dan tercatat ALFA.\n\n"
            .
            "Tanggal: {$formattedDate}\n"
            .
            "Jam Presensi: {$schoolTimes['start']} - {$schoolTimes['end']} WIB\n"
            .
            "Toleransi Hadir: {$schoolTimes['tolerance']} menit\n"
            .
            "Batas Toleransi: {$schoolTimes['tolerance_end']} WIB\n"
            .
            "Mulai Alfa: {$schoolTimes['alpha_start']} WIB\n\n"
            .
            "Pesan ini dikirim otomatis oleh Sistem Presensi KKO SMANDA.";
    }


    /*
    |--------------------------------------------------------------------------
    | WAKTU PRESENSI SEKOLAH DINAMIS
    |--------------------------------------------------------------------------
    |
    | Contoh:
    |
    | Jam Mulai   : 06:00
    | Jam Selesai : 07:00
    | Toleransi   : 10
    |
    | Hasil:
    |
    | 06:00 - 07:00 = presensi
    | 07:01 - 07:10 = toleransi
    | 07:11         = mulai Alfa
    |
    */

    private function getSchoolAttendanceTimes(): array
    {
        /*
        |--------------------------------------------------------------------------
        | SETTING
        |--------------------------------------------------------------------------
        */

        $settings =
            AttendanceSetting::first();


        /*
        |--------------------------------------------------------------------------
        | FALLBACK
        |--------------------------------------------------------------------------
        */

        $startRaw =
            $settings
                ? (
                    $settings
                        ->attendance_start_time
                    ??
                    '06:00:00'
                )
                : '06:00:00';


        $endRaw =
            $settings
                ? (
                    $settings
                        ->attendance_end_time
                    ??
                    '07:00:00'
                )
                : '07:00:00';


        $tolerance =
            $settings
                ? max(
                    0,
                    (int) (
                        $settings
                            ->late_after_minutes
                        ??
                        0
                    )
                )
                : 0;


        /*
        |--------------------------------------------------------------------------
        | TANGGAL ACUAN
        |--------------------------------------------------------------------------
        */

        $today =
            Carbon::now(
                self::TIMEZONE
            )
                ->toDateString();


        /*
        |--------------------------------------------------------------------------
        | DATETIME
        |--------------------------------------------------------------------------
        */

        $start =
            Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $today
                .
                ' '
                .
                $this->normalizeTime(
                    $startRaw
                ),
                self::TIMEZONE
            );


        $end =
            Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $today
                .
                ' '
                .
                $this->normalizeTime(
                    $endRaw
                ),
                self::TIMEZONE
            );


        /*
        |--------------------------------------------------------------------------
        | FALLBACK JAM TIDAK VALID
        |--------------------------------------------------------------------------
        */

        if (
            $end
                ->lessThanOrEqualTo(
                    $start
                )
        ) {

            $end =
                $start
                    ->copy()
                    ->addHour();
        }


        /*
        |--------------------------------------------------------------------------
        | BATAS TOLERANSI
        |--------------------------------------------------------------------------
        */

        $toleranceEnd =
            $end
                ->copy()
                ->addMinutes(
                    $tolerance
                )
                ->endOfMinute();


        /*
        |--------------------------------------------------------------------------
        | MULAI ALFA
        |--------------------------------------------------------------------------
        */

        $alphaStart =
            $toleranceEnd
                ->copy()
                ->addSecond();


        /*
        |--------------------------------------------------------------------------
        | RETURN
        |--------------------------------------------------------------------------
        */

        return [
            'start' =>
                $start
                    ->format(
                        'H:i'
                    ),

            'end' =>
                $end
                    ->format(
                        'H:i'
                    ),

            'tolerance' =>
                $tolerance,

            'tolerance_end' =>
                $toleranceEnd
                    ->format(
                        'H:i'
                    ),

            'alpha_start' =>
                $alphaStart
                    ->format(
                        'H:i'
                    ),
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | NORMALISASI FORMAT TIME
    |--------------------------------------------------------------------------
    */

    private function normalizeTime(
        mixed $time
    ): string {

        $time =
            (string) $time;


        if (
            strlen(
                $time
            )
            ===
            5
        ) {

            return
                $time
                .
                ':00';
        }


        return substr(
            $time,
            0,
            8
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FORMAT WAKTU CHECK-IN
    |--------------------------------------------------------------------------
    */

    private function formatAttendanceTime(
        Attendance $attendance
    ): string {

        if (
            $attendance
                ->check_in_time
        ) {

            try {

                return Carbon::parse(
                    $attendance
                        ->check_in_time
                )
                    ->format(
                        'H:i'
                    );

            } catch (
                Throwable $exception
            ) {

                return substr(
                    (string) $attendance
                        ->check_in_time,
                    0,
                    5
                );
            }
        }


        return now(
            self::TIMEZONE
        )
            ->format(
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

        if (
            !$phone
        ) {

            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | HANYA ANGKA
        |--------------------------------------------------------------------------
        */

        $phone =
            preg_replace(
                '/[^0-9]/',
                '',
                $phone
            );


        if (
            !$phone
        ) {

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
                .
                substr(
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
                .
                $phone;
        }


        /*
        |--------------------------------------------------------------------------
        | PREFIX 62
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
            strlen(
                $phone
            )
            <
            10
            ||
            strlen(
                $phone
            )
            >
            16
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
    | MASK PHONE
    |--------------------------------------------------------------------------
    */

    private function maskPhone(
        ?string $phone
    ): ?string {

        if (
            !$phone
        ) {

            return null;
        }


        $length =
            strlen(
                $phone
            );


        if (
            $length <= 7
        ) {

            return
                substr(
                    $phone,
                    0,
                    2
                )
                .
                '***';
        }


        return
            substr(
                $phone,
                0,
                5
            )
            .
            str_repeat(
                '*',
                max(
                    3,
                    $length - 8
                )
            )
            .
            substr(
                $phone,
                -3
            );
    }
}