@extends('layouts.app')

@section('title', 'Data Siswa')

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

    <div>
        <h3 class="fw-bold mb-1">
            <i class="fa-solid fa-user-graduate text-success me-2"></i>
            Data Siswa
        </h3>

        <small class="text-muted">
            Kelola data siswa, kelas, status, dan identitas siswa.
        </small>
    </div>

    <div class="d-flex gap-2">

        <a href="{{ route('siswa.import') }}"
           class="btn btn-primary">

            <i class="fa-solid fa-file-import me-1"></i>
            Import Excel

        </a>

        <a href="{{ route('siswa.barcode.massal') }}"
            target="_blank"
            class="btn btn-dark">

            <i class="fa-solid fa-barcode"></i>

            Cetak Barcode

        </a>

        <a href="{{ route('siswa.kartu.massal') }}"
            target="_blank"
            class="btn btn-success">

            <i class="fa-solid fa-id-card"></i>

            Cetak Kartu Pelajar

        </a>

        <form action="{{ route('siswa.generate-barcode') }}"
            method="POST"
            class="d-inline"
            onsubmit="return confirm('Generate/update barcode semua siswa berdasarkan NISN?')">

            @csrf

            <button type="submit" class="btn btn-dark">
                <i class="fa-solid fa-barcode"></i>
                Generate Barcode
            </button>

        </form>

        <a href="{{ route('siswa.create') }}"
           class="btn btn-success">

            <i class="fa-solid fa-plus me-1"></i>
            Tambah Siswa

        </a>

    </div>

</div>


@if(session('success'))

<div class="alert alert-success alert-dismissible fade show border-0 shadow-sm"
     role="alert">

    <i class="fa-solid fa-circle-check me-2"></i>

    {{ session('success') }}

    <button type="button"
            class="btn-close"
            data-bs-dismiss="alert">
    </button>

</div>

@endif


@if(session('error'))

<div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm"
     role="alert">

    <i class="fa-solid fa-circle-exclamation me-2"></i>

    {{ session('error') }}

    <button type="button"
            class="btn-close"
            data-bs-dismiss="alert">
    </button>

</div>

@endif


<div class="card border-0 shadow-sm">

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-success">

                    <tr>

                        <th class="ps-4" width="60">No</th>

                        <th width="70">Foto</th>

                        <th>NIS</th>

                        <th>NISN</th>

                        <th>Nama</th>

                        <th>Kelas</th>

                        <th>Jabatan</th>

                        <th>Status</th>

                        <th width="150" class="text-center pe-4">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                @forelse($siswas as $index => $siswa)

                    <tr>

                        <td class="ps-4 text-muted">

                            {{ $siswas->firstItem() + $index }}

                        </td>


                        {{-- FOTO --}}

                        <td>

                            @if($siswa->foto)

                                <img
                                    src="{{ asset('storage/'.$siswa->foto) }}"
                                    width="45"
                                    height="45"
                                    class="rounded-circle border"
                                    style="object-fit:cover;"
                                    alt="{{ $siswa->nama }}">

                            @else

                                <img
                                    src="https://ui-avatars.com/api/?name={{ urlencode($siswa->nama) }}&background=198754&color=fff&size=100"
                                    width="45"
                                    height="45"
                                    class="rounded-circle"
                                    alt="{{ $siswa->nama }}">

                            @endif

                        </td>


                        {{-- NIS --}}

                        <td>

                            <span class="fw-semibold">

                                {{ $siswa->nis ?: '-' }}

                            </span>

                        </td>


                        {{-- NISN --}}

                        <td>

                            <span class="text-muted">

                                {{ $siswa->nisn ?: '-' }}

                            </span>

                        </td>


                        {{-- NAMA --}}

                        <td>

                            <div class="fw-semibold">

                                {{ $siswa->nama }}

                            </div>

                        </td>


                        {{-- KELAS --}}

                        <td>

                            @if($siswa->kelas)

                                <span class="badge bg-light text-dark border">

                                    {{ $siswa->kelas->nama_lengkap }}

                                </span>

                            @else

                                <span class="text-muted">

                                    Belum ada kelas

                                </span>

                            @endif

                        </td>


                        {{-- JABATAN --}}

                        <td>

                            @if($siswa->jabatan === 'Ketua Kelas')

                                <span class="badge bg-success">

                                    <i class="fa-solid fa-crown me-1"></i>

                                    Ketua Kelas

                                </span>

                            @elseif($siswa->jabatan === 'Wakil Ketua')

                                <span class="badge bg-warning text-dark">

                                    <i class="fa-solid fa-user-tie me-1"></i>

                                    Wakil Ketua

                                </span>

                            @elseif($siswa->jabatan === 'Sekretaris')

                                <span class="badge bg-primary">

                                    <i class="fa-solid fa-pen me-1"></i>

                                    Sekretaris

                                </span>

                            @else

                                <span class="text-muted">

                                    -

                                </span>

                            @endif

                        </td>


                        {{-- STATUS --}}

                        <td>

                            @if($siswa->aktif)

                                <span class="badge bg-success">

                                    <i class="fa-solid fa-circle-check me-1"></i>

                                    Aktif

                                </span>

                            @else

                                <span class="badge bg-danger">

                                    <i class="fa-solid fa-circle-xmark me-1"></i>

                                    Non Aktif

                                </span>

                            @endif

                        </td>


                        {{-- AKSI --}}

                        <td class="text-center">

                            {{-- BARCODE --}}
                            <a href="{{ route('siswa.qr', $siswa) }}"
                            target="_blank"
                            class="btn btn-dark btn-sm"
                            title="Lihat Barcode">

                                <i class="fa-solid fa-barcode"></i>

                            </a>

                            {{-- DETAIL --}}
                            <a href="{{ route('siswa.show', $siswa) }}"
                            class="btn btn-info btn-sm"
                            title="Detail">

                                <i class="fa-solid fa-eye"></i>

                            </a>

                            {{-- EDIT --}}
                            <a href="{{ route('siswa.edit', $siswa) }}"
                            class="btn btn-warning btn-sm"
                            title="Edit">

                                <i class="fa-solid fa-pen"></i>

                            </a>

                            {{-- HAPUS --}}
                            <form action="{{ route('siswa.destroy', $siswa) }}"
                                method="POST"
                                class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus data siswa ini?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-danger btn-sm"
                                        title="Hapus">

                                    <i class="fa-solid fa-trash"></i>

                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="9"
                            class="text-center text-muted py-5">

                            <i class="fa-solid fa-users-slash fa-2x mb-3 d-block"></i>

                            <div class="fw-semibold">

                                Belum ada data siswa.

                            </div>

                            <small>

                                Silakan tambahkan siswa baru atau import melalui Excel.

                            </small>

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}

        @if($siswas->hasPages())

            <div class="p-3 border-top">

                {{ $siswas->links() }}

            </div>

        @endif

    </div>

</div>

@endsection