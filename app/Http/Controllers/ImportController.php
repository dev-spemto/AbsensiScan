<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SiswasImport;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ImportController extends Controller
{
    /**
     * Halaman Import
     */
    public function index()
    {
        return view('siswa.import');
    }

    /**
     * Proses Import
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {

            Excel::import(
                new SiswasImport,
                $request->file('file')
            );

            return redirect()
                ->route('siswa.index')
                ->with('success', 'Data siswa berhasil diimport.');

        } catch (\Throwable $e) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Import gagal: '.$e->getMessage()
                );

        }
    }

    /**
     * Download Template Excel
     */
    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'NIS');
        $sheet->setCellValue('B1', 'NISN');
        $sheet->setCellValue('C1', 'Nama');
        $sheet->setCellValue('D1', 'Tempat Lahir');
        $sheet->setCellValue('E1', 'Tanggal Lahir');
        $sheet->setCellValue('F1', 'Jenis Kelamin');
        $sheet->setCellValue('G1', 'Alamat');
        $sheet->setCellValue('H1', 'Kelas');

        // Contoh data
        $sheet->setCellValue('A2', '24001');
        $sheet->setCellValue('B2', '1234567890');
        $sheet->setCellValue('C2', 'Ahmad Fauzan');
        $sheet->setCellValue('D2', 'Brebes');
        $sheet->setCellValue('E2', '2012-05-10');
        $sheet->setCellValue('F2', 'L');
        $sheet->setCellValue('G2', 'Jl. Melati No.1');
        $sheet->setCellValue('H2', '7A');

        $writer = new Xlsx($spreadsheet);

        $filename = 'Template_Import_Siswa.xlsx';

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename);
    }
}