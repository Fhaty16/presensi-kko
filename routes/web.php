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

        $user = auth()->user();

        return match ($user->role) {

            'guru' =>
                redirect()
                    ->route('guru.dashboard'),

            'siswa' =>
                redirect()
                    ->route('siswa.dashboard'),

            'pelatih' =>
                redirect()
                    ->route('pelatih.dashboard'),

            default =>
                abort(403),
        };

    })
    ->name('dashboard');


/*
|--------------------------------------------------------------------------
| GURU
|--------------------------------------------------------------------------
*/

Route::middleware([
        'auth',
        'role:guru',
    ])
    ->prefix('guru')
    ->name('guru.')
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
        ->name('dashboard');


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
        ->name('attendance.manual');


        Route::post(
            '/presensi/manual',
            [
                ManualAttendanceController::class,
                'store',
            ]
        )
        ->name('attendance.manual.store');


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
        ->name('attendance.recap');


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
        ->name('attendance.monthly');


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
        ->name('leave.index');


        Route::post(
            '/pengajuan-izin/{leaveRequest}/approve',
            [
                GuruLeaveRequestController::class,
                'approve',
            ]
        )
        ->name('leave.approve');


        Route::post(
            '/pengajuan-izin/{leaveRequest}/reject',
            [
                GuruLeaveRequestController::class,
                'reject',
            ]
        )
        ->name('leave.reject');
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
    ->prefix('siswa')
    ->name('siswa.')
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
        ->name('dashboard');


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
        ->name('presensi.scan');


        Route::post(
            '/presensi/scan',
            [
                SiswaAttendanceController::class,
                'store',
            ]
        )
        ->name('presensi.store');


        /*
        |--------------------------------------------------------------------------
        | JADWAL LATIHAN KKO
        |--------------------------------------------------------------------------
        |
        | Halaman daftar jadwal latihan untuk siswa.
        |
        | URL:
        | /siswa/latihan
        |
        */

        Route::get(
            '/latihan',
            [
                TrainingScanController::class,
                'index',
            ]
        )
        ->name('training.index');


        /*
        |--------------------------------------------------------------------------
        | SCANNER PRESENSI LATIHAN
        |--------------------------------------------------------------------------
        |
        | Dibuka dari jadwal latihan.
        |
        | Contoh:
        | /siswa/latihan/scan?session=3
        |
        */

        Route::get(
            '/latihan/scan',
            [
                TrainingScanController::class,
                'scanner',
            ]
        )
        ->name('training.scan');


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
        ->name('training.store');


        /*
        |--------------------------------------------------------------------------
        | RIWAYAT PRESENSI SEKOLAH
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/riwayat-presensi',
            [
                AttendanceHistoryController::class,
                'index',
            ]
        )
        ->name('attendance.history');


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
        ->name('leave.create');


        Route::post(
            '/izin',
            [
                SiswaLeaveRequestController::class,
                'store',
            ]
        )
        ->name('leave.store');
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
    ->prefix('pelatih')
    ->name('pelatih.')
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
        ->name('dashboard');
    });


/*
|--------------------------------------------------------------------------
| PENGELOLAAN KEHADIRAN LATIHAN
|--------------------------------------------------------------------------
|
| Digunakan oleh Guru dan Pelatih.
|
| Role tetap diperiksa di:
|
| - TrainingController
| - TrainingBarcodeController
|
*/

Route::middleware('auth')
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
        ->name('training.index');


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
        ->name('training.create');


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
        ->name('training.store');


        /*
        |--------------------------------------------------------------------------
        | BARCODE PRESENSI LATIHAN
        |--------------------------------------------------------------------------
        |
        | Setiap sesi latihan mempunyai QR sendiri.
        |
        | Contoh:
        |
        | /latihan/1/barcode
        |
        */

        Route::get(
            '/latihan/{trainingSession}/barcode',
            [
                TrainingBarcodeController::class,
                'show',
            ]
        )
        ->name('training.barcode.display');


        /*
        |--------------------------------------------------------------------------
        | TOKEN BARCODE LATIHAN AKTIF
        |--------------------------------------------------------------------------
        |
        | Dipanggil oleh JavaScript halaman barcode.
        |
        */

        Route::get(
            '/latihan/{trainingSession}/barcode/current',
            [
                TrainingBarcodeController::class,
                'current',
            ]
        )
        ->name('training.barcode.current');


        /*
        |--------------------------------------------------------------------------
        | DETAIL SESI LATIHAN
        |--------------------------------------------------------------------------
        |
        | Route parameter harus berada setelah:
        |
        | /latihan/buat
        | /latihan/{trainingSession}/barcode
        | /latihan/{trainingSession}/barcode/current
        |
        */

        Route::get(
            '/latihan/{trainingSession}',
            [
                TrainingController::class,
                'show',
            ]
        )
        ->name('training.show');
    });


/*
|--------------------------------------------------------------------------
| BARCODE PRESENSI MASUK SEKOLAH
|--------------------------------------------------------------------------
|
| Barcode ini khusus presensi masuk sekolah.
|
| Tidak digunakan untuk presensi latihan.
|
*/

Route::middleware('auth')
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
        ->name('barcode.display');


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
        ->name('barcode.current');
    });


/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';