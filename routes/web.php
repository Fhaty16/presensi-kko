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
        | Controller hanya menampilkan sesi sesuai cabang
        | olahraga siswa.
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
        | IZIN / SAKIT SEKOLAH
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
| TrainingController dan TrainingBarcodeController melakukan
| pengecekan role Guru / Pelatih.
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
        |
        | Route ini harus berada sebelum:
        |
        | /latihan/{trainingSession}
        |
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
        ->name('training.edit');


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
        ->name('training.update');


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
        ->name('training.destroy');


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
        ->name('training.barcode.display');


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
        ->name('training.barcode.current');


        /*
        |--------------------------------------------------------------------------
        | UPDATE STATUS IZIN / SAKIT LATIHAN
        |--------------------------------------------------------------------------
        |
        | Digunakan Guru / Pelatih untuk mengubah status siswa
        | pada sesi tertentu menjadi:
        |
        | - permission = Izin
        | - sick       = Sakit
        |
        | Contoh URL:
        |
        | /latihan/15/siswa/4/status
        |
        */

        Route::put(
            '/latihan/{trainingSession}/siswa/{student}/status',
            [
                TrainingController::class,
                'updateStudentStatus',
            ]
        )
        ->name('training.student.status');


        /*
        |--------------------------------------------------------------------------
        | HAPUS STATUS IZIN / SAKIT LATIHAN
        |--------------------------------------------------------------------------
        |
        | Jika status Izin / Sakit dihapus setelah batas Alfa,
        | controller akan mengecek ulang dan siswa dapat langsung
        | menjadi Alfa.
        |
        */

        Route::delete(
            '/latihan/{trainingSession}/siswa/{student}/status',
            [
                TrainingController::class,
                'clearStudentStatus',
            ]
        )
        ->name('training.student.status.clear');


        /*
        |--------------------------------------------------------------------------
        | DETAIL SESI LATIHAN
        |--------------------------------------------------------------------------
        |
        | Route parameter umum ini harus berada paling bawah
        | setelah:
        |
        | /latihan/buat
        | /latihan/{trainingSession}/edit
        | /latihan/{trainingSession}/barcode
        | /latihan/{trainingSession}/barcode/current
        | /latihan/{trainingSession}/siswa/{student}/status
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
| DATA CABANG OLAHRAGA SISWA
|--------------------------------------------------------------------------
|
| Digunakan Guru dan Pelatih untuk:
|
| - melihat cabang olahraga siswa
| - menentukan cabang olahraga siswa
| - mengganti cabang olahraga siswa
| - memfilter siswa berdasarkan cabang olahraga
|
| StudentSportController melakukan pengecekan role.
|
*/

Route::middleware('auth')
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
        ->name('students.sports.index');


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
        ->name('students.sports.update');

    });


/*
|--------------------------------------------------------------------------
| BARCODE PRESENSI MASUK SEKOLAH
|--------------------------------------------------------------------------
|
| Barcode khusus presensi masuk sekolah.
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