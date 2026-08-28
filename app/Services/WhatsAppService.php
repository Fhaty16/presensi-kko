<?php

namespace App\Services;

use App\Jobs\SendWhatsAppNotification;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\WhatsAppNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /*
    |--------------------------------------------------------------------------
    | BUAT NOTIFIKASI PRESENSI
    |--------------------------------------------------------------------------
    |
    | Alur:
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

        $parentPhone =
            $this->normalizePhone(
                $student->parent_phone
            );


        /*
        |--------------------------------------------------------------------------
        | NOMOR ORANG TUA KOSONG
        |--------------------------------------------------------------------------
        */

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
        |
        | Contoh:
        |
        | school_attendance:154:absent
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
        | event_key UNIQUE mencegah pesan ganda.
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
        | NOTIFICATION BARU
        |--------------------------------------------------------------------------
        */

        if (
            $notification->wasRecentlyCreated
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
                        $notification->recipient_phone,

                    'attendance_status' =>
                        $notification->attendance_status,

                    'message' =>
                        $notification->message,
                ]
            );


            /*
            |--------------------------------------------------------------------------
            | DISPATCH JOB OTOMATIS
            |--------------------------------------------------------------------------
            |
            | Job hanya dibuat ketika notification benar-benar BARU.
            |
            | afterCommit() memastikan Job tidak dijalankan sebelum
            | transaksi database selesai apabila method ini suatu saat
            | dipanggil di dalam DB transaction.
            |
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

            } catch (
                \Throwable $exception
            ) {
                /*
                |--------------------------------------------------------------------------
                | JANGAN HAPUS NOTIFICATION
                |--------------------------------------------------------------------------
                |
                | Jika dispatch gagal, notification tetap PENDING sehingga
                | nantinya masih dapat diproses ulang.
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
    | SAAT INI MASIH TEST MODE.
    |
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
        | SUDAH TERKIRIM
        |--------------------------------------------------------------------------
        */

        if (
            $notification->status
            === 'sent'
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
            === 'skipped'
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
                $notification->recipient_phone
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
                $notification->message
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
        | PROCESSING
        |--------------------------------------------------------------------------
        */

        $notification
            ->markAsProcessing();


        /*
        |--------------------------------------------------------------------------
        | TEST MODE
        |--------------------------------------------------------------------------
        |
        | Belum ada request ke Meta WhatsApp Cloud API.
        |
        */

        Log::info(
            'WHATSAPP SEND TEST MODE',
            [
                'notification_id' =>
                    $notification->id,

                'student_id' =>
                    $notification->student_id,

                'attendance_id' =>
                    $notification->attendance_id,

                'recipient_phone' =>
                    $notification->recipient_phone,

                'attendance_status' =>
                    $notification->attendance_status,

                'attempts' =>
                    $notification->attempts,

                'message' =>
                    $notification->message,
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | SIMULASI PROVIDER ID
        |--------------------------------------------------------------------------
        */

        $providerMessageId =
            'TEST-MODE-'
            . $notification->id;


        /*
        |--------------------------------------------------------------------------
        | SIMULASI BERHASIL
        |--------------------------------------------------------------------------
        */

        $notification
            ->markAsSent(
                $providerMessageId
            );


        /*
        |--------------------------------------------------------------------------
        | LOG
        |--------------------------------------------------------------------------
        */

        Log::info(
            'WHATSAPP TEST MODE BERHASIL',
            [
                'notification_id' =>
                    $notification->id,

                'provider_message_id' =>
                    $providerMessageId,

                'recipient_phone' =>
                    $notification->recipient_phone,
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | WA_SENT BELUM TRUE
        |--------------------------------------------------------------------------
        |
        | attendance.wa_sent belum diubah karena belum ada
        | WhatsApp sungguhan yang dikirim.
        |
        */
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
                    'Asia/Jakarta'
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
                (string) $attendance->status
            );


        /*
        |--------------------------------------------------------------------------
        | HADIR
        |--------------------------------------------------------------------------
        */

        if (
            $status
            === 'present'
        ) {
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

        if (
            $status
            === 'late'
        ) {
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
        if (
            $attendance->check_in_time
        ) {
            try {
                return Carbon::parse(
                    $attendance->check_in_time
                )->format(
                    'H:i'
                );

            } catch (
                \Throwable $exception
            ) {
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

        if (
            !$phone
        ) {
            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | HAPUS SELAIN ANGKA
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
                        $phone,
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
            strlen(
                $phone
            ) < 10
            ||
            strlen(
                $phone
            ) > 16
        ) {
            Log::warning(
                'Panjang nomor WhatsApp tidak valid.',
                [
                    'phone' =>
                        $phone,
                ]
            );

            return null;
        }


        return $phone;
    }
}