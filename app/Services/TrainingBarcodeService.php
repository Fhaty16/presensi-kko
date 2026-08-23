<?php

namespace App\Services;

use App\Models\TrainingBarcode;
use App\Models\TrainingSession;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TrainingBarcodeService
{
    private const LIFETIME_SECONDS = 60;

    /*
    |--------------------------------------------------------------------------
    | AMBIL BARCODE AKTIF SESI LATIHAN
    |--------------------------------------------------------------------------
    */

    public function getCurrent(
        TrainingSession $trainingSession
    ): array {
        $now = Carbon::now('Asia/Jakarta');

        /*
        |--------------------------------------------------------------------------
        | VALIDASI JADWAL
        |--------------------------------------------------------------------------
        */

        if (
            !$trainingSession->training_date ||
            !$trainingSession->start_time ||
            !$trainingSession->end_time
        ) {
            return [
                'status' => 'no_schedule',
                'message' => 'Jadwal latihan belum lengkap.',
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | BENTUK WAKTU SESI
        |--------------------------------------------------------------------------
        */

        $date = $trainingSession
            ->training_date
            ->format('Y-m-d');

        $startTime = Carbon::parse(
            $trainingSession->start_time,
            'Asia/Jakarta'
        )->format('H:i:s');

        $endTime = Carbon::parse(
            $trainingSession->end_time,
            'Asia/Jakarta'
        )->format('H:i:s');

        $startsAt = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $date . ' ' . $startTime,
            'Asia/Jakarta'
        );

        $endsAt = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $date . ' ' . $endTime,
            'Asia/Jakarta'
        );

        /*
        |--------------------------------------------------------------------------
        | LATIHAN BELUM DIMULAI
        |--------------------------------------------------------------------------
        */

        if ($now->lt($startsAt)) {
            return [
                'status' => 'not_started',

                'message' =>
                    'Presensi latihan belum dibuka.',

                'starts_at' =>
                    $startsAt->toIso8601String(),

                'ends_at' =>
                    $endsAt->toIso8601String(),
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | LATIHAN SUDAH SELESAI
        |--------------------------------------------------------------------------
        */

        if ($now->gt($endsAt)) {
            $this->deactivateAll(
                $trainingSession
            );

            return [
                'status' => 'ended',

                'message' =>
                    'Presensi latihan sudah ditutup.',

                'ends_at' =>
                    $endsAt->toIso8601String(),
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
                $endsAt
            ) {

                /*
                |--------------------------------------------------------------------------
                | NONAKTIFKAN BARCODE EXPIRED / SUDAH DIGUNAKAN
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
                | CARI BARCODE YANG MASIH AKTIF
                |--------------------------------------------------------------------------
                */

                $barcode = TrainingBarcode::where(
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
                | BUAT BARCODE BARU
                |--------------------------------------------------------------------------
                */

                if (!$barcode) {
                    $expiredAt = $now
                        ->copy()
                        ->addSeconds(
                            self::LIFETIME_SECONDS
                        );

                    /*
                    |--------------------------------------------------------------------------
                    | BARCODE TIDAK BOLEH MELEWATI JAM SELESAI LATIHAN
                    |--------------------------------------------------------------------------
                    */

                    if ($expiredAt->gt($endsAt)) {
                        $expiredAt =
                            $endsAt->copy();
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
                ];
            }
        );
    }

    /*
    |--------------------------------------------------------------------------
    | NONAKTIFKAN SEMUA BARCODE SESI
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