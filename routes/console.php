<?php

use Illuminate\Support\Facades\Schedule;


/*
|--------------------------------------------------------------------------
| AUTO ALFA PRESENSI SEKOLAH
|--------------------------------------------------------------------------
|
| Scheduler dijalankan setiap menit pada hari kerja.
|
| Waktu sebenarnya TIDAK ditentukan di scheduler.
|
| Command attendance:mark-absent akan membaca setting:
|
| - attendance_start_time
| - attendance_end_time
| - late_after_minutes
| - auto_alpha
|
| Contoh:
|
| Jam Mulai   : 06:00
| Jam Selesai : 07:00
| Toleransi   : 10 menit
|
| Maka command akan menunggu sampai:
|
| 07:11
|
| Baru kemudian Auto Alfa dijalankan.
|
*/

Schedule::command(
    'attendance:mark-absent'
)
    ->everyMinute()
    ->weekdays()
    ->timezone(
        'Asia/Jakarta'
    )
    ->withoutOverlapping();


/*
|--------------------------------------------------------------------------
| AUTO ALFA LATIHAN
|--------------------------------------------------------------------------
|
| Jangan ubah logika latihan.
|
| Sistem latihan tetap memakai TrainingAttendanceService
| dan aturan batas waktu latihannya sendiri.
|
*/

Schedule::command(
    'training:mark-absent'
)
    ->everyMinute()
    ->timezone(
        'Asia/Jakarta'
    )
    ->withoutOverlapping();