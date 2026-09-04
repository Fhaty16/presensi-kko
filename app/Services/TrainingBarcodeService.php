<?php

namespace App\Services;

use App\Models\TrainingBarcode;
use App\Models\TrainingSession;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TrainingBarcodeService
{
    /*
    |--------------------------------------------------------------------------
    | KONFIGURASI QR
    |--------------------------------------------------------------------------
    */

    private const LIFETIME_SECONDS =
        60;


    /*
    |--------------------------------------------------------------------------
    | AMBIL BARCODE AKTIF SESI LATIHAN
    |--------------------------------------------------------------------------
    */

    public function getCurrent(
        TrainingSession $trainingSession
    ): array {

        $timezone =
            TrainingAttendanceService::TIMEZONE;


        $now =
            Carbon::now(
                $timezone
            );


        /*
        |--------------------------------------------------------------------------
        | VALIDASI JADWAL
        |--------------------------------------------------------------------------
        */

        if (
            !$trainingSession->training_date
            ||
            !$trainingSession->start_time
            ||
            !$trainingSession->end_time
        ) {

            return [
                'status' =>
                    'no_schedule',

                'message' =>
                    'Jadwal latihan belum lengkap.',
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | TANGGAL
        |--------------------------------------------------------------------------
        */

        $date =
            Carbon::parse(
                $trainingSession->training_date,
                $timezone
            )->format(
                'Y-m-d'
            );


        /*
        |--------------------------------------------------------------------------
        | JAM MULAI
        |--------------------------------------------------------------------------
        */

        $startTime =
            Carbon::parse(
                $trainingSession->start_time,
                $timezone
            )->format(
                'H:i:s'
            );


        /*
        |--------------------------------------------------------------------------
        | JAM SELESAI
        |--------------------------------------------------------------------------
        */

        $endTime =
            Carbon::parse(
                $trainingSession->end_time,
                $timezone
            )->format(
                'H:i:s'
            );


        /*
        |--------------------------------------------------------------------------
        | WAKTU MULAI
        |--------------------------------------------------------------------------
        */

        $startsAt =
            Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $date
                .
                ' '
                .
                $startTime,
                $timezone
            );


        /*
        |--------------------------------------------------------------------------
        | WAKTU SELESAI
        |--------------------------------------------------------------------------
        */

        $endsAt =
            Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $date
                .
                ' '
                .
                $endTime,
                $timezone
            );


        /*
        |--------------------------------------------------------------------------
        | BATAS ALFA
        |--------------------------------------------------------------------------
        |
        | Menggunakan satu sumber konfigurasi:
        |
        | TrainingAttendanceService
        |
        */

        $alphaAt =
            $startsAt
                ->copy()
                ->addMinutes(
                    TrainingAttendanceService::AUTO_ABSENT_AFTER_MINUTES
                );


        /*
        |--------------------------------------------------------------------------
        | BATAS AKHIR PRESENSI
        |--------------------------------------------------------------------------
        |
        | Ditutup pada waktu yang lebih dahulu antara:
        |
        | - jam selesai latihan
        | - start +30 menit
        |
        */

        $closesAt =
            $endsAt->lt(
                $alphaAt
            )
                ? $endsAt->copy()
                : $alphaAt->copy();


        /*
        |--------------------------------------------------------------------------
        | BELUM DIMULAI
        |--------------------------------------------------------------------------
        */

        if (
            $now->lt(
                $startsAt
            )
        ) {

            $this->deactivateAll(
                $trainingSession
            );


            return [
                'status' =>
                    'not_started',

                'message' =>
                    'Presensi latihan belum dibuka.',

                'starts_at' =>
                    $startsAt
                        ->toIso8601String(),

                'ends_at' =>
                    $endsAt
                        ->toIso8601String(),

                'closes_at' =>
                    $closesAt
                        ->toIso8601String(),
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | PRESENSI SUDAH DITUTUP
        |--------------------------------------------------------------------------
        |
        | Tepat closes_at masih boleh.
        |
        | Setelah closes_at baru ditutup.
        |
        */

        if (
            $now->gt(
                $closesAt
            )
        ) {

            $this->deactivateAll(
                $trainingSession
            );


            return [
                'status' =>
                    'ended',

                'message' =>
                    'Presensi latihan sudah ditutup karena batas waktu presensi telah berakhir.',

                'starts_at' =>
                    $startsAt
                        ->toIso8601String(),

                'ends_at' =>
                    $endsAt
                        ->toIso8601String(),

                'closes_at' =>
                    $closesAt
                        ->toIso8601String(),
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | BARCODE AKTIF
        |--------------------------------------------------------------------------
        */

        return DB::transaction(
            function () use (
                $trainingSession,
                $now,
                $startsAt,
                $endsAt,
                $closesAt
            ) {

                /*
                |--------------------------------------------------------------------------
                | NONAKTIFKAN QR EXPIRED / SUDAH DIGUNAKAN
                |--------------------------------------------------------------------------
                */

                TrainingBarcode::where(
                    'training_session_id',
                    $trainingSession->id
                )
                    ->where(
                        'is_active',
                        true
                    )
                    ->where(
                        function ($query) use ($now) {

                            $query
                                ->where(
                                    'expired_at',
                                    '<=',
                                    $now
                                )
                                ->orWhereNotNull(
                                    'used_at'
                                );
                        }
                    )
                    ->update([
                        'is_active' =>
                            false,
                    ]);


                /*
                |--------------------------------------------------------------------------
                | CARI QR YANG MASIH AKTIF
                |--------------------------------------------------------------------------
                */

                $barcode =
                    TrainingBarcode::where(
                        'training_session_id',
                        $trainingSession->id
                    )
                        ->where(
                            'is_active',
                            true
                        )
                        ->whereNull(
                            'used_at'
                        )
                        ->where(
                            'expired_at',
                            '>',
                            $now
                        )
                        ->latest(
                            'id'
                        )
                        ->first();


                /*
                |--------------------------------------------------------------------------
                | BUAT QR BARU
                |--------------------------------------------------------------------------
                */

                if (
                    !$barcode
                ) {

                    /*
                    |--------------------------------------------------------------------------
                    | EXPIRED NORMAL
                    |--------------------------------------------------------------------------
                    */

                    $expiredAt =
                        $now
                            ->copy()
                            ->addSeconds(
                                self::LIFETIME_SECONDS
                            );


                    /*
                    |--------------------------------------------------------------------------
                    | BATAS MAKSIMAL EXPIRED
                    |--------------------------------------------------------------------------
                    |
                    | closes_at:
                    | 14:30:00
                    |
                    | Tepat 14:30:00 masih boleh.
                    |
                    | Karena pengecekan expired menggunakan >=,
                    | expired_at dibuat maksimal:
                    |
                    | 14:30:01
                    |
                    */

                    $maximumExpiredAt =
                        $closesAt
                            ->copy()
                            ->addSecond();


                    if (
                        $expiredAt->gt(
                            $maximumExpiredAt
                        )
                    ) {

                        $expiredAt =
                            $maximumExpiredAt;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | PENGAMAN
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $expiredAt->lte(
                            $now
                        )
                    ) {

                        $this->deactivateAll(
                            $trainingSession
                        );


                        return [
                            'status' =>
                                'ended',

                            'message' =>
                                'Presensi latihan sudah ditutup.',

                            'closes_at' =>
                                $closesAt
                                    ->toIso8601String(),
                        ];
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | SIMPAN QR
                    |--------------------------------------------------------------------------
                    */

                    $barcode =
                        TrainingBarcode::create([
                            'training_session_id' =>
                                $trainingSession->id,

                            'token' =>
                                Str::random(
                                    64
                                ),

                            'expired_at' =>
                                $expiredAt,

                            'is_active' =>
                                true,

                            'used_by_student_id' =>
                                null,

                            'used_at' =>
                                null,
                        ]);
                }


                /*
                |--------------------------------------------------------------------------
                | HITUNG SISA WAKTU
                |--------------------------------------------------------------------------
                */

                $secondsRemaining =
                    (int) max(
                        0,
                        $now->diffInSeconds(
                            $barcode->expired_at,
                            false
                        )
                    );


                /*
                |--------------------------------------------------------------------------
                | RESPONSE
                |--------------------------------------------------------------------------
                */

                return [
                    'status' =>
                        'active',

                    'token' =>
                        $barcode->token,

                    'barcode_id' =>
                        $barcode->id,

                    'expired_at' =>
                        $barcode
                            ->expired_at
                            ->toIso8601String(),

                    'seconds_remaining' =>
                        $secondsRemaining,

                    'starts_at' =>
                        $startsAt
                            ->toIso8601String(),

                    'ends_at' =>
                        $endsAt
                            ->toIso8601String(),

                    'closes_at' =>
                        $closesAt
                            ->toIso8601String(),
                ];
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | NONAKTIFKAN SEMUA QR SESI
    |--------------------------------------------------------------------------
    */

    private function deactivateAll(
        TrainingSession $trainingSession
    ): void {

        TrainingBarcode::where(
            'training_session_id',
            $trainingSession->id
        )
            ->where(
                'is_active',
                true
            )
            ->update([
                'is_active' =>
                    false,
            ]);
    }
}