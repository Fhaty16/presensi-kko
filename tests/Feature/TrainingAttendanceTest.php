<?php

use App\Models\Student;
use App\Models\TrainingAttendance;
use App\Models\TrainingBarcode;
use App\Models\TrainingSession;
use App\Models\User;
use App\Services\TrainingAttendanceService;
use App\Services\TrainingBarcodeService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


/*
|--------------------------------------------------------------------------
| HELPER: BUAT KELAS
|--------------------------------------------------------------------------
*/

function createTrainingTestClass(): int
{
    return DB::table('classes')
        ->insertGetId([
            'name' =>
                'XII KKO TEST',

            'grade' =>
                12,

            'academic_year' =>
                '2026/2027',

            'status' =>
                true,

            'created_at' =>
                now(),

            'updated_at' =>
                now(),
        ]);
}


/*
|--------------------------------------------------------------------------
| HELPER: BUAT SISWA
|--------------------------------------------------------------------------
*/

function createTrainingTestStudent(
    string $nis,
    string $sport = 'Atletik'
): array {

    /*
    |--------------------------------------------------------------------------
    | KELAS
    |--------------------------------------------------------------------------
    */

    $classId =
        createTrainingTestClass();


    /*
    |--------------------------------------------------------------------------
    | USER
    |--------------------------------------------------------------------------
    */

    $user =
        User::factory()
            ->siswa()
            ->create([
                'name' =>
                    'Siswa ' . $nis,

                'password' =>
                    Hash::make(
                        'password'
                    ),
            ]);


    /*
    |--------------------------------------------------------------------------
    | SISWA
    |--------------------------------------------------------------------------
    */

    $student =
        Student::create([
            'user_id' =>
                $user->id,

            'nis' =>
                $nis,

            'class_id' =>
                $classId,

            'sport' =>
                $sport,

            'status' =>
                'active',
        ]);


    /*
    |--------------------------------------------------------------------------
    | HASIL
    |--------------------------------------------------------------------------
    */

    return [
        $user,
        $student,
    ];
}


/*
|--------------------------------------------------------------------------
| HELPER: BUAT SESI
|--------------------------------------------------------------------------
*/

function createTrainingTestSession(
    string $date = '2026-09-05',
    string $startTime = '14:00:00',
    string $endTime = '16:00:00',
    string $sport = 'Atletik'
): TrainingSession {

    /*
    |--------------------------------------------------------------------------
    | GURU PEMBUAT SESI
    |--------------------------------------------------------------------------
    */

    $guru =
        User::factory()
            ->guru()
            ->create();


    /*
    |--------------------------------------------------------------------------
    | SESI LATIHAN
    |--------------------------------------------------------------------------
    */

    return TrainingSession::create([
        'training_date' =>
            $date,

        'sport' =>
            $sport,

        'location' =>
            'Lapangan Test',

        'start_time' =>
            $startTime,

        'end_time' =>
            $endTime,

        'notes' =>
            'Sesi test otomatis.',

        'created_by' =>
            $guru->id,
    ]);
}


/*
|--------------------------------------------------------------------------
| HELPER: BUAT QR
|--------------------------------------------------------------------------
*/

function createTrainingTestBarcode(
    TrainingSession $session,
    Carbon $expiredAt
): TrainingBarcode {

    return TrainingBarcode::create([
        'training_session_id' =>
            $session->id,

        'token' =>
            str_repeat(
                'A',
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
| HELPER: POST SCAN
|--------------------------------------------------------------------------
*/

function scanTrainingBarcode(
    $test,
    User $user,
    TrainingSession $session,
    TrainingBarcode $barcode
) {

    return $test
        ->actingAs(
            $user
        )
        ->postJson(
            route(
                'siswa.training.store'
            ),
            [
                'token' =>
                    $barcode->token,

                'training_session_id' =>
                    $session->id,
            ]
        );
}


/*
|--------------------------------------------------------------------------
| RESET TEST TIME
|--------------------------------------------------------------------------
*/

afterEach(function () {

    Carbon::setTestNow();
});


/*
|--------------------------------------------------------------------------
| TEPAT JAM MULAI = HADIR
|--------------------------------------------------------------------------
*/

test(
    'siswa is present when scanning exactly at training start time',
    function () {

        $now =
            Carbon::create(
                2026,
                9,
                5,
                14,
                0,
                0,
                'Asia/Jakarta'
            );


        Carbon::setTestNow(
            $now
        );


        [$user, $student] =
            createTrainingTestStudent(
                '1000000001'
            );


        $session =
            createTrainingTestSession();


        $barcode =
            createTrainingTestBarcode(
                $session,
                $now
                    ->copy()
                    ->addMinute()
            );


        $response =
            scanTrainingBarcode(
                $this,
                $user,
                $session,
                $barcode
            );


        $response
            ->assertOk()
            ->assertJson([
                'success' =>
                    true,

                'attendance' => [
                    'status' =>
                        'present',

                    'status_label' =>
                        'Hadir',
                ],
            ]);


        $this->assertDatabaseHas(
            'training_attendances',
            [
                'training_session_id' =>
                    $session->id,

                'student_id' =>
                    $student->id,

                'status' =>
                    'present',
            ]
        );
    }
);


/*
|--------------------------------------------------------------------------
| TEPAT +10 MENIT = HADIR
|--------------------------------------------------------------------------
*/

test(
    'siswa is still present exactly ten minutes after training starts',
    function () {

        $now =
            Carbon::create(
                2026,
                9,
                5,
                14,
                10,
                0,
                'Asia/Jakarta'
            );


        Carbon::setTestNow(
            $now
        );


        [$user, $student] =
            createTrainingTestStudent(
                '1000000002'
            );


        $session =
            createTrainingTestSession();


        $barcode =
            createTrainingTestBarcode(
                $session,
                $now
                    ->copy()
                    ->addMinute()
            );


        $response =
            scanTrainingBarcode(
                $this,
                $user,
                $session,
                $barcode
            );


        $response
            ->assertOk()
            ->assertJsonPath(
                'attendance.status',
                'present'
            );


        $this->assertDatabaseHas(
            'training_attendances',
            [
                'student_id' =>
                    $student->id,

                'training_session_id' =>
                    $session->id,

                'status' =>
                    'present',
            ]
        );
    }
);


/*
|--------------------------------------------------------------------------
| +10 MENIT 1 DETIK = TERLAMBAT
|--------------------------------------------------------------------------
*/

test(
    'siswa is late after ten minutes',
    function () {

        $now =
            Carbon::create(
                2026,
                9,
                5,
                14,
                10,
                1,
                'Asia/Jakarta'
            );


        Carbon::setTestNow(
            $now
        );


        [$user, $student] =
            createTrainingTestStudent(
                '1000000003'
            );


        $session =
            createTrainingTestSession();


        $barcode =
            createTrainingTestBarcode(
                $session,
                $now
                    ->copy()
                    ->addMinute()
            );


        $response =
            scanTrainingBarcode(
                $this,
                $user,
                $session,
                $barcode
            );


        $response
            ->assertOk()
            ->assertJsonPath(
                'attendance.status',
                'late'
            );


        $this->assertDatabaseHas(
            'training_attendances',
            [
                'student_id' =>
                    $student->id,

                'training_session_id' =>
                    $session->id,

                'status' =>
                    'late',
            ]
        );
    }
);


/*
|--------------------------------------------------------------------------
| TEPAT +30 MENIT = TERLAMBAT
|--------------------------------------------------------------------------
*/

test(
    'siswa can still scan exactly thirty minutes after training starts',
    function () {

        $now =
            Carbon::create(
                2026,
                9,
                5,
                14,
                30,
                0,
                'Asia/Jakarta'
            );


        Carbon::setTestNow(
            $now
        );


        [$user, $student] =
            createTrainingTestStudent(
                '1000000004'
            );


        $session =
            createTrainingTestSession();


        /*
        |--------------------------------------------------------------------------
        | GUNAKAN SERVICE QR ASLI
        |--------------------------------------------------------------------------
        |
        | Memastikan tepat +30 menit QR masih dapat digunakan.
        |
        */

        $barcodeData =
            app(
                TrainingBarcodeService::class
            )->getCurrent(
                $session
            );


        expect(
            $barcodeData['status']
        )->toBe(
            'active'
        );


        $barcode =
            TrainingBarcode::findOrFail(
                $barcodeData['barcode_id']
            );


        $response =
            scanTrainingBarcode(
                $this,
                $user,
                $session,
                $barcode
            );


        $response
            ->assertOk()
            ->assertJsonPath(
                'attendance.status',
                'late'
            );


        $this->assertDatabaseHas(
            'training_attendances',
            [
                'student_id' =>
                    $student->id,

                'training_session_id' =>
                    $session->id,

                'status' =>
                    'late',
            ]
        );
    }
);


/*
|--------------------------------------------------------------------------
| +30 MENIT 1 DETIK = DITOLAK
|--------------------------------------------------------------------------
*/

test(
    'siswa cannot scan after thirty minute attendance limit',
    function () {

        $now =
            Carbon::create(
                2026,
                9,
                5,
                14,
                30,
                1,
                'Asia/Jakarta'
            );


        Carbon::setTestNow(
            $now
        );


        [$user, $student] =
            createTrainingTestStudent(
                '1000000005'
            );


        $session =
            createTrainingTestSession();


        $barcode =
            createTrainingTestBarcode(
                $session,
                $now
                    ->copy()
                    ->addMinute()
            );


        $response =
            scanTrainingBarcode(
                $this,
                $user,
                $session,
                $barcode
            );


        $response
            ->assertStatus(
                422
            )
            ->assertJson([
                'success' =>
                    false,
            ]);


        $this->assertDatabaseMissing(
            'training_attendances',
            [
                'training_session_id' =>
                    $session->id,

                'student_id' =>
                    $student->id,
            ]
        );
    }
);


/*
|--------------------------------------------------------------------------
| CABANG BERBEDA = DITOLAK
|--------------------------------------------------------------------------
*/

test(
    'student cannot scan training session from another sport',
    function () {

        $now =
            Carbon::create(
                2026,
                9,
                5,
                14,
                5,
                0,
                'Asia/Jakarta'
            );


        Carbon::setTestNow(
            $now
        );


        [$user, $student] =
            createTrainingTestStudent(
                '1000000006',
                'Bola Basket'
            );


        $session =
            createTrainingTestSession(
                sport:
                    'Atletik'
            );


        $barcode =
            createTrainingTestBarcode(
                $session,
                $now
                    ->copy()
                    ->addMinute()
            );


        $response =
            scanTrainingBarcode(
                $this,
                $user,
                $session,
                $barcode
            );


        $response
            ->assertStatus(
                403
            )
            ->assertJson([
                'success' =>
                    false,
            ]);


        $this->assertDatabaseMissing(
            'training_attendances',
            [
                'training_session_id' =>
                    $session->id,

                'student_id' =>
                    $student->id,
            ]
        );
    }
);


/*
|--------------------------------------------------------------------------
| QR EXPIRED = DITOLAK
|--------------------------------------------------------------------------
*/

test(
    'expired training barcode cannot be used',
    function () {

        $now =
            Carbon::create(
                2026,
                9,
                5,
                14,
                5,
                0,
                'Asia/Jakarta'
            );


        Carbon::setTestNow(
            $now
        );


        [$user] =
            createTrainingTestStudent(
                '1000000007'
            );


        $session =
            createTrainingTestSession();


        $barcode =
            createTrainingTestBarcode(
                $session,
                $now
                    ->copy()
                    ->subSecond()
            );


        $response =
            scanTrainingBarcode(
                $this,
                $user,
                $session,
                $barcode
            );


        $response
            ->assertStatus(
                422
            )
            ->assertJson([
                'success' =>
                    false,
            ]);


        expect(
            $barcode
                ->fresh()
                ->is_active
        )->toBeFalse();
    }
);


/*
|--------------------------------------------------------------------------
| PRESENSI EXISTING TIDAK BOLEH DITIMPA
|--------------------------------------------------------------------------
*/

test(
    'existing absence cannot be overwritten by barcode scan',
    function () {

        $now =
            Carbon::create(
                2026,
                9,
                5,
                14,
                5,
                0,
                'Asia/Jakarta'
            );


        Carbon::setTestNow(
            $now
        );


        [$user, $student] =
            createTrainingTestStudent(
                '1000000008'
            );


        $session =
            createTrainingTestSession();


        TrainingAttendance::create([
            'training_session_id' =>
                $session->id,

            'student_id' =>
                $student->id,

            'status' =>
                'absent',

            'checked_in_at' =>
                null,

            'notes' =>
                'Alfa test.',
        ]);


        $barcode =
            createTrainingTestBarcode(
                $session,
                $now
                    ->copy()
                    ->addMinute()
            );


        $response =
            scanTrainingBarcode(
                $this,
                $user,
                $session,
                $barcode
            );


        $response
            ->assertStatus(
                422
            )
            ->assertJsonPath(
                'attendance.status',
                'absent'
            );


        $this->assertDatabaseHas(
            'training_attendances',
            [
                'student_id' =>
                    $student->id,

                'training_session_id' =>
                    $session->id,

                'status' =>
                    'absent',
            ]
        );


        expect(
            TrainingAttendance::where(
                'training_session_id',
                $session->id
            )
                ->where(
                    'student_id',
                    $student->id
                )
                ->count()
        )->toBe(
            1
        );
    }
);


/*
|--------------------------------------------------------------------------
| AUTO ALFA HANYA CABANG YANG SESUAI
|--------------------------------------------------------------------------
*/

test(
    'automatic absence only marks active students from matching sport',
    function () {

        $now =
            Carbon::create(
                2026,
                9,
                5,
                14,
                30,
                1,
                'Asia/Jakarta'
            );


        Carbon::setTestNow(
            $now
        );


        [, $atletikStudent] =
            createTrainingTestStudent(
                '1000000009',
                'Atletik'
            );


        [, $basketStudent] =
            createTrainingTestStudent(
                '1000000010',
                'Bola Basket'
            );


        $session =
            createTrainingTestSession(
                sport:
                    'Atletik'
            );


        $createdCount =
            app(
                TrainingAttendanceService::class
            )->markAutomaticAbsencesIfDue(
                $session
            );


        expect(
            $createdCount
        )->toBe(
            1
        );


        $this->assertDatabaseHas(
            'training_attendances',
            [
                'training_session_id' =>
                    $session->id,

                'student_id' =>
                    $atletikStudent->id,

                'status' =>
                    'absent',
            ]
        );


        $this->assertDatabaseMissing(
            'training_attendances',
            [
                'training_session_id' =>
                    $session->id,

                'student_id' =>
                    $basketStudent->id,
            ]
        );
    }
);


/*
|--------------------------------------------------------------------------
| HADIR TIDAK BOLEH MENJADI ALFA
|--------------------------------------------------------------------------
*/

test(
    'automatic absence does not overwrite existing attendance',
    function () {

        $now =
            Carbon::create(
                2026,
                9,
                5,
                14,
                30,
                1,
                'Asia/Jakarta'
            );


        Carbon::setTestNow(
            $now
        );


        [, $student] =
            createTrainingTestStudent(
                '1000000011',
                'Atletik'
            );


        $session =
            createTrainingTestSession(
                sport:
                    'Atletik'
            );


        TrainingAttendance::create([
            'training_session_id' =>
                $session->id,

            'student_id' =>
                $student->id,

            'status' =>
                'present',

            'checked_in_at' =>
                Carbon::create(
                    2026,
                    9,
                    5,
                    14,
                    5,
                    0,
                    'Asia/Jakarta'
                ),

            'notes' =>
                'Presensi test.',
        ]);


        $createdCount =
            app(
                TrainingAttendanceService::class
            )->markAutomaticAbsencesIfDue(
                $session
            );


        expect(
            $createdCount
        )->toBe(
            0
        );


        $this->assertDatabaseHas(
            'training_attendances',
            [
                'training_session_id' =>
                    $session->id,

                'student_id' =>
                    $student->id,

                'status' =>
                    'present',
            ]
        );


        expect(
            TrainingAttendance::where(
                'training_session_id',
                $session->id
            )
                ->where(
                    'student_id',
                    $student->id
                )
                ->count()
        )->toBe(
            1
        );
    }
);


/*
|--------------------------------------------------------------------------
| QR HANYA BOLEH DIGUNAKAN SEKALI
|--------------------------------------------------------------------------
|
| Setelah siswa pertama menggunakan QR:
|
| is_active = false
| used_by_student_id = siswa pertama
| used_at terisi
|
| QR yang sama tidak boleh digunakan siswa lain.
|
*/

test(
    'training barcode can only be used once',
    function () {

        $now =
            Carbon::create(
                2026,
                9,
                5,
                14,
                5,
                0,
                'Asia/Jakarta'
            );


        Carbon::setTestNow(
            $now
        );


        /*
        |--------------------------------------------------------------------------
        | SISWA PERTAMA
        |--------------------------------------------------------------------------
        */

        [$firstUser, $firstStudent] =
            createTrainingTestStudent(
                '1000000012',
                'Atletik'
            );


        /*
        |--------------------------------------------------------------------------
        | SISWA KEDUA
        |--------------------------------------------------------------------------
        */

        [$secondUser, $secondStudent] =
            createTrainingTestStudent(
                '1000000013',
                'Atletik'
            );


        /*
        |--------------------------------------------------------------------------
        | SESI
        |--------------------------------------------------------------------------
        */

        $session =
            createTrainingTestSession(
                sport:
                    'Atletik'
            );


        /*
        |--------------------------------------------------------------------------
        | QR
        |--------------------------------------------------------------------------
        */

        $barcode =
            createTrainingTestBarcode(
                $session,
                $now
                    ->copy()
                    ->addMinute()
            );


        /*
        |--------------------------------------------------------------------------
        | SISWA PERTAMA SCAN
        |--------------------------------------------------------------------------
        */

        $firstResponse =
            scanTrainingBarcode(
                $this,
                $firstUser,
                $session,
                $barcode
            );


        $firstResponse
            ->assertOk()
            ->assertJsonPath(
                'attendance.status',
                'present'
            );


        /*
        |--------------------------------------------------------------------------
        | CEK QR SUDAH TERPAKAI
        |--------------------------------------------------------------------------
        */

        $usedBarcode =
            $barcode->fresh();


        expect(
            $usedBarcode->is_active
        )->toBeFalse();


        expect(
            $usedBarcode->used_by_student_id
        )->toBe(
            $firstStudent->id
        );


        expect(
            $usedBarcode->used_at
        )->not->toBeNull();


        /*
        |--------------------------------------------------------------------------
        | SISWA KEDUA COBA QR YANG SAMA
        |--------------------------------------------------------------------------
        */

        $secondResponse =
            scanTrainingBarcode(
                $this,
                $secondUser,
                $session,
                $usedBarcode
            );


        $secondResponse
            ->assertStatus(
                422
            )
            ->assertJson([
                'success' =>
                    false,

                'message' =>
                    'QR ini sudah digunakan. Scan QR terbaru.',
            ]);


        /*
        |--------------------------------------------------------------------------
        | SISWA KEDUA TIDAK BOLEH TERCATAT
        |--------------------------------------------------------------------------
        */

        $this->assertDatabaseMissing(
            'training_attendances',
            [
                'training_session_id' =>
                    $session->id,

                'student_id' =>
                    $secondStudent->id,
            ]
        );
    }
);


/*
|--------------------------------------------------------------------------
| SISWA TIDAK BOLEH PRESENSI DUA KALI
|--------------------------------------------------------------------------
|
| Walaupun mendapatkan QR baru,
| siswa yang sudah memiliki presensi pada sesi yang sama
| tidak boleh membuat presensi kedua.
|
*/

test(
    'student cannot submit training attendance twice',
    function () {

        $now =
            Carbon::create(
                2026,
                9,
                5,
                14,
                5,
                0,
                'Asia/Jakarta'
            );


        Carbon::setTestNow(
            $now
        );


        /*
        |--------------------------------------------------------------------------
        | SISWA
        |--------------------------------------------------------------------------
        */

        [$user, $student] =
            createTrainingTestStudent(
                '1000000014',
                'Atletik'
            );


        /*
        |--------------------------------------------------------------------------
        | SESI
        |--------------------------------------------------------------------------
        */

        $session =
            createTrainingTestSession(
                sport:
                    'Atletik'
            );


        /*
        |--------------------------------------------------------------------------
        | QR PERTAMA
        |--------------------------------------------------------------------------
        */

        $firstBarcode =
            createTrainingTestBarcode(
                $session,
                $now
                    ->copy()
                    ->addMinute()
            );


        /*
        |--------------------------------------------------------------------------
        | PRESENSI PERTAMA
        |--------------------------------------------------------------------------
        */

        $firstResponse =
            scanTrainingBarcode(
                $this,
                $user,
                $session,
                $firstBarcode
            );


        $firstResponse
            ->assertOk()
            ->assertJsonPath(
                'attendance.status',
                'present'
            );


        /*
        |--------------------------------------------------------------------------
        | QR KEDUA
        |--------------------------------------------------------------------------
        */

        $secondBarcode =
            TrainingBarcode::create([
                'training_session_id' =>
                    $session->id,

                'token' =>
                    str_repeat(
                        'B',
                        64
                    ),

                'expired_at' =>
                    $now
                        ->copy()
                        ->addMinute(),

                'is_active' =>
                    true,

                'used_by_student_id' =>
                    null,

                'used_at' =>
                    null,
            ]);


        /*
        |--------------------------------------------------------------------------
        | PRESENSI KEDUA HARUS DITOLAK
        |--------------------------------------------------------------------------
        */

        $secondResponse =
            scanTrainingBarcode(
                $this,
                $user,
                $session,
                $secondBarcode
            );


        $secondResponse
            ->assertStatus(
                422
            )
            ->assertJson([
                'success' =>
                    false,
            ])
            ->assertJsonPath(
                'attendance.status',
                'present'
            );


        /*
        |--------------------------------------------------------------------------
        | HANYA SATU RECORD
        |--------------------------------------------------------------------------
        */

        expect(
            TrainingAttendance::where(
                'training_session_id',
                $session->id
            )
                ->where(
                    'student_id',
                    $student->id
                )
                ->count()
        )->toBe(
            1
        );


        $this->assertDatabaseHas(
            'training_attendances',
            [
                'training_session_id' =>
                    $session->id,

                'student_id' =>
                    $student->id,

                'status' =>
                    'present',
            ]
        );
    }
);


/*
|--------------------------------------------------------------------------
| SISWA INACTIVE TIDAK BOLEH AUTO ALFA
|--------------------------------------------------------------------------
|
| Auto Alfa hanya berlaku untuk siswa:
|
| status = active
|
*/

test(
    'inactive student is not marked automatically absent',
    function () {

        $now =
            Carbon::create(
                2026,
                9,
                5,
                14,
                30,
                1,
                'Asia/Jakarta'
            );


        Carbon::setTestNow(
            $now
        );


        /*
        |--------------------------------------------------------------------------
        | SISWA
        |--------------------------------------------------------------------------
        */

        [, $student] =
            createTrainingTestStudent(
                '1000000015',
                'Atletik'
            );


        /*
        |--------------------------------------------------------------------------
        | NONAKTIFKAN SISWA
        |--------------------------------------------------------------------------
        */

        $student->update([
            'status' =>
                'inactive',
        ]);


        /*
        |--------------------------------------------------------------------------
        | SESI
        |--------------------------------------------------------------------------
        */

        $session =
            createTrainingTestSession(
                sport:
                    'Atletik'
            );


        /*
        |--------------------------------------------------------------------------
        | AUTO ALFA
        |--------------------------------------------------------------------------
        */

        $createdCount =
            app(
                TrainingAttendanceService::class
            )->markAutomaticAbsencesIfDue(
                $session
            );


        /*
        |--------------------------------------------------------------------------
        | TIDAK BOLEH DIBUAT
        |--------------------------------------------------------------------------
        */

        expect(
            $createdCount
        )->toBe(
            0
        );


        $this->assertDatabaseMissing(
            'training_attendances',
            [
                'training_session_id' =>
                    $session->id,

                'student_id' =>
                    $student->id,
            ]
        );
    }
);


/*
|--------------------------------------------------------------------------
| BATAS AUTO ALFA HARUS TEPAT
|--------------------------------------------------------------------------
|
| Mulai:
|
| 14:00:00
|
| Tepat:
|
| 14:30:00
|
| belum Alfa.
|
| Pada:
|
| 14:30:01
|
| baru boleh diproses Auto Alfa.
|
*/

test(
    'automatic absence starts only after thirty minute limit',
    function () {

        /*
        |--------------------------------------------------------------------------
        | TEPAT +30 MENIT
        |--------------------------------------------------------------------------
        */

        $exactLimit =
            Carbon::create(
                2026,
                9,
                5,
                14,
                30,
                0,
                'Asia/Jakarta'
            );


        Carbon::setTestNow(
            $exactLimit
        );


        /*
        |--------------------------------------------------------------------------
        | SISWA
        |--------------------------------------------------------------------------
        */

        [, $student] =
            createTrainingTestStudent(
                '1000000016',
                'Atletik'
            );


        /*
        |--------------------------------------------------------------------------
        | SESI
        |--------------------------------------------------------------------------
        */

        $session =
            createTrainingTestSession(
                sport:
                    'Atletik'
            );


        /*
        |--------------------------------------------------------------------------
        | SERVICE
        |--------------------------------------------------------------------------
        */

        $service =
            app(
                TrainingAttendanceService::class
            );


        /*
        |--------------------------------------------------------------------------
        | TEPAT +30 MENIT BELUM ALFA
        |--------------------------------------------------------------------------
        */

        expect(
            $service
                ->isAutomaticAbsentDue(
                    $session
                )
        )->toBeFalse();


        $createdAtExactLimit =
            $service
                ->markAutomaticAbsencesIfDue(
                    $session
                );


        expect(
            $createdAtExactLimit
        )->toBe(
            0
        );


        $this->assertDatabaseMissing(
            'training_attendances',
            [
                'training_session_id' =>
                    $session->id,

                'student_id' =>
                    $student->id,
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | MAJU SATU DETIK
        |--------------------------------------------------------------------------
        */

        Carbon::setTestNow(
            $exactLimit
                ->copy()
                ->addSecond()
        );


        /*
        |--------------------------------------------------------------------------
        | SEKARANG AUTO ALFA SUDAH DUE
        |--------------------------------------------------------------------------
        */

        expect(
            $service
                ->isAutomaticAbsentDue(
                    $session
                )
        )->toBeTrue();


        /*
        |--------------------------------------------------------------------------
        | PROSES AUTO ALFA
        |--------------------------------------------------------------------------
        */

        $createdAfterLimit =
            $service
                ->markAutomaticAbsencesIfDue(
                    $session
                );


        expect(
            $createdAfterLimit
        )->toBe(
            1
        );


        /*
        |--------------------------------------------------------------------------
        | CEK DATABASE
        |--------------------------------------------------------------------------
        */

        $this->assertDatabaseHas(
            'training_attendances',
            [
                'training_session_id' =>
                    $session->id,

                'student_id' =>
                    $student->id,

                'status' =>
                    'absent',

                'notes' =>
                    TrainingAttendanceService::AUTO_ABSENT_NOTE,
            ]
        );
    }
);