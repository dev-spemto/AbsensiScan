<?php

namespace App\Exports;

use App\Models\Presensi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RekapExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Presensi::with([
            'siswa.kelas',
            'guru',
            'scanner',
            'tahunAjaran',
        ]);

        if ($this->request->filled('tanggal')) {
            $query->whereDate('tanggal', $this->request->tanggal);
        }

        if ($this->request->filled('bulan')) {
            $query->whereMonth('tanggal', $this->request->bulan);
        }

        if ($this->request->filled('kelas')) {
            $query->whereHas('siswa', function ($q) {
                $q->where('kelas_id', $this->request->kelas);
            });
        }

        if ($this->request->filled('guru')) {
            $query->where('guru_id', $this->request->guru);
        }

        if ($this->request->filled('scanner')) {
            $query->where('scanner_id', $this->request->scanner);
        }

        if ($this->request->filled('scan_by')) {
            $query->where('scan_by', $this->request->scan_by);
        }

        if ($this->request->filled('status')) {
            $query->where('status', $this->request->status);
        }

        if ($this->request->filled('metode')) {
            $query->where('metode', $this->request->metode);
        }

        return $query
            ->latest('tanggal')
            ->latest('jam_scan')
            ->get()
            ->map(function ($item) {

                return [

                    $item->tanggal,

                    substr($item->jam_scan,0,5),

                    $item->siswa->nama,

                    optional($item->siswa->kelas)->nama_lengkap,

                    $item->status,

                    optional($item->scanner)->nama,

                    match($item->scan_by){

                        'admin' => 'Admin',

                        'guru' => 'Guru',

                        'ketua_kelas' => 'Ketua Kelas',

                        'sekretaris' => 'Sekretaris',

                        default => '-',

                    },

                    optional($item->guru)->nama,

                    $item->metode,

                ];

            });
    }

    public function headings(): array
    {
        return [

            'Tanggal',

            'Jam',

            'Nama Siswa',

            'Kelas',

            'Status',

            'Petugas Scan',

            'Role',

            'Guru',

            'Metode',

        ];
    }
}