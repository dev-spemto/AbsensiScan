@extends('layouts.app')

@section('title', 'Cetak Kartu Pelajar')

@push('styles')
<style>

/* =========================================================
   TOOLBAR
========================================================= */

.kartu-toolbar {
    margin-bottom: 25px;
}


/* =========================================================
   KERTAS A4
========================================================= */

.kartu-sheet {
    width: 190mm;
    min-height: 277mm;
    margin: 0 auto 10mm;
}


/* =========================================================
   GRID KARTU
========================================================= */

.kartu-grid {
    display: grid;
    grid-template-columns: repeat(2, 85.6mm);
    grid-template-rows: repeat(4, 54mm);

    column-gap: 8mm;
    row-gap: 5mm;

    justify-content: center;
}


/* =========================================================
   KARTU
========================================================= */

.kartu {
    position: relative;

    width: 85.6mm;
    height: 54mm;

    box-sizing: border-box;
    overflow: hidden;

    background: #ffffff;

    border: 0.3mm solid #999;
    border-radius: 4mm;

    box-shadow: none;

    break-inside: avoid;
    page-break-inside: avoid;
}


/* =========================================================
   HEADER KARTU
========================================================= */

.kartu-header {
    display: flex;
    align-items: center;

    gap: 3mm;

    padding: 3mm 4mm 0;
}


.kartu-logo {
    width: 8mm;

    font-size: 6mm;
    color: #adb5bd;

    flex-shrink: 0;
}


.kartu-sekolah {
    font-size: 3.8mm;
    font-weight: 800;

    line-height: 1.05;

    color: #172033;
}


.kartu-judul {
    margin-top: 1mm;

    font-size: 2.4mm;
    font-weight: 700;

    color: #198754;
}


/* =========================================================
   BODY KARTU
========================================================= */

.kartu-body {
    display: flex;
    align-items: flex-start;

    gap: 4mm;

    margin-top: 3mm;

    padding: 0 4mm;
}


/* =========================================================
   FOTO
========================================================= */

.kartu-foto {
    width: 25mm;
    height: 29mm;

    object-fit: cover;

    border-radius: 2mm;
    border: 0.4mm solid #198754;

    flex-shrink: 0;
}


.kartu-foto-default {
    width: 25mm;
    height: 29mm;

    border-radius: 2mm;

    background: #e9ecef;

    display: flex;
    align-items: center;
    justify-content: center;

    color: #198754;

    font-size: 10mm;

    flex-shrink: 0;
}


/* =========================================================
   DATA SISWA
========================================================= */

.kartu-data {
    flex: 1;

    min-width: 0;

    overflow: hidden;

    padding-right: 1mm;
}


.kartu-nama {
    font-size: 3.6mm;
    font-weight: 800;

    margin-bottom: 2mm;

    line-height: 1.1;

    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}


.kartu-row {
    display: flex;

    font-size: 2.5mm;

    margin-bottom: 1.5mm;

    line-height: 1.1;
}


.kartu-label {
    width: 13mm;

    flex-shrink: 0;

    font-weight: 700;
}


.kartu-value {
    flex: 1;

    min-width: 0;

    overflow: hidden;

    white-space: nowrap;
    text-overflow: ellipsis;
}


/* =========================================================
   BARCODE
========================================================= */

.kartu-barcode {
    position: absolute;

    right: 4mm;
    bottom: 3mm;

    width: 31mm;

    text-align: center;

    z-index: 5;

    background: #fff;
}


.kartu-barcode img {
    display: block;

    width: 31mm;
    height: auto;

    margin: 0 auto;
}


.kartu-barcode-number {
    margin-top: 0.8mm;

    font-size: 2.2mm;
    font-weight: 800;

    letter-spacing: 0.45mm;

    line-height: 1;
}


/* =========================================================
   FOOTER
========================================================= */

.kartu-footer {
    position: absolute;

    left: 4mm;
    bottom: 2.5mm;

    font-size: 1.8mm;

    color: #6c757d;

    z-index: 6;
}


/* =========================================================
   PRINT
========================================================= */

@media print {

    @page {
        size: A4 portrait;
        margin: 10mm;
    }


    html,
    body {
        margin: 0 !important;
        padding: 0 !important;

        background: #fff !important;
    }


    /* Sembunyikan elemen aplikasi */

    .sidebar,
    .topbar,
    .no-print {
        display: none !important;
    }


    /* Area konten */

    .content {
        width: 100% !important;

        margin: 0 !important;
        padding: 0 !important;
    }


    .page {
        margin: 0 !important;
        padding: 0 !important;
    }


    /* =====================================================
       KERTAS A4 SAAT PRINT
    ===================================================== */

    .kartu-sheet {
        width: 190mm;
        height: 277mm;

        min-height: 277mm;

        margin: 0;
        padding: 0;

        page-break-after: always;
        break-after: page;
    }


    .kartu-sheet:last-child {
        page-break-after: auto;
        break-after: auto;
    }


    /* =====================================================
       GRID PRINT
    ===================================================== */

    .kartu-grid {
        display: grid;

        grid-template-columns: repeat(2, 85.6mm);
        grid-template-rows: repeat(4, 54mm);

        column-gap: 8mm;
        row-gap: 5mm;

        justify-content: center;
    }


    /* =====================================================
       KARTU PRINT
    ===================================================== */

    .kartu {
        width: 85.6mm;
        height: 54mm;

        box-sizing: border-box;

        box-shadow: none;

        border: 0.3mm solid #999;
        border-radius: 4mm;

        break-inside: avoid;
        page-break-inside: avoid;
    }


    /* Pastikan barcode tidak hilang saat print */

    .kartu-barcode {
        position: absolute;

        right: 4mm;
        bottom: 3mm;

        width: 31mm;

        display: block !important;

        background: #fff;
    }


    .kartu-barcode img {
        display: block !important;

        width: 31mm;
        height: auto;
    }


    .kartu-barcode-number {
        display: block !important;
    }


    /* Jangan pecah kartu */

    .kartu,
    .kartu-header,
    .kartu-body,
    .kartu-barcode,
    .kartu-footer {
        break-inside: avoid;
        page-break-inside: avoid;
    }

}
</style>
@endpush


@section('content')

<div class="kartu-toolbar no-print">

    <div class="d-flex justify-content-between align-items-center">

        <div>

            <h3 class="fw-bold mb-1">

                <i class="fa-solid fa-id-card text-success"></i>

                Cetak Kartu Pelajar

            </h3>

            <small class="text-muted">

                {{ $siswas->count() }} siswa aktif

            </small>

        </div>

        <div>

            <a href="{{ route('siswa.index') }}"
               class="btn btn-secondary">

                <i class="fa-solid fa-arrow-left"></i>

                Kembali

            </a>

            <button onclick="window.print()"
                    class="btn btn-dark">

                <i class="fa-solid fa-print"></i>

                Cetak Semua

            </button>

        </div>

    </div>

</div>

@foreach($siswas->chunk(8) as $kelompok)

    <div class="kartu-sheet">

        <div class="kartu-grid">

            @foreach($kelompok as $siswa)

                <div class="kartu">

                    {{-- HEADER --}}

                    <div class="kartu-header">

                        <div class="kartu-logo">
                            <i class="fa-solid fa-school"></i>
                        </div>

                        <div>

                            <div class="kartu-sekolah">
                                SMP MUHAMMADIYAH TONJONG
                            </div>

                            <div class="kartu-judul">
                                KARTU PELAJAR
                            </div>

                        </div>

                    </div>


                    {{-- BODY --}}

                    <div class="kartu-body">

                        @if($siswa->foto)

                            <img
                                src="{{ asset('storage/'.$siswa->foto) }}"
                                class="kartu-foto"
                                alt="{{ $siswa->nama }}">

                        @else

                            <div class="kartu-foto-default">

                                <i class="fa-solid fa-user"></i>

                            </div>

                        @endif


                        <div class="kartu-data">

                            <div class="kartu-nama">
                                {{ $siswa->nama }}
                            </div>

                            <div class="kartu-row">
                                <div class="kartu-label">NIS</div>
                                <div class="kartu-value">
                                    {{ $siswa->nis }}
                                </div>
                            </div>

                            <div class="kartu-row">
                                <div class="kartu-label">NISN</div>
                                <div class="kartu-value">
                                    {{ $siswa->nisn }}
                                </div>
                            </div>

                            <div class="kartu-row">
                                <div class="kartu-label">Kelas</div>
                                <div class="kartu-value">
                                    {{ $siswa->kelas->nama_lengkap }}
                                </div>
                            </div>

                            <div class="kartu-row">
                                <div class="kartu-label">JK</div>
                                <div class="kartu-value">
                                    {{ $siswa->jenis_kelamin == 'L' ? 'L' : 'P' }}
                                </div>
                            </div>

                        </div>

                    </div>


                    {{-- BARCODE --}}

                    <div class="kartu-barcode">

                        @if($siswa->nisn)

                            <img
                                src="{{ asset('storage/barcodes/siswa/' . $siswa->nisn . '.png') }}"
                                alt="Barcode {{ $siswa->nisn }}">

                            <div class="kartu-barcode-number">
                                {{ $siswa->nisn }}
                            </div>

                        @endif

                    </div>


                    <div class="kartu-footer">
                        Berlaku selama menjadi siswa
                    </div>

                </div>

            @endforeach

        </div>

    </div>

@endforeach

@endsection