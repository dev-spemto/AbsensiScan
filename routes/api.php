<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SiswaController;
use App\Http\Controllers\Api\ImportController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// =========================
// API Presensi Siswa
// =========================

Route::get('/siswa/{barcode}', [SiswaController::class, 'cariBarcode']);
Route::post('/import/siswa', [ImportController::class, 'siswa']);