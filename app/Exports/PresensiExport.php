<?php

namespace App\Exports;

use App\Models\Presensi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class PresensiExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $tanggal;
    protected $kelas;
    protected $guru;
    protected $status;

    public function __construct(
        $tanggal = null,
        $kelas = null,
        $guru = null,
        $status = null
    ) {
        $this->tanggal = $tanggal;
        $this->kelas = $kelas;
        $this->guru = $guru;
        $this->status = $status;
    }

    /**
     * Data yang diexport
     */
    public function collection(): Collection
    {
        $query = Presensi::with([
            'siswa.kelas',
            'guru',
            'tahunAjaran',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Filter
        |--------------------------------------------------------------------------
        */

        if ($this->tanggal) {

            $query->whereDate('tanggal', $this->tanggal);

        }

        if ($this->kelas) {

            $query->whereHas('siswa', function ($q) {

                $q->where('kelas_id', $this->kelas);

            });

        }

        if ($this->guru) {

            $query->where('guru_id', $this->guru);

        }

        if ($this->status) {

            $query->where('status', $this->status);

        }

        return $query
            ->orderBy('tanggal')
            ->orderBy('jam_scan')
            ->get()
            ->map(function ($presensi) {

                return [

                    'Tanggal' => \Carbon\Carbon::parse($presensi->tanggal)
                        ->format('d-m-Y'),

                    'Jam Scan' => substr($presensi->jam_scan, 0, 5),

                    'Nama Siswa' => $presensi->siswa->nama,

                    'Kelas' => $presensi->siswa->kelas->nama_lengkap,

                    'Guru' => $presensi->guru->nama,

                    'Status' => $presensi->status,

                    'Metode' => $presensi->metode,

                    'Tahun Ajaran' => $presensi->tahunAjaran->tahun,

                ];

            });
    }

    /**
     * Judul Kolom
     */
    public function headings(): array
    {
        return [

            'Tanggal',

            'Jam Scan',

            'Nama Siswa',

            'Kelas',

            'Guru',

            'Status',

            'Metode',

            'Tahun Ajaran',

        ];
    }
}