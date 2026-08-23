<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Guru\LeaveRequestController as GuruLeaveRequestController;
use App\Http\Controllers\Guru\AttendanceRecapController;
use App\Http\Controllers\Guru\ManualAttendanceController;

use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Siswa\AttendanceController as SiswaAttendanceController;
use App\Http\Controllers\Siswa\LeaveRequestController as SiswaLeaveRequestController;
use App\Http\Controllers\Siswa\AttendanceHistoryController;

use App\Http\Controllers\Pelatih\DashboardController as PelatihDashboardController;

use App\Http\Controllers\BarcodeDisplayController;


/*
|--------------------------------------------------------------------------
| HALAMAN UTAMA
|--------------------------------------------------------------------------
|
| Saat membuka website, user diarahkan ke halaman login.
|
*/

Route::get('/', function () {

    return redirect()
        ->route('login');

});


/*
|--------------------------------------------------------------------------
| REDIRECT DASHBOARD BERDASARKAN ROLE
|--------------------------------------------------------------------------
|
| Guru    -> /guru/dashboard
| Siswa   -> /siswa/dashboard
| Pelatih -> /pelatih/dashboard
|
*/

Route::middleware('auth')
    ->get('/dashboard', function () {

        $user = auth()->user();


        if ($user->role === 'guru') {

            return redirect()
                ->route('guru.dashboard');

        }


        if ($user->role === 'siswa') {

            return redirect()
                ->route('siswa.dashboard');

        }


        if ($user->role === 'pelatih') {

            return redirect()
                ->route('pelatih.dashboard');

        }


        abort(403);

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
        | DASHBOARD GURU
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
        | REKAP PRESENSI
        |--------------------------------------------------------------------------
        |
        | Menampilkan rekap presensi seluruh siswa berdasarkan tanggal.
        |
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
        | INPUT MANUAL PRESENSI
        |--------------------------------------------------------------------------
        |
        | Halaman untuk Guru mencatat atau mengubah presensi siswa.
        |
        */

        Route::get(
            '/presensi/manual',
            [
                ManualAttendanceController::class,
                'index',
            ]
        )
        ->name('attendance.manual');


        /*
        |--------------------------------------------------------------------------
        | SIMPAN INPUT MANUAL PRESENSI
        |--------------------------------------------------------------------------
        */

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
        | DAFTAR PENGAJUAN IZIN / SAKIT
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


        /*
        |--------------------------------------------------------------------------
        | SETUJUI PENGAJUAN
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/pengajuan-izin/{leaveRequest}/approve',
            [
                GuruLeaveRequestController::class,
                'approve',
            ]
        )
        ->name('leave.approve');


        /*
        |--------------------------------------------------------------------------
        | TOLAK PENGAJUAN
        |--------------------------------------------------------------------------
        */

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
        | DASHBOARD SISWA
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
        | RIWAYAT PRESENSI SISWA
        |--------------------------------------------------------------------------
        |
        | Menampilkan riwayat kehadiran siswa berdasarkan bulan.
        |
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
        | SCANNER PRESENSI
        |--------------------------------------------------------------------------
        |
        | Membuka halaman scanner kamera siswa.
        |
        */

        Route::get(
            '/presensi/scan',
            [
                SiswaAttendanceController::class,
                'scanner',
            ]
        )
        ->name('presensi.scan');


        /*
        |--------------------------------------------------------------------------
        | PROSES PRESENSI
        |--------------------------------------------------------------------------
        |
        | Mengirim:
        |
        | - Token QR
        | - Latitude
        | - Longitude
        | - Akurasi GPS
        |
        */

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
        | HALAMAN PENGAJUAN IZIN / SAKIT
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


        /*
        |--------------------------------------------------------------------------
        | SIMPAN PENGAJUAN IZIN / SAKIT
        |--------------------------------------------------------------------------
        */

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
        | DASHBOARD PELATIH
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
| BARCODE DINAMIS KKO
|--------------------------------------------------------------------------
|
| Halaman barcode hanya bisa diakses user yang sudah login.
|
| Controller BarcodeDisplayController akan memastikan hanya:
|
| - Guru
| - Pelatih
|
| yang diperbolehkan membuka barcode.
|
*/

Route::middleware('auth')
    ->group(function () {


        /*
        |--------------------------------------------------------------------------
        | LAYAR BARCODE
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
        | BARCODE AKTIF
        |--------------------------------------------------------------------------
        |
        | Dipanggil JavaScript secara berkala.
        |
        | Barcode:
        |
        | - aktif maksimal 60 detik
        | - berubah saat expired
        | - langsung berubah setelah berhasil dipakai siswa
        |
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
|
| Login dan logout Laravel.
|
*/

require __DIR__.'/auth.php';