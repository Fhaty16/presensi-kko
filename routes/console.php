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
| Scheduler mengecek Auto Alfa sekolah setiap menit.
|
| Hari aktif:
| Senin - Jumat
|
| Waktu aktif:
| 07:01 - 23:59 WIB
|
| Aturan:
|
| - Sebelum 07:01 siswa masih dapat melakukan presensi.
|
| - Mulai 07:01, siswa aktif yang belum mempunyai record
|   presensi pada hari tersebut akan otomatis dibuat Alfa.
|
| - Siswa yang sudah memiliki status:
|
|   present     = Hadir
|   late        = Terlambat
|   permission  = Izin
|   sick        = Sakit
|   absent      = Alfa
|
|   tidak akan dibuatkan record baru.
|
| - Scheduler dijalankan setiap menit agar jika server baru
|   aktif setelah pukul 07:01, misalnya 08:00 atau 12:00,
|   Auto Alfa hari tersebut tetap dapat dijalankan.
|
| Command yang digunakan:
|
| attendance:mark-absent
|
*/

Schedule::command(
    'attendance:mark-absent'
)
    ->everyMinute()
    ->weekdays()
    ->between(
        '07:01',
        '23:59'
    )
    ->timezone(
        'Asia/Jakarta'
    )
    ->withoutOverlapping();


/*
|--------------------------------------------------------------------------
| AUTO ALFA PRESENSI LATIHAN KKO
|--------------------------------------------------------------------------
|
| Scheduler mengecek seluruh sesi latihan setiap menit.
|
| Contoh:
|
| Latihan mulai 14:00.
|
| 14:00:00 - 14:10:00
| => Hadir
|
| 14:10:01 - 14:30:00
| => Terlambat
|
| Setelah 14:30:00
| => siswa yang belum memiliki presensi otomatis Alfa.
|
| Auto Alfa hanya berlaku untuk siswa aktif yang cabang
| olahraganya sama dengan cabang olahraga sesi latihan.
|
| Command yang digunakan:
|
| training:mark-absent
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