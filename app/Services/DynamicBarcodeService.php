<?php

namespace App\Services;

use App\Models\AttendanceSetting;
use App\Models\Barcode;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DynamicBarcodeService
{
    /*
    |--------------------------------------------------------------------------
    | TIMEZONE
    |--------------------------------------------------------------------------
    */

    private const TIMEZONE = 'Asia/Jakarta';


    /*
    |--------------------------------------------------------------------------
    | DEFAULT
    |--------------------------------------------------------------------------
    |
    | Default hanya dipakai jika setting presensi belum tersedia.
    |
    */

    private const DEFAULT_START_TIME = '06:50:00';

    private const DEFAULT_END_TIME = '07:00:00';

    private const DEFAULT_TOLERANCE_MINUTES = 10;

    private const DEFAULT_BARCODE_LIFETIME_SECONDS = 60;


    /*
    |--------------------------------------------------------------------------
    | AMBIL / BUAT BARCODE AKTIF
    |--------------------------------------------------------------------------
    |
    | Aturan:
    |
    | - Sebelum jam mulai:
    |     barcode belum aktif
    |
    | - Jam mulai s/d jam selesai:
    |     barcode aktif
    |
    | - Setelah jam selesai s/d akhir toleransi:
    |     barcode tetap aktif
    |
    | - Mulai 1 menit setelah akhir toleransi:
    |     barcode ditutup
    |
    | Contoh:
    |
    | Mulai       : 09:00
    | Selesai     : 10:00
    | Toleransi   : 7 menit
    |
    | Normal      : 09:00 - 10:00
    | Toleransi   : 10:01 - 10:07
    | Ditutup     : mulai 10:08
    |
    */

    public function current(): array
    {
        /*
        |--------------------------------------------------------------------------
        | SETTING
        |--------------------------------------------------------------------------
        */

        $settings = AttendanceSetting::firstOrCreate(
            [],
            [
                'attendance_start_time' =>
                    self::DEFAULT_START_TIME,

                'attendance_end_time' =>
                    self::DEFAULT_END_TIME,

                'late_after_minutes' =>
                    self::DEFAULT_TOLERANCE_MINUTES,

                'auto_alpha' =>
                    true,

                'location_radius_meters' =>
                    120,

                'barcode_lifetime_seconds' =>
                    self::DEFAULT_BARCODE_LIFETIME_SECONDS,
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | WAKTU SEKARANG
        |--------------------------------------------------------------------------
        */

        $now = Carbon::now(
            self::TIMEZONE
        );

        $today = $now->toDateString();


        /*
        |--------------------------------------------------------------------------
        | JAM MULAI
        |--------------------------------------------------------------------------
        */

        $startTime = $this->normalizeTime(
            $settings->attendance_start_time ?? null,
            self::DEFAULT_START_TIME
        );


        /*
        |--------------------------------------------------------------------------
        | JAM SELESAI
        |--------------------------------------------------------------------------
        */

        $endTime = $this->normalizeTime(
            $settings->attendance_end_time ?? null,
            self::DEFAULT_END_TIME
        );


        /*
        |--------------------------------------------------------------------------
        | TOLERANSI
        |--------------------------------------------------------------------------
        */

        $toleranceMinutes = max(
            0,
            (int) (
                $settings->late_after_minutes
                ?? self::DEFAULT_TOLERANCE_MINUTES
            )
        );


        /*
        |--------------------------------------------------------------------------
        | BARCODE LIFETIME
        |--------------------------------------------------------------------------
        */

        $barcodeLifetime = (int) (
            $settings->barcode_lifetime_seconds
            ?? self::DEFAULT_BARCODE_LIFETIME_SECONDS
        );

        /*
         * Jangan izinkan lifetime aneh.
         *
         * Minimum 1 detik.
         * Maximum 300 detik.
         */

        $barcodeLifetime = max(
            1,
            min(
                300,
                $barcodeLifetime
            )
        );


        /*
        |--------------------------------------------------------------------------
        | BENTUK DATETIME
        |--------------------------------------------------------------------------
        */

        $startsAt = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $today . ' ' . $startTime,
            self::TIMEZONE
        );

        $endsAt = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $today . ' ' . $endTime,
            self::TIMEZONE
        );


        /*
        |--------------------------------------------------------------------------
        | VALIDASI JAM SELESAI
        |--------------------------------------------------------------------------
        */

        if ($endsAt->lt($startsAt)) {
            return [
                'status' =>
                    'invalid_schedule',

                'closed' =>
                    true,

                'message' =>
                    'Pengaturan waktu presensi tidak valid. Jam selesai tidak boleh lebih awal dari jam mulai.',

                'payload' =>
                    null,

                'token' =>
                    null,

                'seconds_remaining' =>
                    0,
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | AKHIR TOLERANSI
        |--------------------------------------------------------------------------
        |
        | Contoh:
        |
        | selesai     = 10:00
        | toleransi   = 7
        |
        | akhir       = 10:07
        |
        */

        $toleranceEndsAt = $endsAt
            ->copy()
            ->addMinutes(
                $toleranceMinutes
            );


        /*
        |--------------------------------------------------------------------------
        | MULAI DITUTUP
        |--------------------------------------------------------------------------
        |
        | Jika toleransi sampai 10:07,
        | maka presensi mulai ditutup pada 10:08.
        |
        */

        $closesAt = $toleranceEndsAt
            ->copy()
            ->addMinute()
            ->startOfMinute();


        /*
        |--------------------------------------------------------------------------
        | BELUM DIMULAI
        |--------------------------------------------------------------------------
        */

        if ($now->lt($startsAt)) {

            $this->deactivateAll();

            return [
                'status' =>
                    'not_started',

                'closed' =>
                    true,

                'message' =>
                    'Presensi belum dibuka. Barcode akan aktif mulai pukul '
                    . $startsAt->format('H:i')
                    . ' WIB.',

                'payload' =>
                    null,

                'token' =>
                    null,

                'barcode_id' =>
                    null,

                'seconds_remaining' =>
                    0,

                'starts_at' =>
                    $startsAt->toIso8601String(),

                'ends_at' =>
                    $endsAt->toIso8601String(),

                'tolerance_ends_at' =>
                    $toleranceEndsAt->toIso8601String(),

                'closes_at' =>
                    $closesAt->toIso8601String(),
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | SUDAH DITUTUP
        |--------------------------------------------------------------------------
        */

        if ($now->gte($closesAt)) {

            $this->deactivateAll();

            return [
                'status' =>
                    'ended',

                'closed' =>
                    true,

                'message' =>
                    'Presensi sudah ditutup. Batas terakhir presensi pukul '
                    . $toleranceEndsAt->format('H:i')
                    . ' WIB.',

                'payload' =>
                    null,

                'token' =>
                    null,

                'barcode_id' =>
                    null,

                'seconds_remaining' =>
                    0,

                'starts_at' =>
                    $startsAt->toIso8601String(),

                'ends_at' =>
                    $endsAt->toIso8601String(),

                'tolerance_ends_at' =>
                    $toleranceEndsAt->toIso8601String(),

                'closes_at' =>
                    $closesAt->toIso8601String(),
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | PERIODE PRESENSI AKTIF
        |--------------------------------------------------------------------------
        */

        return DB::transaction(
            function () use (
                $now,
                $startsAt,
                $endsAt,
                $toleranceEndsAt,
                $closesAt,
                $barcodeLifetime
            ) {

                /*
                |--------------------------------------------------------------------------
                | NONAKTIFKAN BARCODE EXPIRED / SUDAH DIPAKAI
                |--------------------------------------------------------------------------
                */

                Barcode::where(
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
                | CARI BARCODE AKTIF
                |--------------------------------------------------------------------------
                */

                $barcode = Barcode::where(
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
                    ->lockForUpdate()
                    ->first();


                /*
                |--------------------------------------------------------------------------
                | BUAT BARCODE BARU JIKA TIDAK ADA
                |--------------------------------------------------------------------------
                */

                if (!$barcode) {

                    $expiredAt = $now
                        ->copy()
                        ->addSeconds(
                            $barcodeLifetime
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | QR TIDAK BOLEH MELEWATI JAM TUTUP
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
                    */

                    if (
                        $expiredAt->lte(
                            $now
                        )
                    ) {
                        return [
                            'status' =>
                                'ended',

                            'closed' =>
                                true,

                            'message' =>
                                'Presensi sudah ditutup.',

                            'payload' =>
                                null,

                            'token' =>
                                null,

                            'barcode_id' =>
                                null,

                            'seconds_remaining' =>
                                0,

                            'starts_at' =>
                                $startsAt->toIso8601String(),

                            'ends_at' =>
                                $endsAt->toIso8601String(),

                            'tolerance_ends_at' =>
                                $toleranceEndsAt->toIso8601String(),

                            'closes_at' =>
                                $closesAt->toIso8601String(),
                        ];
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | TOKEN BARU
                    |--------------------------------------------------------------------------
                    */

                    $token = Str::random(
                        64
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | SIMPAN
                    |--------------------------------------------------------------------------
                    */

                    $barcode = new Barcode();

                    $barcode->token =
                        $token;

                    $barcode->expired_at =
                        $expiredAt;

                    $barcode->is_active =
                        true;

                    $barcode->used_by_student_id =
                        null;

                    $barcode->used_at =
                        null;

                    $barcode->save();
                }


                /*
                |--------------------------------------------------------------------------
                | HITUNG SISA DETIK
                |--------------------------------------------------------------------------
                */

                $secondsRemaining = (int) max(
                    0,
                    $now->diffInSeconds(
                        $barcode->expired_at,
                        false
                    )
                );


                /*
                |--------------------------------------------------------------------------
                | FASE PRESENSI
                |--------------------------------------------------------------------------
                */

                $phase = $now->lte(
                    $endsAt
                )
                    ? 'regular'
                    : 'tolerance';


                /*
                |--------------------------------------------------------------------------
                | RESPONSE
                |--------------------------------------------------------------------------
                |
                | payload HARUS menggunakan prefix KKO:
                |
                | Karena scanner siswa membaca:
                |
                | KKO:TOKEN
                |
                */

                return [
                    'status' =>
                        'active',

                    'closed' =>
                        false,

                    'phase' =>
                        $phase,

                    'token' =>
                        $barcode->token,

                    'payload' =>
                        'KKO:' . $barcode->token,

                    'barcode_id' =>
                        $barcode->id,

                    'seconds_remaining' =>
                        $secondsRemaining,

                    'expired_at' =>
                        $barcode
                            ->expired_at
                            ->toIso8601String(),

                    'starts_at' =>
                        $startsAt->toIso8601String(),

                    'ends_at' =>
                        $endsAt->toIso8601String(),

                    'tolerance_ends_at' =>
                        $toleranceEndsAt->toIso8601String(),

                    'closes_at' =>
                        $closesAt->toIso8601String(),
                ];
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | NONAKTIFKAN SEMUA BARCODE
    |--------------------------------------------------------------------------
    */

    private function deactivateAll(): void
    {
        Barcode::where(
            'is_active',
            true
        )
            ->update([
                'is_active' =>
                    false,
            ]);
    }


    /*
    |--------------------------------------------------------------------------
    | NORMALISASI JAM
    |--------------------------------------------------------------------------
    */

    private function normalizeTime(
        ?string $value,
        string $fallback
    ): string {

        $value = trim(
            (string) $value
        );


        if ($value === '') {
            return $fallback;
        }


        /*
         * 09:00
         * menjadi
         * 09:00:00
         */

        if (
            strlen($value)
            ===
            5
        ) {
            return $value
                . ':00';
        }


        /*
         * Pastikan hanya H:i:s.
         */

        return substr(
            $value,
            0,
            8
        );
    }
}