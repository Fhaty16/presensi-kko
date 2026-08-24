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
    | KONFIGURASI
    |--------------------------------------------------------------------------
    */

    private const LIFETIME_SECONDS = 60;

    private const ATTENDANCE_LIMIT_MINUTES = 30;


    /*
    |--------------------------------------------------------------------------
    | AMBIL BARCODE AKTIF SESI LATIHAN
    |--------------------------------------------------------------------------
    */

    public function getCurrent(
        TrainingSession $trainingSession
    ): array {
        $timezone = 'Asia/Jakarta';

        $now = Carbon::now($timezone);


        /*
        |--------------------------------------------------------------------------
        | VALIDASI JADWAL
        |--------------------------------------------------------------------------
        */

        if (
            !$trainingSession->training_date
            || !$trainingSession->start_time
            || !$trainingSession->end_time
        ) {
            return [
                'status' => 'no_schedule',
                'message' => 'Jadwal latihan belum lengkap.',
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | BENTUK TANGGAL SESI
        |--------------------------------------------------------------------------
        */

        $date =
            Carbon::parse(
                $trainingSession->training_date,
                $timezone
            )->format('Y-m-d');


        $startTime =
            Carbon::parse(
                $trainingSession->start_time,
                $timezone
            )->format('H:i:s');


        $endTime =
            Carbon::parse(
                $trainingSession->end_time,
                $timezone
            )->format('H:i:s');


        /*
        |--------------------------------------------------------------------------
        | WAKTU SESI
        |--------------------------------------------------------------------------
        */

        $startsAt =
            Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $date . ' ' . $startTime,
                $timezone
            );


        $endsAt =
            Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $date . ' ' . $endTime,
                $timezone
            );


        /*
        |--------------------------------------------------------------------------
        | BATAS ALFA / BATAS PRESENSI
        |--------------------------------------------------------------------------
        |
        | Contoh:
        |
        | Mulai       : 14:00
        | Batas Alfa  : 14:30
        |
        | Tepat 14:30:00 masih diperbolehkan.
        | Setelah 14:30:00 ditutup.
        |
        */

        $alphaAt =
            $startsAt
                ->copy()
                ->addMinutes(
                    self::ATTENDANCE_LIMIT_MINUTES
                );


        /*
        |--------------------------------------------------------------------------
        | WAKTU PENUTUPAN QR
        |--------------------------------------------------------------------------
        |
        | QR tidak boleh melewati:
        |
        | 1. Jam selesai latihan
        | atau
        | 2. Batas Alfa +30 menit
        |
        | mana yang lebih dahulu.
        |
        */

        $closesAt =
            $endsAt->lt($alphaAt)
                ? $endsAt->copy()
                : $alphaAt->copy();


        /*
        |--------------------------------------------------------------------------
        | LATIHAN BELUM DIMULAI
        |--------------------------------------------------------------------------
        */

        if ($now->lt($startsAt)) {
            $this->deactivateAll(
                $trainingSession
            );

            return [
                'status' => 'not_started',

                'message' =>
                    'Presensi latihan belum dibuka.',

                'starts_at' =>
                    $startsAt->toIso8601String(),

                'ends_at' =>
                    $endsAt->toIso8601String(),

                'closes_at' =>
                    $closesAt->toIso8601String(),
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | PRESENSI SUDAH DITUTUP
        |--------------------------------------------------------------------------
        |
        | Ditutup jika:
        |
        | - sudah melewati jam selesai
        | - atau sudah melewati +30 menit
        |
        */

        if ($now->gt($closesAt)) {
            $this->deactivateAll(
                $trainingSession
            );

            return [
                'status' => 'ended',

                'message' =>
                    'Presensi latihan sudah ditutup karena batas waktu presensi telah berakhir.',

                'starts_at' =>
                    $startsAt->toIso8601String(),

                'ends_at' =>
                    $endsAt->toIso8601String(),

                'closes_at' =>
                    $closesAt->toIso8601String(),
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
                        'is_active' => false,
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
                        ->latest('id')
                        ->first();


                /*
                |--------------------------------------------------------------------------
                | BUAT QR BARU
                |--------------------------------------------------------------------------
                */

                if (!$barcode) {

                    $expiredAt =
                        $now
                            ->copy()
                            ->addSeconds(
                                self::LIFETIME_SECONDS
                            );


                    /*
                    |--------------------------------------------------------------------------
                    | QR TIDAK BOLEH MELEWATI BATAS PRESENSI
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $expiredAt->gt(
                            $closesAt
                        )
                    ) {
                        $expiredAt =
                            $closesAt->copy();
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | PENGAMAN
                    |--------------------------------------------------------------------------
                    |
                    | Jangan buat QR jika waktunya sudah habis.
                    |
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
                            'status' => 'ended',

                            'message' =>
                                'Presensi latihan sudah ditutup.',

                            'closes_at' =>
                                $closesAt->toIso8601String(),
                        ];
                    }


                    $barcode =
                        TrainingBarcode::create([
                            'training_session_id' =>
                                $trainingSession->id,

                            'token' =>
                                Str::random(64),

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
                | HITUNG SISA WAKTU QR
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
                        $startsAt->toIso8601String(),

                    'ends_at' =>
                        $endsAt->toIso8601String(),

                    'closes_at' =>
                        $closesAt->toIso8601String(),
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
                'is_active' => false,
            ]);
    }
}