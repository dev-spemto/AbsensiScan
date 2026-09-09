@extends('layouts.app')

@section('title', 'Cetak Barcode Siswa')

@push('styles')
<style>

.print-header {
    margin-bottom: 25px;
}

.barcode-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.barcode-card {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    break-inside: avoid;
}

.barcode-card img {
    width: 100%;
    max-width: 420px;
    height: auto;
}

.barcode-number {
    font-size: 17px;
    font-weight: 700;
    letter-spacing: 2px;
    margin-top: 8px;
}

.barcode-name {
    font-weight: 600;
    margin-top: 5px;
}

.barcode-class {
    color: #6c757d;
    font-size: 14px;
}

@media print {

    @page {
        size: A4;
        margin: 10mm;
    }

    body {
        background: #fff !important;
    }

    .sidebar,
    .topbar,
    .no-print,
    .page > .print-header {
        display: none !important;
    }

    .content {
        width: 100% !important;
    }

    .page {
        padding: 0 !important;
    }

    .barcode-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 8mm;
    }

    .barcode-card {
        border: 1px solid #000;
        border-radius: 4px;
        padding: 8mm 5mm;
    }

    .barcode-card img {
        width: 100%;
        max-width: none;
    }

}

@media screen and (max-width: 768px) {

    .barcode-grid {
        grid-template-columns: 1fr;
    }

}

</style>
@endpush

@section('content')

<div class="print-header no-print">

    <div class="d-flex justify-content-between align-items-center">

        <div>

            <h3 class="fw-bold mb-1">

                <i class="fa-solid fa-barcode text-success"></i>

                Cetak Barcode Siswa

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


@if($siswas->count())

    <div class="barcode-grid">

        @foreach($siswas as $siswa)

            <div class="barcode-card">

                <img
                    src="{{ route('siswa.qr', $siswa) }}"
                    alt="Barcode {{ $siswa->nisn }}">

                <div class="barcode-number">

                    {{ $siswa->nisn }}

                </div>

                <div class="barcode-name">

                    {{ $siswa->nama }}

                </div>

                <div class="barcode-class">

                    {{ $siswa->kelas->nama_lengkap }}

                </div>

            </div>

        @endforeach

    </div>

@else

    <div class="alert alert-warning">

        Belum ada siswa aktif.

    </div>

@endif

@endsection