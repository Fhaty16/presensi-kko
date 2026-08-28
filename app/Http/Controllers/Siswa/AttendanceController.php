<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceSetting;
use App\Models\Barcode;
use App\Models\Student;
use App\Services\DynamicBarcodeService;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN SCANNER SISWA
    |--------------------------------------------------------------------------
    */

    public function scanner()
    {
        /*
        |--------------------------------------------------------------------------
        | AMBIL SISWA LOGIN
        |--------------------------------------------------------------------------
        */

        $student = Student::where(
            'user_id',
            auth()->id()
        )->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | PRESENSI HARI INI
        |--------------------------------------------------------------------------
        */

        $todayAttendance = Attendance::where(
            'student_id',
            $student->id
        )
            ->whereDate(
                'attendance_date',
                now()->toDateString()
            )
            ->first();


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

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
        DynamicBarcodeService $barcodeService,
        WhatsAppService $whatsAppService
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
        | Semua QR presensi sekolah KKO harus memiliki format:
        |
        | KKO:TOKEN
        |
        */

        if (
            !str_starts_with(
                $request->token,
                'KKO:'
            )
        ) {
            return response()->json([
                'success' => false,

                'message' =>
                    'Barcode tidak dikenali.',
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
        | Ketentuan:
        |
        | 07:00:59 = masih boleh
        | 07:01:00 = sudah ditutup
        |
        */

        $settings = AttendanceSetting::firstOrCreate(
            [],
            [
                'cutoff_time' =>
                    '07:01:00',

                'auto_alpha' =>
                    true,

                'location_radius_meters' =>
                    120,

                'barcode_lifetime_seconds' =>
                    60,
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | VALIDASI KONFIGURASI LOKASI SEKOLAH
        |--------------------------------------------------------------------------
        */

        if (
            $settings->school_latitude === null
            ||
            $settings->school_longitude === null
        ) {
            return response()->json([
                'success' => false,

                'message' =>
                    'Lokasi sekolah belum dikonfigurasi oleh admin.',
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
        | BATAS PRESENSI
        |--------------------------------------------------------------------------
        */

        $cutoff = $now
            ->copy()
            ->setTimeFromTimeString(
                $settings->cutoff_time
            );


        /*
        |--------------------------------------------------------------------------
        | JIKA SUDAH 07:01
        |--------------------------------------------------------------------------
        */

        if (
            $now->gte(
                $cutoff
            )
        ) {
            return response()->json([
                'success' => false,

                'message' =>
                    'Presensi sudah ditutup. Mulai pukul 07:01 WIB siswa yang belum presensi dinyatakan Alfa.',
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
            $distance
            >
            $settings->location_radius_meters
        ) {
            return response()->json([
                'success' =>
                    false,

                'message' =>
                    'Presensi hanya dapat dilakukan di lingkungan SMA Negeri 2 Cilacap.',

                'distance' =>
                    round(
                        $distance
                    ),

                'radius' =>
                    $settings->location_radius_meters,

            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | VARIABLE ATTENDANCE
        |--------------------------------------------------------------------------
        |
        | Setelah transaction berhasil, object Attendance
        | akan disimpan di variable ini.
        |
        */

        $attendance = null;


        /*
        |--------------------------------------------------------------------------
        | DATABASE TRANSACTION
        |--------------------------------------------------------------------------
        */

        try {
            $attendance = DB::transaction(
                function () use (
                    $student,
                    $token,
                    $now
                ) {
                    /*
                    |--------------------------------------------------------------------------
                    | CEK SUDAH PRESENSI
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


                    if (
                        $alreadyAttendance
                    ) {
                        throw new \RuntimeException(
                            'Kamu sudah melakukan presensi hari ini.'
                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | AMBIL BARCODE
                    |--------------------------------------------------------------------------
                    |
                    | Barcode dikunci agar tidak dapat digunakan
                    | dua siswa secara bersamaan.
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

                    if (
                        !$barcode
                    ) {
                        throw new \RuntimeException(
                            'Barcode tidak ditemukan.'
                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | BARCODE TIDAK AKTIF
                    |--------------------------------------------------------------------------
                    */

                    if (
                        !$barcode->is_active
                    ) {
                        throw new \RuntimeException(
                            'Barcode sudah digunakan. Silakan scan barcode terbaru.'
                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | BARCODE SUDAH DIGUNAKAN
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $barcode->used_at !== null
                    ) {
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
                        ||
                        $barcode->expired_at->lte(
                            $now
                        )
                    ) {
                        /*
                        |--------------------------------------------------------------------------
                        | MATIKAN BARCODE
                        |--------------------------------------------------------------------------
                        */

                        $barcode->update([
                            'is_active' =>
                                false,
                        ]);


                        throw new \RuntimeException(
                            'Barcode sudah kedaluwarsa. Silakan scan barcode terbaru.'
                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | SIMPAN PRESENSI
                    |--------------------------------------------------------------------------
                    */

                    $attendance =
                        Attendance::create([
                            'student_id' =>
                                $student->id,

                            'barcode_id' =>
                                $barcode->id,

                            'attendance_date' =>
                                $now->toDateString(),

                            'check_in_time' =>
                                $now->format(
                                    'H:i:s'
                                ),

                            'status' =>
                                'present',

                            'notes' =>
                                'Presensi barcode dinamis',

                            /*
                            |--------------------------------------------------------------------------
                            | WA BELUM TERKIRIM
                            |--------------------------------------------------------------------------
                            |
                            | Saat ini kita masih TEST MODE.
                            |
                            */

                            'wa_sent' =>
                                false,
                        ]);


                    /*
                    |--------------------------------------------------------------------------
                    | MATIKAN BARCODE
                    |--------------------------------------------------------------------------
                    |
                    | Barcode hanya boleh digunakan satu kali.
                    |
                    */

                    $barcode->update([
                        'is_active' =>
                            false,

                        'used_by_student_id' =>
                            $student->id,

                        'used_at' =>
                            $now,
                    ]);


                    /*
                    |--------------------------------------------------------------------------
                    | RETURN ATTENDANCE
                    |--------------------------------------------------------------------------
                    |
                    | Object ini dibawa keluar dari transaction
                    | untuk membuat WhatsApp Notification.
                    |
                    */

                    return $attendance;
                }
            );

        } catch (\RuntimeException $e) {
            /*
            |--------------------------------------------------------------------------
            | ERROR PRESENSI
            |--------------------------------------------------------------------------
            */

            return response()->json([
                'success' =>
                    false,

                'message' =>
                    $e->getMessage(),
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | GENERATE BARCODE BERIKUTNYA
        |--------------------------------------------------------------------------
        |
        | Presensi sudah COMMIT pada tahap ini.
        |
        */

        $barcodeService->current();


        /*
        |--------------------------------------------------------------------------
        | BUAT NOTIFIKASI WHATSAPP
        |--------------------------------------------------------------------------
        |
        | PENTING:
        |
        | Method ini dijalankan SETELAH transaction presensi selesai.
        |
        | Jadi:
        |
        | - Presensi tidak bergantung pada WhatsApp.
        | - Jika WhatsApp error, presensi tetap berhasil.
        | - Untuk sekarang hanya membuat log status PENDING.
        | - Belum mengirim pesan WhatsApp sungguhan.
        |
        */

        if (
            $attendance
        ) {
            try {
                $whatsAppService
                    ->createAttendanceNotification(
                        $student,
                        $attendance
                    );

            } catch (\Throwable $e) {
                /*
                |--------------------------------------------------------------------------
                | JANGAN GAGALKAN PRESENSI
                |--------------------------------------------------------------------------
                |
                | Jika sistem WhatsApp bermasalah,
                | siswa tetap dianggap berhasil presensi.
                |
                */

                Log::error(
                    'Gagal membuat WhatsApp Notification setelah presensi.',
                    [
                        'student_id' =>
                            $student->id,

                        'nis' =>
                            $student->nis,

                        'attendance_id' =>
                            $attendance->id,

                        'error' =>
                            $e->getMessage(),
                    ]
                );
            }
        }


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
                $now->format(
                    'H:i'
                ),

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
        |--------------------------------------------------------------------------
        | RADIUS BUMI
        |--------------------------------------------------------------------------
        */

        $earthRadius =
            6371000;


        /*
        |--------------------------------------------------------------------------
        | KONVERSI KE RADIAN
        |--------------------------------------------------------------------------
        */

        $latFrom =
            deg2rad(
                $lat1
            );


        $lonFrom =
            deg2rad(
                $lon1
            );


        $latTo =
            deg2rad(
                $lat2
            );


        $lonTo =
            deg2rad(
                $lon2
            );


        /*
        |--------------------------------------------------------------------------
        | SELISIH
        |--------------------------------------------------------------------------
        */

        $latDelta =
            $latTo
            -
            $latFrom;


        $lonDelta =
            $lonTo
            -
            $lonFrom;


        /*
        |--------------------------------------------------------------------------
        | HAVERSINE
        |--------------------------------------------------------------------------
        */

        $a =
            sin(
                $latDelta
                /
                2
            ) ** 2

            +

            cos(
                $latFrom
            )

            *

            cos(
                $latTo
            )

            *

            sin(
                $lonDelta
                /
                2
            ) ** 2;


        $c =
            2

            *

            atan2(
                sqrt(
                    $a
                ),

                sqrt(
                    1
                    -
                    $a
                )
            );


        /*
        |--------------------------------------------------------------------------
        | HASIL METER
        |--------------------------------------------------------------------------
        */

        return
            $earthRadius
            *
            $c;
    }
}