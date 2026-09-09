@extends('layouts.app')

@section('title', 'Detail Siswa')

@push('styles')
<style>

    .barcode-preview {
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 12px;
        padding: 20px;
    }

    .barcode-preview img {
        display: block;
        width: 100%;
        max-width: 500px;
        height: auto;
        margin: 0 auto;
        background: #fff;
    }

    .barcode-number {
        margin-top: 8px;
        font-size: 18px;
        font-weight: 700;
        letter-spacing: 2px;
        color: #212529;
    }

    @media print {

        body * {
            visibility: hidden !important;
        }

        .barcode-print-area,
        .barcode-print-area * {
            visibility: visible !important;
        }

        .barcode-print-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            text-align: center;
            padding-top: 30px;
            background: #fff !important;
            box-shadow: none !important;
            border: 0 !important;
        }

        .barcode-print-area img {
            width: 500px;
            max-width: 90%;
            background: #fff;
        }

    }

</style>
@endpush

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 no-print">

    <div>

        <h3 class="fw-bold mb-0">

            <i class="fa-solid fa-user-graduate text-success"></i>

            Detail Siswa

        </h3>

        <small class="text-muted">

            Informasi lengkap data siswa

        </small>

    </div>

    <div>

        <button
            type="button"
            onclick="window.print()"
            class="btn btn-dark"
        >

            <i class="fa-solid fa-barcode me-1"></i>

            Cetak Barcode

        </button>

        <a
            href="{{ route('siswa.edit', $siswa) }}"
            class="btn btn-warning"
        >

            <i class="fa-solid fa-pen"></i>

            Edit

        </a>

        <a
            href="{{ route('siswa.index') }}"
            class="btn btn-secondary"
        >

            <i class="fa-solid fa-arrow-left"></i>

            Kembali

        </a>

    </div>

</div>


<div class="row no-print">

    {{-- FOTO --}}

    <div class="col-lg-4">

        <div class="card border-0 shadow-sm">

            <div class="card-body text-center">

                @if($siswa->foto)

                    <img
                        src="{{ asset('storage/'.$siswa->foto) }}"
                        width="180"
                        height="180"
                        class="rounded-circle border border-3 border-success mb-3"
                        style="object-fit: cover;"
                    >

                @else

                    <img
                        src="https://ui-avatars.com/api/?name={{ urlencode($siswa->nama) }}&background=198754&color=fff&size=200"
                        width="180"
                        height="180"
                        class="rounded-circle border border-3 border-success mb-3"
                    >

                @endif

                <h4 class="fw-bold mb-1">

                    {{ $siswa->nama }}

                </h4>

                <p class="text-muted mb-3">

                    {{ $siswa->kelas->nama_lengkap }}

                </p>

                @if($siswa->aktif)

                    <span class="badge bg-success px-3 py-2">

                        <i class="fa-solid fa-circle-check"></i>

                        Aktif

                    </span>

                @else

                    <span class="badge bg-danger px-3 py-2">

                        <i class="fa-solid fa-circle-xmark"></i>

                        Non Aktif

                    </span>

                @endif

            </div>

        </div>

    </div>


    {{-- BIODATA --}}

    <div class="col-lg-8">

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-success text-white">

                <i class="fa-solid fa-address-card"></i>

                Biodata Siswa

            </div>

            <div class="card-body">

                <table class="table table-borderless align-middle">

                    <tr>

                        <th width="180">NIS</th>

                        <td>{{ $siswa->nis }}</td>

                    </tr>

                    <tr>

                        <th>NISN</th>

                        <td>{{ $siswa->nisn }}</td>

                    </tr>

                    <tr>

                        <th>Nama Lengkap</th>

                        <td>{{ $siswa->nama }}</td>

                    </tr>

                    <tr>

                        <th>Kelas</th>

                        <td>{{ $siswa->kelas->nama_lengkap }}</td>

                    </tr>

                    <tr>

                        <th>Tempat Lahir</th>

                        <td>{{ $siswa->tempat_lahir }}</td>

                    </tr>

                    <tr>

                        <th>Tanggal Lahir</th>

                        <td>

                            {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y') }}

                        </td>

                    </tr>

                    <tr>

                        <th>Jenis Kelamin</th>

                        <td>

                            {{ $siswa->jenis_kelamin == 'L'
                                ? 'Laki-laki'
                                : 'Perempuan' }}

                        </td>

                    </tr>

                    <tr>

                        <th>Alamat</th>

                        <td>{{ $siswa->alamat }}</td>

                    </tr>

                </table>

            </div>

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- BARCODE --}}
{{-- ========================================================= --}}

<div class="card border-0 shadow-sm mt-4 barcode-print-area">

    <div class="card-header bg-dark text-white no-print">

        <i class="fa-solid fa-barcode me-2"></i>

        Barcode Siswa

    </div>

    <div class="card-body text-center">

        @if($siswa->nisn)

            @include(
                'siswa.partials.barcode',
                ['siswa' => $siswa]
            )

            <div class="text-muted mt-2 no-print">

                {{ $siswa->nama }}

            </div>

            <div class="text-muted no-print">

                {{ $siswa->kelas->nama_lengkap }}

            </div>

        @else

            <div class="alert alert-warning mb-0">

                <i class="fa-solid fa-triangle-exclamation me-2"></i>

                Siswa belum memiliki NISN.

            </div>

        @endif

    </div>

</div>

@endsection