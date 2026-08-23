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
})->purpose(
    'Display an inspiring quote'
);


/*
|--------------------------------------------------------------------------
| AUTO ALFA KKO
|--------------------------------------------------------------------------
|
| Senin - Jumat
| Pukul 07:01 WIB
|
| Siswa yang belum memiliki data presensi pada hari tersebut
| akan ditandai sebagai absent / Alfa.
|
*/

Schedule::command(
    'attendance:mark-absent'
)
    ->weekdays()
    ->at('07:01')
    ->timezone('Asia/Jakarta')
    ->withoutOverlapping();