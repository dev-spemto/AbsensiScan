<?php

namespace App\Http\Controllers;

use App\Exports\PresensiExport;
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

            new PresensiExport(

                $request->tanggal,
                $request->kelas,
                $request->guru,
                $request->status

            ),

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
            'tahunAjaran',
        ]);

        if ($request->filled('tanggal')) {

            $query->whereDate(
                'tanggal',
                $request->tanggal
            );

        }

        if ($request->filled('kelas')) {

            $query->whereHas('siswa', function ($q) use ($request) {

                $q->where(
                    'kelas_id',
                    $request->kelas
                );

            });

        }

        if ($request->filled('guru')) {

            $query->where(
                'guru_id',
                $request->guru
            );

        }

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );

        }

        return $query
            ->orderBy('tanggal')
            ->orderBy('jam_scan')
            ->get();
    }
}