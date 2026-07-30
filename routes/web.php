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
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\PengurusKelasController;
use App\Http\Controllers\LoginLogController;
use App\Http\Controllers\ActivityLogController;

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

    Route::get('/profil', [AuthController::class, 'profil'])
    ->name('profil');

    Route::get('/password', [AuthController::class, 'editPassword'])
    ->name('password.edit');

Route::put('/password', [AuthController::class, 'updatePassword'])
    ->name('password.update');

    /*
    |--------------------------------------------------------------------------
    | Menu Administrator
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Import Excel
    |--------------------------------------------------------------------------
    */

    Route::get('/siswa/import', [ImportController::class, 'index'])
        ->name('siswa.import');

    Route::post('/siswa/import', [ImportController::class, 'store'])
        ->name('siswa.import.store');

    Route::get('/siswa/import/template', [ImportController::class, 'downloadTemplate'])
        ->name('siswa.import.template');

    /*
    |--------------------------------------------------------------------------
    | Master Data
    |--------------------------------------------------------------------------
    */

    Route::resource('siswa', SiswaController::class);

    Route::resource('guru', GuruController::class);

    /*
    |--------------------------------------------------------------------------
    | Pengurus Kelas
    |--------------------------------------------------------------------------
    */

    Route::resource('pengurus-kelas', PengurusKelasController::class);

    Route::get(
        '/pengurus-kelas/{pengurus_kela}/password',
        [PengurusKelasController::class, 'editPassword']
    )->name('pengurus-kelas.password');

    Route::put(
        '/pengurus-kelas/{pengurus_kela}/password',
        [PengurusKelasController::class, 'updatePassword']
    )->name('pengurus-kelas.password.update');

    Route::post(
    '/pengurus-kelas/{pengurus_kela}/reset-password',
    [PengurusKelasController::class, 'resetPassword']
    )->name('pengurus-kelas.reset-password');

    /*
    |--------------------------------------------------------------------------
    | Riwayat Login
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/login-log',
        [LoginLogController::class, 'index']
    )->name('login-log.index');

    /*
    |--------------------------------------------------------------------------
    | Pengaturan
    |--------------------------------------------------------------------------
    */

    Route::get('/pengaturan', [PengaturanController::class, 'index'])
        ->name('pengaturan.index');

    Route::put('/pengaturan', [PengaturanController::class, 'update'])
        ->name('pengaturan.update');

    });

    /*
    |--------------------------------------------------------------------------
    | Presensi
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin,guru,ketua_kelas,wakil_kelas,sekretaris')->group(function () {

        Route::post('/presensi/scan', [PresensiController::class, 'scan'])
            ->name('presensi.scan');

        Route::resource('presensi', PresensiController::class);

    });

    /*
    |--------------------------------------------------------------------------
    | Rekap Presensi
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin,guru')->group(function () {

        Route::get('/rekap', [RekapController::class, 'index'])
            ->name('rekap.index');

        Route::get('/rekap/export/excel', [ExportController::class, 'excel'])
            ->name('rekap.export.excel');

        Route::get('/rekap/export/pdf', [ExportController::class, 'pdf'])
            ->name('rekap.export.pdf');

        Route::get('/rekap/print', [ExportController::class, 'print'])
            ->name('rekap.print');

    });

    /*
    |--------------------------------------------------------------------------
    | Activity Log
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/activity-log',
        [ActivityLogController::class, 'index']
    )->name('activity-log.index');

});