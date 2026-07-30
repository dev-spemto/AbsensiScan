<?php

namespace App\Http\Controllers;

use App\Exports\RekapExport;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    /**
     * Export Excel
     */
    public function excel(Request $request)
    {
        return Excel::download(

            new RekapExport($request),

            'Rekap_Presensi_'.now()->format('Ymd_His').'.xlsx'

        );
    }

    /**
     * Export PDF
     */
    public function pdf(Request $request)
    {
        $presensis = $this->getData($request);

        $pdf = Pdf::loadView(
            'export.pdf',
            compact('presensis')
        );

        return $pdf->download(
            'Rekap_Presensi_'.now()->format('Ymd_His').'.pdf'
        );
    }

    /**
     * Print
     */
    public function print(Request $request)
    {
        $presensis = $this->getData($request);

        return view(
            'export.print',
            compact('presensis')
        );
    }

    /**
     * Ambil Data
     */
    private function getData(Request $request)
    {
        $query = Presensi::with([
            'siswa.kelas',
            'guru',
            'scanner',
            'tahunAjaran',
        ]);

        if ($request->filled('tanggal')) {

            $query->whereDate('tanggal', $request->tanggal);

        }

        if ($request->filled('bulan')) {

            $query->whereMonth('tanggal', $request->bulan);

        }

        if ($request->filled('kelas')) {

            $query->whereHas('siswa', function ($q) use ($request) {

                $q->where('kelas_id', $request->kelas);

            });

        }

        if ($request->filled('siswa')) {

            $query->where('siswa_id', $request->siswa);

        }

        if ($request->filled('guru')) {

            $query->where('guru_id', $request->guru);

        }

        if ($request->filled('scanner')) {

            $query->where('scanner_id', $request->scanner);

        }

        if ($request->filled('scan_by')) {

            $query->where('scan_by', $request->scan_by);

        }

        if ($request->filled('tahun_ajaran')) {

            $query->where('tahun_ajaran_id', $request->tahun_ajaran);

        }

        if ($request->filled('status')) {

            $query->where('status', $request->status);

        }

        if ($request->filled('metode')) {

            $query->where('metode', $request->metode);

        }

        return $query
            ->latest('tanggal')
            ->latest('jam_scan')
            ->get();
    }

}