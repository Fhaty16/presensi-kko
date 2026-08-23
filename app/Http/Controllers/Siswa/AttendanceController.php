<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceSetting;
use App\Models\Barcode;
use App\Models\Student;
use App\Services\DynamicBarcodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN SCANNER SISWA
    |--------------------------------------------------------------------------
    */

    public function scanner()
    {
        $student = Student::where(
            'user_id',
            auth()->id()
        )->firstOrFail();

        $todayAttendance = Attendance::where(
            'student_id',
            $student->id
        )
            ->whereDate(
                'attendance_date',
                now()->toDateString()
            )
            ->first();

        return view(
            'siswa.scan',
            compact(
                'student',
                'todayAttendance'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PROSES PRESENSI
    |--------------------------------------------------------------------------
    */

    public function store(
        Request $request,
        DynamicBarcodeService $barcodeService
    ) {

        /*
        |--------------------------------------------------------------------------
        | VALIDASI REQUEST
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'token' => [
                'required',
                'string',
                'max:255',
            ],

            'latitude' => [
                'required',
                'numeric',
                'between:-90,90',
            ],

            'longitude' => [
                'required',
                'numeric',
                'between:-180,180',
            ],

            'accuracy' => [
                'nullable',
                'numeric',
                'min:0',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | VALIDASI PREFIX QR
        |--------------------------------------------------------------------------
        |
        | Semua QR KKO harus memiliki format:
        |
        | KKO:TOKEN
        |
        */

        if (!str_starts_with(
            $request->token,
            'KKO:'
        )) {

            return response()->json([
                'success' => false,
                'message' => 'Barcode tidak dikenali.',
            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | AMBIL TOKEN ASLI
        |--------------------------------------------------------------------------
        */

        $token = substr(
            $request->token,
            4
        );


        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA SISWA LOGIN
        |--------------------------------------------------------------------------
        */

        $student = Student::where(
            'user_id',
            auth()->id()
        )
            ->where(
                'status',
                'active'
            )
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | SETTING PRESENSI
        |--------------------------------------------------------------------------
        |
        | 07:00 masih boleh presensi.
        | Tepat mulai 07:01:00 presensi ditutup.
        |
        */

        $settings = AttendanceSetting::firstOrCreate(
            [],
            [
                'cutoff_time' => '07:01:00',
                'auto_alpha' => true,
                'location_radius_meters' => 120,
                'barcode_lifetime_seconds' => 60,
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | VALIDASI LOKASI SEKOLAH
        |--------------------------------------------------------------------------
        */

        if (
            $settings->school_latitude === null
            || $settings->school_longitude === null
        ) {

            return response()->json([
                'success' => false,
                'message' => 'Lokasi sekolah belum dikonfigurasi oleh admin.',
            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | WAKTU SEKARANG
        |--------------------------------------------------------------------------
        */

        $now = now();


        /*
        |--------------------------------------------------------------------------
        | VALIDASI BATAS PRESENSI
        |--------------------------------------------------------------------------
        |
        | Contoh:
        |
        | 06:59:59 = boleh
        | 07:00:00 = boleh
        | 07:00:30 = boleh
        | 07:00:59 = boleh
        | 07:01:00 = ditolak
        | 07:01:01 = ditolak
        |
        */

        $cutoff = $now
            ->copy()
            ->setTimeFromTimeString(
                $settings->cutoff_time
            );


        if ($now->gte($cutoff)) {

            return response()->json([
                'success' => false,
                'message' => 'Presensi sudah ditutup. Mulai pukul 07:01 WIB siswa yang belum presensi dinyatakan Alfa.',
            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | HITUNG JARAK SISWA DENGAN SEKOLAH
        |--------------------------------------------------------------------------
        */

        $distance = $this->distanceInMeters(
            (float) $request->latitude,
            (float) $request->longitude,
            (float) $settings->school_latitude,
            (float) $settings->school_longitude
        );


        /*
        |--------------------------------------------------------------------------
        | VALIDASI GEOFENCE
        |--------------------------------------------------------------------------
        */

        if (
            $distance >
            $settings->location_radius_meters
        ) {

            return response()->json([
                'success' => false,

                'message' =>
                    'Presensi hanya dapat dilakukan di lingkungan SMA Negeri 2 Cilacap.',

                'distance' =>
                    round($distance),

                'radius' =>
                    $settings->location_radius_meters,

            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | DATABASE TRANSACTION
        |--------------------------------------------------------------------------
        */

        try {

            DB::transaction(function () use (
                $student,
                $token,
                $now
            ) {


                /*
                |--------------------------------------------------------------------------
                | CEK SUDAH PRESENSI ATAU BELUM
                |--------------------------------------------------------------------------
                */

                $alreadyAttendance =
                    Attendance::where(
                        'student_id',
                        $student->id
                    )
                        ->whereDate(
                            'attendance_date',
                            $now->toDateString()
                        )
                        ->lockForUpdate()
                        ->exists();


                if ($alreadyAttendance) {

                    throw new \RuntimeException(
                        'Kamu sudah melakukan presensi hari ini.'
                    );

                }



                /*
                |--------------------------------------------------------------------------
                | AMBIL DAN KUNCI BARCODE
                |--------------------------------------------------------------------------
                |
                | lockForUpdate digunakan agar satu barcode tidak dapat
                | digunakan dua siswa secara bersamaan.
                |
                */

                $barcode =
                    Barcode::where(
                        'token',
                        $token
                    )
                        ->lockForUpdate()
                        ->first();


                /*
                |--------------------------------------------------------------------------
                | BARCODE TIDAK DITEMUKAN
                |--------------------------------------------------------------------------
                */

                if (!$barcode) {

                    throw new \RuntimeException(
                        'Barcode tidak ditemukan.'
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | BARCODE SUDAH TIDAK AKTIF
                |--------------------------------------------------------------------------
                */

                if (!$barcode->is_active) {

                    throw new \RuntimeException(
                        'Barcode sudah digunakan. Silakan scan barcode terbaru.'
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | BARCODE SUDAH DIGUNAKAN SISWA LAIN
                |--------------------------------------------------------------------------
                */

                if ($barcode->used_at !== null) {

                    throw new \RuntimeException(
                        'Barcode sudah digunakan oleh siswa lain.'
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | BARCODE KEDALUWARSA
                |--------------------------------------------------------------------------
                */

                if (
                    !$barcode->expired_at
                    || $barcode->expired_at->lte($now)
                ) {

                    $barcode->update([
                        'is_active' => false,
                    ]);


                    throw new \RuntimeException(
                        'Barcode sudah kedaluwarsa. Silakan scan barcode terbaru.'
                    );

                }



                /*
                |--------------------------------------------------------------------------
                | SIMPAN PRESENSI SISWA
                |--------------------------------------------------------------------------
                */

                Attendance::create([

                    'student_id' =>
                        $student->id,

                    'barcode_id' =>
                        $barcode->id,

                    'attendance_date' =>
                        $now->toDateString(),

                    'check_in_time' =>
                        $now->format('H:i:s'),

                    'status' =>
                        'present',

                    'notes' =>
                        'Presensi barcode dinamis',

                    'wa_sent' =>
                        false,

                ]);



                /*
                |--------------------------------------------------------------------------
                | MATIKAN BARCODE SETELAH BERHASIL DIGUNAKAN
                |--------------------------------------------------------------------------
                */

                $barcode->update([

                    'is_active' =>
                        false,

                    'used_by_student_id' =>
                        $student->id,

                    'used_at' =>
                        $now,

                ]);

            });


        } catch (\RuntimeException $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | GENERATE BARCODE BERIKUTNYA
        |--------------------------------------------------------------------------
        |
        | Setelah barcode dipakai satu siswa, barcode lama langsung mati
        | dan barcode baru dibuat untuk siswa berikutnya.
        |
        */

        $barcodeService->current();


        /*
        |--------------------------------------------------------------------------
        | RESPONSE BERHASIL
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' =>
                true,

            'message' =>
                'Presensi berhasil.',

            'student' =>
                auth()->user()->name,

            'nis' =>
                $student->nis,

            'time' =>
                $now->format('H:i'),

            'status' =>
                'HADIR',

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | HITUNG JARAK GPS - HAVERSINE
    |--------------------------------------------------------------------------
    */

    private function distanceInMeters(
        float $lat1,
        float $lon1,
        float $lat2,
        float $lon2
    ): float {

        /*
         * Radius bumi dalam meter.
         */
        $earthRadius = 6371000;


        /*
         * Konversi koordinat ke radian.
         */
        $latFrom = deg2rad($lat1);

        $lonFrom = deg2rad($lon1);

        $latTo = deg2rad($lat2);

        $lonTo = deg2rad($lon2);


        /*
         * Selisih latitude dan longitude.
         */
        $latDelta =
            $latTo - $latFrom;

        $lonDelta =
            $lonTo - $lonFrom;


        /*
         * Rumus Haversine.
         */
        $a =
            sin($latDelta / 2) ** 2
            +
            cos($latFrom)
            *
            cos($latTo)
            *
            sin($lonDelta / 2) ** 2;


        $c =
            2
            *
            atan2(
                sqrt($a),
                sqrt(1 - $a)
            );


        /*
         * Hasil dalam meter.
         */
        return $earthRadius * $c;
    }
}