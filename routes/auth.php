<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
|
| Sistem login KKO SMANDA:
| Guru  -> NIP + Password
| Siswa -> NIS + Password
|
| Tidak menggunakan email dan tidak ada register.
|
*/


/*
|--------------------------------------------------------------------------
| Login
|--------------------------------------------------------------------------
*/

Route::get('/login', [
    AuthenticatedSessionController::class,
    'create'
])->name('login');

Route::post('/login', [
    AuthenticatedSessionController::class,
    'store'
]);


/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

Route::post('/logout', [
    AuthenticatedSessionController::class,
    'destroy'
])->middleware('auth')->name('logout');