<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\JsonResponse;

class SiswaController extends Controller
{
    public function cariBarcode($barcode): JsonResponse
    {
        $siswa = Siswa::with('kelas')
            ->where('barcode', $barcode)
            ->where('aktif', true)
            ->first();

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $siswa
        ]);
    }
}