@extends('layouts.app')

@section('title', 'Detail Siswa')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

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

        <a href="{{ route('siswa.edit', $siswa) }}" class="btn btn-warning">
            <i class="fa-solid fa-pen"></i>
            Edit
        </a>

        <a href="{{ route('siswa.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>

    </div>

</div>


<div class="row">

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
                        style="object-fit:cover;">

                @else

                    <img
                        src="https://ui-avatars.com/api/?name={{ urlencode($siswa->nama) }}&background=198754&color=fff&size=200"
                        width="180"
                        height="180"
                        class="rounded-circle border border-3 border-success mb-3">

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

                            {{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}

                        </td>

                    </tr>

                    <tr>
                        <th>Alamat</th>
                        <td>{{ $siswa->alamat }}</td>
                    </tr>

                    <tr>

                        <th>Barcode</th>

                        <td>

                            @if(class_exists('DNS1D'))

                                {!! DNS1D::getBarcodeHTML($siswa->barcode, 'C128', 2, 60) !!}

                                <div class="fw-bold mt-2">

                                    {{ $siswa->barcode }}

                                </div>

                            @else

                                <div class="alert alert-warning mb-0">

                                    <i class="fa-solid fa-triangle-exclamation"></i>

                                    Package Barcode belum diinstall.

                                </div>

                            @endif

                        </td>

                    </tr>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection