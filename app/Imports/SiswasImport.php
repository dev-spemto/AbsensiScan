<?php

namespace App\Imports;

use App\Models\Kelas;
use App\Models\Siswa;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswasImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // ============================
        // Cari kelas
        // ============================

        $kelasExcel = strtoupper(str_replace(' ', '', trim($row['kelas'])));

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

        if (Siswa::where('nis', trim($row['nis']))->exists()) {
            return null;
        }

        if (Siswa::where('nisn', trim($row['nisn']))->exists()) {
            return null;
        }

        // ============================
        // Konversi tanggal Excel
        // ============================

        $tanggal = $row['tanggal_lahir'];

        if (is_numeric($tanggal)) {

            $tanggal = Date::excelToDateTimeObject($tanggal)
                ->format('Y-m-d');

        } else {

            $tanggal = Carbon::parse($tanggal)
                ->format('Y-m-d');

        }

        // ============================
        // Simpan data
        // ============================

        return new Siswa([

            'nis'             => trim($row['nis']),
            'nisn'            => trim($row['nisn']),
            'barcode'         => trim($row['nisn']),
            'nama'            => trim($row['nama']),
            'tempat_lahir'    => trim($row['tempat_lahir']),
            'tanggal_lahir'   => $tanggal,
            'jenis_kelamin'   => strtoupper(trim($row['jenis_kelamin'])),
            'alamat'          => trim($row['alamat']),
            'kelas_id'        => $kelas->id,
            'aktif'           => true,

        ]);
    }
}