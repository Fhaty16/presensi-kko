<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;


/*
|--------------------------------------------------------------------------
| COMMAND BAWAAN LARAVEL
|--------------------------------------------------------------------------
*/

Artisan::command('inspire', function () {

    $this->comment(
        Inspiring::quote()
    );

})
->purpose(
    'Display an inspiring quote'
);


/*
|--------------------------------------------------------------------------
| AUTO ALFA PRESENSI SEKOLAH
|--------------------------------------------------------------------------
|
| Berjalan:
|
| Senin - Jumat
| Pukul 07:01 WIB
|
| Siswa yang belum memiliki data presensi sekolah
| pada hari tersebut akan otomatis ditandai:
|
| absent / Alfa
|
*/

Schedule::command(
    'attendance:mark-absent'
)
    ->weekdays()
    ->at('07:01')
    ->timezone('Asia/Jakarta')
    ->withoutOverlapping();


/*
|--------------------------------------------------------------------------
| AUTO ALFA PRESENSI LATIHAN
|--------------------------------------------------------------------------
|
| Scheduler melakukan pengecekan setiap menit.
|
| Contoh:
|
| Latihan mulai 14:00
|
| 14:00:00 - 14:10:00
| => Hadir
|
| 14:10:01 - 14:30:00
| => Terlambat
|
| Setelah 14:30:00
| => siswa yang belum memiliki presensi otomatis Alfa
|
| Command hanya memproses siswa yang cabang olahraganya
| sama dengan cabang olahraga sesi latihan.
|
*/

Schedule::command(
    'training:mark-absent'
)
    ->everyMinute()
    ->timezone('Asia/Jakarta')
    ->withoutOverlapping();