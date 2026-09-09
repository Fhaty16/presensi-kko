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
    | MASA AKTIF QR
    |--------------------------------------------------------------------------
    */

    private const LIFETIME_SECONDS =
        60;


    /*
    |--------------------------------------------------------------------------
    | CONSTRUCTOR
    |--------------------------------------------------------------------------
    */

    public function __construct(
        protected TrainingAttendanceService $trainingAttendanceService
    ) {
    }


    /*
    |--------------------------------------------------------------------------
    | AMBIL BARCODE AKTIF
    |--------------------------------------------------------------------------
    */

    public function getCurrent(
        TrainingSession $trainingSession
    ): array {

        /*
        |--------------------------------------------------------------------------
        | WAKTU SEKARANG
        |--------------------------------------------------------------------------
        */

        $now =
            Carbon::now(
                TrainingAttendanceService::TIMEZONE
            );


        /*
        |--------------------------------------------------------------------------
        | SATU SUMBER WAKTU
        |--------------------------------------------------------------------------
        */

        $times =
            $this
                ->trainingAttendanceService
                ->getSessionTimes(
                    $trainingSession
                );


        if (!$times) {
            return [
                'status' =>
                    'no_schedule',

                'message' =>
                    'Jadwal latihan belum lengkap.',
            ];
        }


        $startsAt =
            $times['starts_at'];

        $endsAt =
            $times['ends_at'];

        $closesAt =
            $times['closes_at'];


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
                    $startsAt->toIso8601String(),

                'ends_at' =>
                    $endsAt->toIso8601String(),

                'closes_at' =>
                    $closesAt->toIso8601String(),

            ];
        }


        /*
        |--------------------------------------------------------------------------
        | SUDAH LEWAT BATAS
        |--------------------------------------------------------------------------
        |
        | Penting:
        |
        | Tepat pada closes_at masih diperbolehkan.
        | Satu detik setelahnya ditutup.
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
                | MATIKAN QR EXPIRED / SUDAH DIPAKAI
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

                if (!$barcode) {

                    $expiredAt =
                        $now
                            ->copy()
                            ->addSeconds(
                                self::LIFETIME_SECONDS
                            );


                    /*
                    |--------------------------------------------------------------------------
                    | BATAS EXPIRED QR
                    |--------------------------------------------------------------------------
                    |
                    | Scanner masih mengizinkan tepat pada closes_at.
                    |
                    | Karena expired_at bersifat eksklusif:
                    |
                    | now >= expired_at = expired
                    |
                    | maka QR diberi ceiling closes_at + 1 detik.
                    |
                    | Backend tetap menolak request setelah closes_at.
                    |
                    */

                    $expiryCeiling =
                        $closesAt
                            ->copy()
                            ->addSecond();


                    if (
                        $expiredAt->gt(
                            $expiryCeiling
                        )
                    ) {
                        $expiredAt =
                            $expiryCeiling;
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
                | SISA WAKTU
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