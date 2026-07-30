@extends('layouts.app')

@section('title','Import Data Siswa')

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">

    <i class="fa-solid fa-circle-check me-2"></i>

    {{ session('success') }}

    <button type="button"
            class="btn-close"
            data-bs-dismiss="alert"></button>

</div>
@endif

@if ($errors->any())

<div class="alert alert-danger alert-dismissible fade show">

    <i class="fa-solid fa-circle-exclamation me-2"></i>

    {{ $errors->first() }}

    <button type="button"
            class="btn-close"
            data-bs-dismiss="alert"></button>

</div>

@endif

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="fw-bold mb-0">

            <i class="fa-solid fa-file-import text-primary"></i>

            Import Data Siswa

        </h3>

        <small class="text-muted">

            Upload file Excel untuk menambahkan data siswa sekaligus.

        </small>

    </div>

    <div>

        <a href="{{ route('siswa.import.template') }}" class="btn btn-outline-success">

            <i class="fa-solid fa-download"></i>

            Download Template

        </a>

        <a href="{{ route('siswa.index') }}" class="btn btn-secondary">

            <i class="fa-solid fa-arrow-left"></i>

            Kembali

        </a>

    </div>

</div>

<div class="card border-0 shadow-sm">

    <div class="card-body">

        <form action="{{ route('siswa.import.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="text-center mb-4">

                <i class="fa-solid fa-file-excel text-success"
                   style="font-size:70px;"></i>

                <h5 class="mt-3">

                    Pilih File Excel

                </h5>

                <p class="text-muted">

                    Format yang didukung:
                    <strong>.xlsx</strong>,
                    <strong>.xls</strong>,
                    <strong>.csv</strong>

                </p>

            </div>

            <div class="mb-4">

                <input type="file"
                       name="file"
                       class="form-control form-control-lg"
                       accept=".xlsx,.xls,.csv"
                       required>

            </div>

            <div class="alert alert-info">

                <strong>Format Kolom Excel</strong>

                <hr>

                <ol class="mb-0">

                    <li>NIS</li>
                    <li>NISN</li>
                    <li>Nama</li>
                    <li>Tempat Lahir</li>
                    <li>Tanggal Lahir (YYYY-MM-DD)</li>
                    <li>Jenis Kelamin (L / P)</li>
                    <li>Alamat</li>
                    <li>Kelas (7A, 7B, 8A, 9A, dst)</li>

                </ol>

            </div>

            <div class="d-grid">

                <button type="submit" class="btn btn-success btn-lg">

                    <i class="fa-solid fa-upload"></i>

                    Import Sekarang

                </button>

            </div>

        </form>

    </div>

</div>

@endsection