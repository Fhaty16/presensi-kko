<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| CONTROLLER GURU
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Guru\LeaveRequestController as GuruLeaveRequestController;
use App\Http\Controllers\Guru\AttendanceRecapController;
use App\Http\Controllers\Guru\MonthlyAttendanceRecapController;
use App\Http\Controllers\Guru\ManualAttendanceController;


/*
|--------------------------------------------------------------------------
| CONTROLLER SISWA
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Siswa\AttendanceController as SiswaAttendanceController;
use App\Http\Controllers\Siswa\LeaveRequestController as SiswaLeaveRequestController;
use App\Http\Controllers\Siswa\AttendanceHistoryController;
use App\Http\Controllers\Siswa\TrainingScanController;


/*
|--------------------------------------------------------------------------
| CONTROLLER PELATIH
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Pelatih\DashboardController as PelatihDashboardController;


/*
|--------------------------------------------------------------------------
| CONTROLLER UMUM
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\BarcodeDisplayController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\TrainingBarcodeController;
use App\Http\Controllers\StudentSportController;
use App\Http\Controllers\TrainingAttendanceRecapExportController;


/*
|--------------------------------------------------------------------------
| HALAMAN UTAMA
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    return redirect()
        ->route('login');

});


/*
|--------------------------------------------------------------------------
| REDIRECT DASHBOARD BERDASARKAN ROLE
|--------------------------------------------------------------------------
*/

Route::middleware('auth')
    ->get('/dashboard', function () {

        $user =
            auth()->user();

        return match ($user->role) {

            'guru' =>
                redirect()
                    ->route(
                        'guru.dashboard'
                    ),

            'siswa' =>
                redirect()
                    ->route(
                        'siswa.dashboard'
                    ),

            'pelatih' =>
                redirect()
                    ->route(
                        'pelatih.dashboard'
                    ),

            default =>
                abort(
                    403
                ),

        };

    })
    ->name(
        'dashboard'
    );


/*
|--------------------------------------------------------------------------
| GURU
|--------------------------------------------------------------------------
*/

Route::middleware([
        'auth',
        'role:guru',
    ])
    ->prefix(
        'guru'
    )
    ->name(
        'guru.'
    )
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/dashboard',
            [
                GuruDashboardController::class,
                'index',
            ]
        )
        ->name(
            'dashboard'
        );


        /*
        |--------------------------------------------------------------------------
        | INPUT MANUAL PRESENSI SEKOLAH
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/presensi/manual',
            [
                ManualAttendanceController::class,
                'index',
            ]
        )
        ->name(
            'attendance.manual'
        );


        Route::post(
            '/presensi/manual',
            [
                ManualAttendanceController::class,
                'store',
            ]
        )
        ->name(
            'attendance.manual.store'
        );


        /*
        |--------------------------------------------------------------------------
        | REKAP PRESENSI HARIAN
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/rekap-presensi',
            [
                AttendanceRecapController::class,
                'index',
            ]
        )
        ->name(
            'attendance.recap'
        );


        /*
        |--------------------------------------------------------------------------
        | REKAP PRESENSI BULANAN
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/rekap-presensi/bulanan',
            [
                MonthlyAttendanceRecapController::class,
                'index',
            ]
        )
        ->name(
            'attendance.monthly'
        );


        /*
        |--------------------------------------------------------------------------
        | PENGAJUAN IZIN / SAKIT
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/pengajuan-izin',
            [
                GuruLeaveRequestController::class,
                'index',
            ]
        )
        ->name(
            'leave.index'
        );


        Route::post(
            '/pengajuan-izin/{leaveRequest}/approve',
            [
                GuruLeaveRequestController::class,
                'approve',
            ]
        )
        ->name(
            'leave.approve'
        );


        Route::post(
            '/pengajuan-izin/{leaveRequest}/reject',
            [
                GuruLeaveRequestController::class,
                'reject',
            ]
        )
        ->name(
            'leave.reject'
        );

    });


/*
|--------------------------------------------------------------------------
| SISWA
|--------------------------------------------------------------------------
*/

Route::middleware([
        'auth',
        'role:siswa',
    ])
    ->prefix(
        'siswa'
    )
    ->name(
        'siswa.'
    )
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/dashboard',
            [
                SiswaDashboardController::class,
                'index',
            ]
        )
        ->name(
            'dashboard'
        );


        /*
        |--------------------------------------------------------------------------
        | PRESENSI MASUK SEKOLAH
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/presensi/scan',
            [
                SiswaAttendanceController::class,
                'scanner',
            ]
        )
        ->name(
            'presensi.scan'
        );


        Route::post(
            '/presensi/scan',
            [
                SiswaAttendanceController::class,
                'store',
            ]
        )
        ->name(
            'presensi.store'
        );


        /*
        |--------------------------------------------------------------------------
        | JADWAL LATIHAN KKO
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/latihan',
            [
                TrainingScanController::class,
                'index',
            ]
        )
        ->name(
            'training.index'
        );


        /*
        |--------------------------------------------------------------------------
        | SCANNER PRESENSI LATIHAN
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/latihan/scan',
            [
                TrainingScanController::class,
                'scanner',
            ]
        )
        ->name(
            'training.scan'
        );


        /*
        |--------------------------------------------------------------------------
        | PROSES SCAN PRESENSI LATIHAN
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/latihan/scan',
            [
                TrainingScanController::class,
                'store',
            ]
        )
        ->name(
            'training.store'
        );


        /*
        |--------------------------------------------------------------------------
        | RIWAYAT PRESENSI SISWA
        |--------------------------------------------------------------------------
        |
        | Satu halaman untuk:
        |
        | - Presensi Sekolah
        | - Presensi Latihan KKO
        |
        | Sekolah:
        |
        | /siswa/riwayat-presensi?type=school
        |
        | Latihan:
        |
        | /siswa/riwayat-presensi?type=training
        |
        */

        Route::get(
            '/riwayat-presensi',
            [
                AttendanceHistoryController::class,
                'index',
            ]
        )
        ->name(
            'attendance.history'
        );


        /*
        |--------------------------------------------------------------------------
        | IZIN / SAKIT
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/izin',
            [
                SiswaLeaveRequestController::class,
                'create',
            ]
        )
        ->name(
            'leave.create'
        );


        Route::post(
            '/izin',
            [
                SiswaLeaveRequestController::class,
                'store',
            ]
        )
        ->name(
            'leave.store'
        );

    });


/*
|--------------------------------------------------------------------------
| PELATIH
|--------------------------------------------------------------------------
*/

Route::middleware([
        'auth',
        'role:pelatih',
    ])
    ->prefix(
        'pelatih'
    )
    ->name(
        'pelatih.'
    )
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/dashboard',
            [
                PelatihDashboardController::class,
                'index',
            ]
        )
        ->name(
            'dashboard'
        );

    });


/*
|--------------------------------------------------------------------------
| PENGELOLAAN KEHADIRAN LATIHAN
|--------------------------------------------------------------------------
|
| Digunakan oleh Guru dan Pelatih.
|
*/

Route::middleware(
    'auth'
)
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | DAFTAR SESI LATIHAN
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/latihan',
            [
                TrainingController::class,
                'index',
            ]
        )
        ->name(
            'training.index'
        );


        /*
        |--------------------------------------------------------------------------
        | BUAT SESI LATIHAN
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/latihan/buat',
            [
                TrainingController::class,
                'create',
            ]
        )
        ->name(
            'training.create'
        );


        /*
        |--------------------------------------------------------------------------
        | SIMPAN SESI LATIHAN
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/latihan',
            [
                TrainingController::class,
                'store',
            ]
        )
        ->name(
            'training.store'
        );


        /*
        |--------------------------------------------------------------------------
        | EDIT SESI LATIHAN
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/latihan/{trainingSession}/edit',
            [
                TrainingController::class,
                'edit',
            ]
        )
        ->name(
            'training.edit'
        );


        /*
        |--------------------------------------------------------------------------
        | UPDATE SESI LATIHAN
        |--------------------------------------------------------------------------
        */

        Route::put(
            '/latihan/{trainingSession}',
            [
                TrainingController::class,
                'update',
            ]
        )
        ->name(
            'training.update'
        );


        /*
        |--------------------------------------------------------------------------
        | HAPUS SESI LATIHAN
        |--------------------------------------------------------------------------
        */

        Route::delete(
            '/latihan/{trainingSession}',
            [
                TrainingController::class,
                'destroy',
            ]
        )
        ->name(
            'training.destroy'
        );


        /*
        |--------------------------------------------------------------------------
        | BARCODE PRESENSI LATIHAN
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/latihan/{trainingSession}/barcode',
            [
                TrainingBarcodeController::class,
                'show',
            ]
        )
        ->name(
            'training.barcode.display'
        );


        /*
        |--------------------------------------------------------------------------
        | TOKEN BARCODE LATIHAN AKTIF
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/latihan/{trainingSession}/barcode/current',
            [
                TrainingBarcodeController::class,
                'current',
            ]
        )
        ->name(
            'training.barcode.current'
        );


        /*
        |--------------------------------------------------------------------------
        | UPDATE STATUS PRESENSI LATIHAN
        |--------------------------------------------------------------------------
        */

        Route::put(
            '/latihan/{trainingSession}/siswa/{student}/status',
            [
                TrainingController::class,
                'updateStudentStatus',
            ]
        )
        ->name(
            'training.student.status'
        );


        /*
        |--------------------------------------------------------------------------
        | HAPUS STATUS PRESENSI LATIHAN
        |--------------------------------------------------------------------------
        */

        Route::delete(
            '/latihan/{trainingSession}/siswa/{student}/status',
            [
                TrainingController::class,
                'clearStudentStatus',
            ]
        )
        ->name(
            'training.student.status.clear'
        );


        /*
        |--------------------------------------------------------------------------
        | DETAIL SESI LATIHAN
        |--------------------------------------------------------------------------
        |
        | Route parameter umum diletakkan paling bawah.
        |
        */

        Route::get(
            '/latihan/{trainingSession}',
            [
                TrainingController::class,
                'show',
            ]
        )
        ->name(
            'training.show'
        );

    });


/*
|--------------------------------------------------------------------------
| DATA CABANG OLAHRAGA SISWA
|--------------------------------------------------------------------------
|
| Digunakan Guru dan Pelatih untuk:
|
| - Melihat cabang olahraga siswa
| - Mengubah cabang olahraga siswa
| - Melihat rekap presensi latihan
| - Melihat detail presensi siswa
| - Export rekap presensi latihan ke Excel
|
*/

Route::middleware(
    'auth'
)
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | DAFTAR SISWA & CABANG OLAHRAGA
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/data-cabang-siswa',
            [
                StudentSportController::class,
                'index',
            ]
        )
        ->name(
            'students.sports.index'
        );


        /*
        |--------------------------------------------------------------------------
        | EXPORT REKAP PRESENSI LATIHAN KE EXCEL
        |--------------------------------------------------------------------------
        |
        | Contoh:
        |
        | /data-cabang-siswa/export
        | ?sport=Atletik
        | &month=8
        | &year=2026
        |
        | Route ini HARUS berada sebelum route {student}.
        |
        */

        Route::get(
            '/data-cabang-siswa/export',
            TrainingAttendanceRecapExportController::class
        )
        ->name(
            'students.sports.export'
        );


        /*
        |--------------------------------------------------------------------------
        | DETAIL RIWAYAT PRESENSI SISWA
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/data-cabang-siswa/{student}/riwayat-presensi',
            [
                StudentSportController::class,
                'attendanceDetail',
            ]
        )
        ->name(
            'students.sports.attendance-detail'
        );


        /*
        |--------------------------------------------------------------------------
        | UPDATE CABANG OLAHRAGA SISWA
        |--------------------------------------------------------------------------
        */

        Route::put(
            '/data-cabang-siswa/{student}',
            [
                StudentSportController::class,
                'update',
            ]
        )
        ->name(
            'students.sports.update'
        );

    });


/*
|--------------------------------------------------------------------------
| BARCODE PRESENSI MASUK SEKOLAH
|--------------------------------------------------------------------------
|
| Barcode ini khusus untuk presensi sekolah.
| Tidak digunakan untuk presensi latihan.
|
*/

Route::middleware(
    'auth'
)
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | HALAMAN BARCODE SEKOLAH
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/barcode',
            [
                BarcodeDisplayController::class,
                'index',
            ]
        )
        ->name(
            'barcode.display'
        );


        /*
        |--------------------------------------------------------------------------
        | TOKEN BARCODE SEKOLAH AKTIF
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/barcode/current',
            [
                BarcodeDisplayController::class,
                'current',
            ]
        )
        ->name(
            'barcode.current'
        );

    });


/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';