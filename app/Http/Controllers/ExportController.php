<?php

namespace App\Http\Controllers;

use App\Exports\RekapExport;
use App\Models\Presensi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class ExportController extends Controller
{
    /**
     * Export Excel
     */
    public function excel(Request $request)
    {
        $this->validateRequest($request);

        try {

            return Excel::download(

                new RekapExport($request),

                'Rekap_Presensi_' . now()->format('Ymd_His') . '.xlsx'

            );

        } catch (Throwable $e) {

            report($e);

            return back()->with(
                'error',
                'Gagal mengekspor data ke Excel.'
            );

        }
    }

    /**
     * Export PDF
     */
    public function pdf(Request $request)
    {
        $this->validateRequest($request);

        try {

            $presensis = $this->getData($request);

            $pdf = Pdf::loadView(
                'export.pdf',
                compact('presensis')
            );

            return $pdf->download(
                'Rekap_Presensi_' . now()->format('Ymd_His') . '.pdf'
            );

        } catch (Throwable $e) {

            report($e);

            return back()->with(
                'error',
                'Gagal membuat PDF.'
            );

        }
    }

    /**
     * Print
     */
    public function print(Request $request)
    {
        $this->validateRequest($request);

        try {

            $presensis = $this->getData($request);

            return view(
                'export.print',
                compact('presensis')
            );

        } catch (Throwable $e) {

            report($e);

            return back()->with(
                'error',
                'Gagal menampilkan data.'
            );

        }
    }

    /**
     * Validasi Filter
     */
    private function validateRequest(Request $request): void
    {
        $request->validate([
            'tanggal'       => 'nullable|date',
            'bulan'         => 'nullable|integer|between:1,12',
            'kelas'         => 'nullable|integer|exists:kelas,id',
            'siswa'         => 'nullable|integer|exists:siswas,id',
            'guru'          => 'nullable|integer|exists:gurus,id',
            'scanner'       => 'nullable|integer|exists:users,id',
            'tahun_ajaran'  => 'nullable|integer|exists:tahun_ajarans,id',
            'status'        => 'nullable|in:Hadir,Terlambat,Izin,Sakit,Alpha',
            'metode'        => 'nullable|in:Barcode,Manual',
            'scan_by'       => 'nullable|string|max:30',
        ]);
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