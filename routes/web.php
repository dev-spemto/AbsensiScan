<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\ExportController;

/*
|--------------------------------------------------------------------------
| Login
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'index'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.proses');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Semua halaman harus login
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Menu Khusus Administrator
    |--------------------------------------------------------------------------
    */

    Route::middleware('admin')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Import Excel Siswa
        |--------------------------------------------------------------------------
        */

        Route::get('/siswa/import', [ImportController::class, 'index'])
            ->name('siswa.import');

        Route::post('/siswa/import', [ImportController::class, 'store'])
            ->name('siswa.import.store');

        /*
        |--------------------------------------------------------------------------
        | Data Siswa
        |--------------------------------------------------------------------------
        */

        Route::resource('siswa', SiswaController::class);

        /*
        |--------------------------------------------------------------------------
        | Data Guru
        |--------------------------------------------------------------------------
        */

        Route::resource('guru', GuruController::class);

    });

    /*
    |--------------------------------------------------------------------------
    | Data Presensi
    |--------------------------------------------------------------------------
    */

    Route::post('/presensi/scan', [PresensiController::class, 'scan'])
        ->name('presensi.scan');

    Route::resource('presensi', PresensiController::class);

    /*
    |--------------------------------------------------------------------------
    | Rekap Presensi
    |--------------------------------------------------------------------------
    */

    Route::get('/rekap', [RekapController::class, 'index'])
        ->name('rekap.index');

    /*
    |--------------------------------------------------------------------------
    | Export Rekap
    |--------------------------------------------------------------------------
    */

    Route::get('/rekap/export/excel', [ExportController::class, 'excel'])
        ->name('rekap.export.excel');

    Route::get('/rekap/export/pdf', [ExportController::class, 'pdf'])
        ->name('rekap.export.pdf');

    /*
    |--------------------------------------------------------------------------
    | Print Rekap
    |--------------------------------------------------------------------------
    */

    Route::get('/rekap/print', [ExportController::class, 'print'])
        ->name('rekap.print');

});