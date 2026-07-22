@extends('layouts.app')

@section('title','Rekap Presensi')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="fw-bold mb-1">

            <i class="fa-solid fa-chart-column text-success"></i>

            Rekap Presensi

        </h3>

        <small class="text-muted">

            Rekap seluruh data presensi siswa

        </small>

    </div>

</div>

{{-- Statistik --}}

<div class="row g-3 mb-4">

    <div class="col-lg-2 col-md-4">

        <div class="card border-0 shadow-sm">

            <div class="card-body text-center">

                <h3 class="fw-bold text-dark">

                    {{ $totalData }}

                </h3>

                <small class="text-muted">

                    Total Data

                </small>

            </div>

        </div>

    </div>

    <div class="col-lg-2 col-md-4">

        <div class="card border-success shadow-sm">

            <div class="card-body text-center">

                <h3 class="fw-bold text-success">

                    {{ $hadir }}

                </h3>

                <small>

                    Hadir

                </small>

            </div>

        </div>

    </div>

    <div class="col-lg-2 col-md-4">

        <div class="card border-warning shadow-sm">

            <div class="card-body text-center">

                <h3 class="fw-bold text-warning">

                    {{ $terlambat }}

                </h3>

                <small>

                    Terlambat

                </small>

            </div>

        </div>

    </div>

    <div class="col-lg-2 col-md-4">

        <div class="card border-primary shadow-sm">

            <div class="card-body text-center">

                <h3 class="fw-bold text-primary">

                    {{ $izin }}

                </h3>

                <small>

                    Izin

                </small>

            </div>

        </div>

    </div>

    <div class="col-lg-2 col-md-4">

        <div class="card border-info shadow-sm">

            <div class="card-body text-center">

                <h3 class="fw-bold text-info">

                    {{ $sakit }}

                </h3>

                <small>

                    Sakit

                </small>

            </div>

        </div>

    </div>

    <div class="col-lg-2 col-md-4">

        <div class="card border-danger shadow-sm">

            <div class="card-body text-center">

                <h3 class="fw-bold text-danger">

                    {{ $alpha }}

                </h3>

                <small>

                    Alpha

                </small>

            </div>

        </div>

    </div>

</div>

{{-- Filter --}}

<div class="card border-0 shadow-sm mb-4">

    <div class="card-header bg-success text-white">

        <i class="fa-solid fa-filter"></i>

        Filter Rekap

    </div>

    <div class="card-body">

        <form method="GET" action="{{ route('rekap.index') }}">

            <div class="row">

                <div class="col-md-3 mb-3">

                    <label class="form-label">

                        Tanggal

                    </label>

                    <input
                        type="date"
                        name="tanggal"
                        class="form-control"
                        value="{{ request('tanggal') }}">

                </div>

                <div class="col-md-3 mb-3">

                    <label class="form-label">

                        Kelas

                    </label>

                    <select
                        name="kelas"
                        class="form-select">

                        <option value="">

                            Semua Kelas

                        </option>

                        @foreach($kelas as $k)

                            <option
                                value="{{ $k->id }}"
                                {{ request('kelas')==$k->id ? 'selected':'' }}>

                                {{ $k->nama_lengkap }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-md-3 mb-3">

                    <label class="form-label">

                        Guru

                    </label>

                    <select
                        name="guru"
                        class="form-select">

                        <option value="">

                            Semua Guru

                        </option>

                        @foreach($gurus as $guru)

                            <option
                                value="{{ $guru->id }}"
                                {{ request('guru')==$guru->id ? 'selected':'' }}>

                                {{ $guru->nama }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-md-3 mb-3">

                    <label class="form-label">

                        Status

                    </label>

                    <select
                        name="status"
                        class="form-select">

                        <option value="">Semua</option>

                        <option value="Hadir" {{ request('status')=='Hadir' ? 'selected' : '' }}>Hadir</option>

                        <option value="Terlambat" {{ request('status')=='Terlambat' ? 'selected' : '' }}>Terlambat</option>

                        <option value="Izin" {{ request('status')=='Izin' ? 'selected' : '' }}>Izin</option>

                        <option value="Sakit" {{ request('status')=='Sakit' ? 'selected' : '' }}>Sakit</option>

                        <option value="Alpha" {{ request('status')=='Alpha' ? 'selected' : '' }}>Alpha</option>

                    </select>

                </div>

            </div>

            <div class="d-flex flex-wrap gap-2">

                <button class="btn btn-success">

                    <i class="fa-solid fa-magnifying-glass"></i>

                    Tampilkan

                </button>

                <a href="{{ route('rekap.index') }}"
                   class="btn btn-secondary">

                    <i class="fa-solid fa-rotate-left"></i>

                    Reset

                </a>

                <a href="{{ route('rekap.export.excel', request()->query()) }}"
                   class="btn btn-success">

                    <i class="fa-solid fa-file-excel"></i>

                    Export Excel

                </a>

                <a href="{{ route('rekap.export.pdf', request()->query()) }}"
                   class="btn btn-danger">

                    <i class="fa-solid fa-file-pdf"></i>

                    Export PDF

                </a>

                <a href="{{ route('rekap.print', request()->query()) }}"
                   target="_blank"
                   class="btn btn-dark">

                    <i class="fa-solid fa-print"></i>

                    Print

                </a>

            </div>

        </form>

    </div>

</div>

{{-- Tabel --}}

<div class="card border-0 shadow-sm">

    <div class="card-header bg-success text-white">

        <i class="fa-solid fa-table"></i>

        Hasil Rekap

    </div>

    <div class="table-responsive">

        <table class="table table-hover align-middle mb-0">

            <thead class="table-light">

                <tr>

                    <th>No</th>

                    <th>Tanggal</th>

                    <th>Jam</th>

                    <th>Nama</th>

                    <th>Kelas</th>

                    <th>Guru</th>

                    <th>Status</th>

                </tr>

            </thead>

            <tbody>

                @php

                    $warna = [

                        'Hadir' => 'success',
                        'Terlambat' => 'warning',
                        'Izin' => 'primary',
                        'Sakit' => 'info',
                        'Alpha' => 'danger',

                    ];

                @endphp

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

                            {{ $presensi->siswa->nama }}

                        </td>

                        <td>

                            {{ $presensi->siswa->kelas->nama_lengkap }}

                        </td>

                        <td>

                            {{ $presensi->guru->nama }}

                        </td>

                        <td>

                            <span class="badge bg-{{ $warna[$presensi->status] ?? 'secondary' }}">

                                {{ $presensi->status }}

                            </span>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7" class="text-center py-5 text-muted">

                            <i class="fa-solid fa-folder-open fa-2x mb-3"></i>

                            <br>

                            Belum ada data presensi.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    @if($presensis->hasPages())

        <div class="card-footer bg-white">

            {{ $presensis->links() }}

        </div>

    @endif

</div>

@endsection