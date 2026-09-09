<?php

namespace App\Imports;

use App\Helpers\QrCodeHelper;
use App\Models\Kelas;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class SiswasImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // ============================
        // Bersihkan data Excel
        // ============================

        $nis = trim((string) ($row['nis'] ?? ''));
        $nisn = trim((string) ($row['nisn'] ?? ''));

        if (!$nis || !$nisn) {
            return null;
        }

        // ============================
        // Cari kelas
        // ============================

        $kelasExcel = strtoupper(
            str_replace(
                ' ',
                '',
                trim((string) ($row['kelas'] ?? ''))
            )
        );

        $tingkat = substr($kelasExcel, 0, 1);
        $namaKelas = substr($kelasExcel, 1);

        $kelas = Kelas::where('tingkat', $tingkat)
            ->where('nama_kelas', $namaKelas)
            ->first();

        if (!$kelas) {
            return null;
        }

        // ============================
        // Hindari data ganda
        // ============================

        if (Siswa::where('nis', $nis)->exists()) {
            return null;
        }

        if (Siswa::where('nisn', $nisn)->exists()) {
            return null;
        }

        // ============================
        // Konversi tanggal Excel
        // ============================

        $tanggal = $row['tanggal_lahir'] ?? null;

        if (is_numeric($tanggal)) {

            $tanggal = Date::excelToDateTimeObject($tanggal)
                ->format('Y-m-d');

        } else {

            $tanggal = Carbon::parse($tanggal)
                ->format('Y-m-d');

        }

        // ============================
        // Buat siswa
        // ============================

        $siswa = new Siswa([

            'nis'             => $nis,
            'nisn'            => $nisn,
            'barcode'         => $nisn,
            'nama'            => trim((string) ($row['nama'] ?? '')),
            'tempat_lahir'    => trim((string) ($row['tempat_lahir'] ?? '')),
            'tanggal_lahir'   => $tanggal,
            'jenis_kelamin'   => strtoupper(
                trim((string) ($row['jenis_kelamin'] ?? ''))
            ),
            'alamat'          => trim((string) ($row['alamat'] ?? '')),
            'kelas_id'        => $kelas->id,
            'aktif'           => true,

        ]);

        // ============================
        // Simpan siswa
        // ============================

        $siswa->save();

        // ============================
        // Generate barcode berdasarkan NISN
        // ============================

        try {

            QrCodeHelper::generate($siswa);

        } catch (\Throwable $e) {

            Log::error(
                'Gagal generate barcode siswa',
                [
                    'siswa_id' => $siswa->id,
                    'nisn'     => $siswa->nisn,
                    'error'    => $e->getMessage(),
                ]
            );

        }

        return $siswa;
    }
}