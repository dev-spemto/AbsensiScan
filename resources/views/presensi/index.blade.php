@extends('layouts.app')

@section('title', 'Data Presensi')

@section('content')

@php

$statusColor = [
    'Hadir' => 'success',
    'Terlambat' => 'warning',
    'Izin' => 'primary',
    'Sakit' => 'info',
    'Alpha' => 'danger',
];

@endphp

<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

    <div>

        <h3 class="fw-bold mb-1">

            <i class="fa-solid fa-calendar-check text-success"></i>

            Data Presensi

        </h3>

        <small class="text-muted">

            Riwayat seluruh presensi siswa

        </small>

    </div>

    <div class="d-flex gap-2">

        <a href="{{ route('rekap.index') }}"
           class="btn btn-outline-success">

            <i class="fa-solid fa-chart-column"></i>

            Rekap

        </a>

        <a href="{{ route('presensi.create') }}"
           class="btn btn-success">

            <i class="fa-solid fa-barcode"></i>

            Scan Presensi

        </a>

    </div>

</div>

@if(session('success'))

<div class="alert alert-success alert-dismissible fade show">

    <i class="fa-solid fa-circle-check me-2"></i>

    {{ session('success') }}

    <button class="btn-close"
            data-bs-dismiss="alert"></button>

</div>

@endif

@if(session('error'))

<div class="alert alert-danger alert-dismissible fade show">

    <i class="fa-solid fa-circle-xmark me-2"></i>

    {{ session('error') }}

    <button class="btn-close"
            data-bs-dismiss="alert"></button>

</div>

@endif

<div class="row g-3 mb-4">

    <div class="col-lg-3 col-md-6">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <small class="text-muted">

                            Total Presensi

                        </small>

                        <h2 class="fw-bold mb-0">

                            {{ $presensis->total() }}

                        </h2>

                    </div>

                    <div class="fs-1 text-success">

                        <i class="fa-solid fa-calendar-check"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-3 col-md-6">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <small class="text-muted">

                            Hadir

                        </small>

                        <h2 class="fw-bold text-success mb-0">

                            {{ $presensis->where('status','Hadir')->count() }}

                        </h2>

                    </div>

                    <div class="fs-1 text-success">

                        <i class="fa-solid fa-user-check"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-3 col-md-6">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <small class="text-muted">

                            Terlambat

                        </small>

                        <h2 class="fw-bold text-warning mb-0">

                            {{ $presensis->where('status','Terlambat')->count() }}

                        </h2>

                    </div>

                    <div class="fs-1 text-warning">

                        <i class="fa-solid fa-clock"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-3 col-md-6">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <small class="text-muted">

                            Alpha

                        </small>

                        <h2 class="fw-bold text-danger mb-0">

                            {{ $presensis->where('status','Alpha')->count() }}

                        </h2>

                    </div>

                    <div class="fs-1 text-danger">

                        <i class="fa-solid fa-user-xmark"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<div class="card border-0 shadow-sm mb-4">

    <div class="card-header bg-success text-white">

        <i class="fa-solid fa-filter"></i>

        Filter Data Presensi

    </div>

    <div class="card-body">

        <form method="GET"
              action="{{ route('presensi.index') }}">

            <div class="row">

                <div class="col-md-3 mb-3">

                    <label class="form-label">

                        Tanggal

                    </label>

                    <input type="date"
                           name="tanggal"
                           class="form-control"
                           value="{{ request('tanggal') }}">

                </div>

                <div class="col-md-3 mb-3">

                    <label class="form-label">

                        Nama Siswa

                    </label>

                    <input type="text"
                           name="keyword"
                           class="form-control"
                           placeholder="Cari nama siswa..."
                           value="{{ request('keyword') }}">

                </div>

                <div class="col-md-3 mb-3">

                    <label class="form-label">

                        Status

                    </label>

                    <select name="status"
                            class="form-select">

                        <option value="">Semua</option>

                        <option value="Hadir"
                            {{ request('status')=='Hadir'?'selected':'' }}>
                            Hadir
                        </option>

                        <option value="Terlambat"
                            {{ request('status')=='Terlambat'?'selected':'' }}>
                            Terlambat
                        </option>

                        <option value="Izin"
                            {{ request('status')=='Izin'?'selected':'' }}>
                            Izin
                        </option>

                        <option value="Sakit"
                            {{ request('status')=='Sakit'?'selected':'' }}>
                            Sakit
                        </option>

                        <option value="Alpha"
                            {{ request('status')=='Alpha'?'selected':'' }}>
                            Alpha
                        </option>

                    </select>

                </div>

                <div class="col-md-3 mb-3 d-flex align-items-end">

                    <div class="d-grid gap-2 w-100">

                        <button class="btn btn-success">

                            <i class="fa-solid fa-magnifying-glass"></i>

                            Tampilkan

                        </button>

                        <a href="{{ route('presensi.index') }}"
                           class="btn btn-secondary">

                            <i class="fa-solid fa-rotate-left"></i>

                            Reset

                        </a>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>

<div class="card border-0 shadow-sm">

    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">

        <div>

            <i class="fa-solid fa-table"></i>

            Riwayat Presensi

        </div>

        <span class="badge bg-light text-dark">

            {{ $presensis->total() }} Data

        </span>

    </div>

    <div class="table-responsive">

        <table class="table table-hover align-middle mb-0">

            <thead class="table-light">

                <tr>

                    <th width="60">No</th>

                    <th>Tanggal</th>

                    <th>Jam</th>

                    <th>Nama</th>

                    <th>Kelas</th>

                    <th>Guru</th>

                    <th>Status</th>

                    <th>Metode</th>

                    <th width="170" class="text-center">

                        Aksi

                    </th>

                </tr>

            </thead>

            <tbody>

            @forelse($presensis as $index => $presensi)

<tr>

    <td>

        {{ $presensis->firstItem() + $index }}

    </td>

    <td>

        {{ \Carbon\Carbon::parse($presensi->tanggal)->format('d-m-Y') }}

    </td>

    <td>

        {{ substr($presensi->jam_scan,0,5) }}

    </td>

    <td>

        <div class="d-flex align-items-center">

            <img src="{{ $presensi->siswa->foto
                ? asset('storage/'.$presensi->siswa->foto)
                : 'https://ui-avatars.com/api/?name='.urlencode($presensi->siswa->nama) }}"
                 width="40"
                 height="40"
                 class="rounded-circle me-2"
                 style="object-fit:cover;">

            <div>

                <div class="fw-semibold">

                    {{ $presensi->siswa->nama }}

                </div>

                <small class="text-muted">

                    {{ $presensi->siswa->nisn }}

                </small>

            </div>

        </div>

    </td>

    <td>

        {{ $presensi->siswa->kelas->nama_lengkap }}

    </td>

    <td>

        {{ $presensi->guru->nama }}

    </td>

    <td>

        <span class="badge bg-{{ $statusColor[$presensi->status] ?? 'secondary' }}">

            {{ $presensi->status }}

        </span>

    </td>

    <td>

        <span class="badge bg-dark">

            {{ $presensi->metode }}

        </span>

    </td>

    <td class="text-center">

        <div class="btn-group">

            <a href="{{ route('presensi.show',$presensi) }}"
               class="btn btn-sm btn-outline-primary">

                <i class="fa-solid fa-eye"></i>

            </a>

            @if(auth()->user()->isAdmin())

            <a href="{{ route('presensi.edit',$presensi) }}"
               class="btn btn-sm btn-outline-warning">

                <i class="fa-solid fa-pen"></i>

            </a>

            <form action="{{ route('presensi.destroy',$presensi) }}"
                  method="POST"
                  class="d-inline"
                  onsubmit="return confirm('Yakin ingin menghapus data presensi ini?')">

                @csrf
                @method('DELETE')

                <button class="btn btn-sm btn-outline-danger">

                    <i class="fa-solid fa-trash"></i>

                </button>

            </form>

            @endif

        </div>

    </td>

</tr>

@empty

<tr>

    <td colspan="9" class="text-center py-5">

        <i class="fa-solid fa-calendar-xmark fa-3x text-secondary mb-3"></i>

        <br>

        <span class="text-muted">

            Belum ada data presensi.

        </span>

    </td>

</tr>

@endforelse

            </tbody>

        </table>

    </div>

    @if($presensis->hasPages())

    <div class="card-footer bg-white">

        <div class="d-flex justify-content-between align-items-center flex-wrap">

            <small class="text-muted">

                Menampilkan

                {{ $presensis->firstItem() }}

                -

                {{ $presensis->lastItem() }}

                dari

                {{ $presensis->total() }}

                data

            </small>

            <div>

                {{ $presensis->withQueryString()->links() }}

            </div>

        </div>

    </div>

    @endif

</div>

<div class="card border-0 shadow-sm mt-4">

    <div class="card-header bg-light">

        <i class="fa-solid fa-circle-info text-success"></i>

        Informasi

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-4">

                <div class="border rounded p-3 h-100">

                    <div class="fw-bold text-success mb-2">

                        <i class="fa-solid fa-barcode"></i>

                        Scan Barcode

                    </div>

                    <small class="text-muted">

                        Digunakan untuk mencatat kehadiran siswa melalui
                        barcode kartu identitas.

                    </small>

                </div>

            </div>

            <div class="col-md-4">

                <div class="border rounded p-3 h-100">

                    <div class="fw-bold text-primary mb-2">

                        <i class="fa-solid fa-user-check"></i>

                        Status Presensi

                    </div>

                    <small class="text-muted">

                        Status akan ditampilkan sesuai hasil presensi
                        (Hadir, Terlambat, Izin, Sakit, atau Alpha).

                    </small>

                </div>

            </div>

            <div class="col-md-4">

                <div class="border rounded p-3 h-100">

                    <div class="fw-bold text-danger mb-2">

                        <i class="fa-solid fa-shield-halved"></i>

                        Hak Akses

                    </div>

                    <small class="text-muted">

                        Guru hanya dapat melihat data,
                        sedangkan Administrator dapat mengubah
                        dan menghapus data presensi.

                    </small>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection