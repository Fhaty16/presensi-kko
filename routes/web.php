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
use App\Http\Controllers\Guru\ManualAttendanceController;
use App\Http\Controllers\Guru\SchoolAttendanceRecapExportController;
use App\Http\Controllers\Guru\SchoolAttendanceRecapPrintController;
use App\Http\Controllers\Guru\MonthlySchoolAttendanceRecapExportController;
use App\Http\Controllers\Guru\MonthlySchoolAttendanceRecapPrintController;
use App\Http\Controllers\Guru\SchoolAttendanceDetailController;
use App\Http\Controllers\Guru\StudentSchoolAttendanceDetailExportController;
use App\Http\Controllers\Guru\StudentSchoolAttendanceDetailPrintController;
use App\Http\Controllers\Guru\NewsController;


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
use App\Http\Controllers\Siswa\NewsController as SiswaNewsController;
use App\Http\Controllers\Siswa\ScheduleController;
use App\Http\Controllers\Siswa\AiAssistantController;


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
use App\Http\Controllers\TrainingAttendanceRecapPrintController;


/*
|--------------------------------------------------------------------------
| HALAMAN UTAMA
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
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
            'guru' => redirect()->route('guru.dashboard'),

            'siswa' => redirect()->route('siswa.dashboard'),

            'pelatih' => redirect()->route('pelatih.dashboard'),

            default => abort(403),
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
        | REKAP PRESENSI SEKOLAH
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
        | EXPORT REKAP PRESENSI HARIAN
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/rekap-presensi/export',
            SchoolAttendanceRecapExportController::class
        )
            ->name('attendance.recap.export');


        /*
        |--------------------------------------------------------------------------
        | CETAK / PDF REKAP PRESENSI HARIAN
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/rekap-presensi/cetak',
            SchoolAttendanceRecapPrintController::class
        )
            ->name('attendance.recap.print');


        /*
        |--------------------------------------------------------------------------
        | EXPORT REKAP PRESENSI BULANAN
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/rekap-presensi/bulanan/export',
            MonthlySchoolAttendanceRecapExportController::class
        )
            ->name('attendance.monthly.export');


        /*
        |--------------------------------------------------------------------------
        | CETAK / PDF REKAP PRESENSI BULANAN
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/rekap-presensi/bulanan/cetak',
            MonthlySchoolAttendanceRecapPrintController::class
        )
            ->name('attendance.monthly.print');


        /*
        |--------------------------------------------------------------------------
        | ROUTE KOMPATIBILITAS REKAP BULANAN
        |--------------------------------------------------------------------------
        |
        | Route lama dipertahankan supaya URL/link lama tidak rusak.
        |
        */

        Route::get(
            '/rekap-presensi/bulanan',
            function () {

                $now = now('Asia/Jakarta');

                $month = (int) request()->query(
                    'month',
                    $now->month
                );

                $year = (int) request()->query(
                    'year',
                    $now->year
                );


                if (
                    $month < 1
                    ||
                    $month > 12
                ) {
                    $month = $now->month;
                }


                if (
                    $year < 2020
                    ||
                    $year > 2100
                ) {
                    $year = $now->year;
                }


                return redirect()->route(
                    'guru.attendance.recap',
                    [
                        'tab' => 'bulanan',
                        'month' => $month,
                        'year' => $year,
                    ]
                );
            }
        )
            ->name('attendance.monthly');


        /*
        |--------------------------------------------------------------------------
        | EXPORT DETAIL PRESENSI SISWA
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/rekap-presensi/siswa/{student}/export',
            StudentSchoolAttendanceDetailExportController::class
        )
            ->name('attendance.student.export');


        /*
        |--------------------------------------------------------------------------
        | CETAK DETAIL PRESENSI SISWA
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/rekap-presensi/siswa/{student}/cetak',
            StudentSchoolAttendanceDetailPrintController::class
        )
            ->name('attendance.student.print');


        /*
        |--------------------------------------------------------------------------
        | DETAIL RIWAYAT PRESENSI SISWA
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/rekap-presensi/siswa/{student}',
            [
                SchoolAttendanceDetailController::class,
                'show',
            ]
        )
            ->name('attendance.student.detail');


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


        /*
        |--------------------------------------------------------------------------
        | APPROVE IZIN / SAKIT
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
        | REJECT IZIN / SAKIT
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


        /*
        |--------------------------------------------------------------------------
        | BERITA KKO
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/berita',
            [
                NewsController::class,
                'index',
            ]
        )
            ->name('news.index');


        Route::get(
            '/berita/tambah',
            [
                NewsController::class,
                'create',
            ]
        )
            ->name('news.create');


        Route::post(
            '/berita',
            [
                NewsController::class,
                'store',
            ]
        )
            ->name('news.store');


        Route::get(
            '/berita/{news}/edit',
            [
                NewsController::class,
                'edit',
            ]
        )
            ->name('news.edit');


        Route::put(
            '/berita/{news}',
            [
                NewsController::class,
                'update',
            ]
        )
            ->name('news.update');


        Route::post(
            '/berita/{news}/status',
            [
                NewsController::class,
                'toggleStatus',
            ]
        )
            ->name('news.toggle-status');


        Route::delete(
            '/berita/{news}',
            [
                NewsController::class,
                'destroy',
            ]
        )
            ->name('news.destroy');
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
        | NOTIFIKASI SISWA
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/notifikasi/baca',
            [
                SiswaDashboardController::class,
                'markNotificationsRead',
            ]
        )
            ->name('notifications.read');


        /*
        |--------------------------------------------------------------------------
        | JADWAL PELAJARAN
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/jadwal-pelajaran',
            [
                ScheduleController::class,
                'index',
            ]
        )
            ->name('schedule.index');


        /*
        |--------------------------------------------------------------------------
        | KKO AI ASSISTANT - HALAMAN
        |--------------------------------------------------------------------------
        |
        | URL:
        |
        | /siswa/ai
        |
        */

        Route::get(
            '/ai',
            [
                AiAssistantController::class,
                'index',
            ]
        )
            ->name('ai.index');


        /*
        |--------------------------------------------------------------------------
        | KKO AI ASSISTANT - CHAT API
        |--------------------------------------------------------------------------
        |
        | Flow:
        |
        | siswa login
        |       ↓
        | students
        |       ↓
        | class_id
        |       ↓
        | school_schedules
        |       ↓
        | subjects
        |       ↓
        | AiAssistantController
        |       ↓
        | GroqService
        |       ↓
        | Groq API
        |       ↓
        | JSON response
        |
        */

        Route::post(
            '/ai/chat',
            [
                AiAssistantController::class,
                'chat',
            ]
        )
            ->name('ai.chat');


        /*
        |--------------------------------------------------------------------------
        | PRESENSI SEKOLAH - SCANNER
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


        /*
        |--------------------------------------------------------------------------
        | PRESENSI SEKOLAH - PROSES SCAN
        |--------------------------------------------------------------------------
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
        | RIWAYAT PRESENSI SISWA
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
        | FORM IZIN / SAKIT
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
        | SIMPAN IZIN / SAKIT
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


        /*
        |--------------------------------------------------------------------------
        | BERITA KKO - DAFTAR
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/berita',
            [
                SiswaNewsController::class,
                'index',
            ]
        )
            ->name('news.index');


        /*
        |--------------------------------------------------------------------------
        | BERITA KKO - DETAIL
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/berita/{news}',
            [
                SiswaNewsController::class,
                'show',
            ]
        )
            ->name('news.show');
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
| PENGELOLAAN LATIHAN KKO
|--------------------------------------------------------------------------
|
| Route ini saat ini dapat diakses oleh user yang sudah login.
|
| Nanti kalau diperlukan, kita dapat membatasi hanya:
|
| - Guru
| - Pelatih
|
|--------------------------------------------------------------------------
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
        | BARCODE LATIHAN
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
        | UPDATE STATUS PRESENSI SISWA
        |--------------------------------------------------------------------------
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
        | HAPUS STATUS PRESENSI SISWA
        |--------------------------------------------------------------------------
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
        | Diletakkan paling bawah karena memiliki parameter dinamis.
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
        | EXPORT EXCEL REKAP PRESENSI LATIHAN
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/data-cabang-siswa/export',
            TrainingAttendanceRecapExportController::class
        )
            ->name('students.sports.export');


        /*
        |--------------------------------------------------------------------------
        | CETAK / PDF REKAP PRESENSI LATIHAN
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/data-cabang-siswa/cetak',
            TrainingAttendanceRecapPrintController::class
        )
            ->name('students.sports.print');


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
            ->name('students.sports.attendance-detail');


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
| BARCODE PRESENSI SEKOLAH
|--------------------------------------------------------------------------
*/

Route::middleware('auth')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | HALAMAN BARCODE
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
        | TOKEN BARCODE AKTIF
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