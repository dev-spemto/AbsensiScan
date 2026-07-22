<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SiswasImport;

class ImportController extends Controller
{
    /**
     * Menampilkan halaman Import Excel.
     */
    public function index()
    {
        return view('siswa.import');
    }

    /**
     * Proses Import Excel.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        Excel::import(new SiswasImport, $request->file('file'));

        return redirect()
            ->route('siswa.index')
            ->with('success', 'Data siswa berhasil diimport.');
    }
}