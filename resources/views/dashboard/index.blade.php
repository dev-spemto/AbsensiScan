@extends('layouts.app')

@section('title','Dashboard')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="fw-bold mb-1">

            <i class="fa-solid fa-house text-success"></i>

            Dashboard

        </h3>

        <small class="text-muted">

            Selamat datang di Sistem Presensi Siswa

        </small>

    </div>

    <div class="text-end">

        <div class="fw-bold">

            {{ now()->translatedFormat('l, d F Y') }}

        </div>

        <small class="text-muted">

            Tahun Ajaran :
            <strong>

                {{ $tahunAjaran->tahun ?? '-' }}

            </strong>

        </small>

    </div>

</div>

<div class="row g-4">

    <div class="col-lg-3 col-md-6">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body d-flex align-items-center">

                <div class="rounded-circle bg-success text-white d-flex justify-content-center align-items-center"
                     style="width:65px;height:65px;">

                    <i class="fa-solid fa-user-graduate fa-2x"></i>

                </div>

                <div class="ms-3">

                    <h2 class="fw-bold mb-0">

                        {{ $totalSiswa }}

                    </h2>

                    <small class="text-muted">

                        Total Siswa

                    </small>

                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-3 col-md-6">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body d-flex align-items-center">

                <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center"
                     style="width:65px;height:65px;">

                    <i class="fa-solid fa-chalkboard-user fa-2x"></i>

                </div>

                <div class="ms-3">

                    <h2 class="fw-bold mb-0">

                        {{ $totalGuru }}

                    </h2>

                    <small class="text-muted">

                        Guru Aktif

                    </small>

                </div>

            </div>

        </div>

    </div>

    @if(auth()->user()->role == 'admin')

    <div class="col-lg-3 col-md-6">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body d-flex align-items-center">

                <div class="rounded-circle bg-warning text-white d-flex justify-content-center align-items-center"
                     style="width:65px;height:65px;">

                    <i class="fa-solid fa-school fa-2x"></i>

                </div>

                <div class="ms-3">

                    <h2 class="fw-bold mb-0">

                        {{ $totalKelas }}

                    </h2>

                    <small class="text-muted">

                        Total Kelas

                    </small>

                </div>

            </div>

        </div>

    </div>

    @endif

    <div class="col-lg-3 col-md-6">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body d-flex align-items-center">

                <div class="rounded-circle bg-danger text-white d-flex justify-content-center align-items-center"
                     style="width:65px;height:65px;">

                    <i class="fa-solid fa-calendar-check fa-2x"></i>

                </div>

                <div class="ms-3">

                    <h2 class="fw-bold mb-0">

                        {{ $presensiHariIni }}

                    </h2>

                    <small class="text-muted">

                        Presensi Hari Ini

                    </small>

                </div>

            </div>

        </div>

    </div>

</div>

<div class="row g-3 mt-2">

    <div class="col-lg col-md-4">

        <div class="card border-success">

            <div class="card-body text-center">

                <h3 class="text-success fw-bold">{{ $hadirHariIni }}</h3>

                <small>Hadir</small>

            </div>

        </div>

    </div>

    <div class="col-lg col-md-4">

        <div class="card border-warning">

            <div class="card-body text-center">

                <h3 class="text-warning fw-bold">{{ $terlambatHariIni }}</h3>

                <small>Terlambat</small>

            </div>

        </div>

    </div>

    <div class="col-lg col-md-4">

        <div class="card border-primary">

            <div class="card-body text-center">

                <h3 class="text-primary fw-bold">{{ $izinHariIni }}</h3>

                <small>Izin</small>

            </div>

        </div>

    </div>

    <div class="col-lg col-md-6">

        <div class="card border-info">

            <div class="card-body text-center">

                <h3 class="text-info fw-bold">{{ $sakitHariIni }}</h3>

                <small>Sakit</small>

            </div>

        </div>

    </div>

    <div class="col-lg col-md-6">

        <div class="card border-danger">

            <div class="card-body text-center">

                <h3 class="text-danger fw-bold">{{ $alphaHariIni }}</h3>

                <small>Alpha</small>

            </div>

        </div>

    </div>

</div>

<div class="card border-0 shadow-sm mt-4">

    <div class="card-header bg-success text-white">

        <i class="fa-solid fa-clock-rotate-left"></i>

        10 Presensi Terbaru

    </div>

    <div class="table-responsive">

        <table class="table table-hover align-middle mb-0">

            <thead class="table-light">

                <tr>

                    <th>No</th>

                    <th>Jam</th>

                    <th>Nama</th>

                    <th>Kelas</th>

                    <th>Status</th>

                    <th>Guru</th>

                </tr>

            </thead>

            <tbody>

                @php

                    $warna = [
                        'Hadir'=>'success',
                        'Terlambat'=>'warning',
                        'Izin'=>'primary',
                        'Sakit'=>'info',
                        'Alpha'=>'danger',
                    ];

                @endphp

                @forelse($presensiTerbaru as $index => $presensi)

                <tr>

                    <td>{{ $index + 1 }}</td>

                    <td>{{ substr($presensi->jam_scan,0,5) }}</td>

                    <td><strong>{{ $presensi->siswa->nama }}</strong></td>

                    <td>{{ $presensi->siswa->kelas->nama_lengkap }}</td>

                    <td>

                        <span class="badge bg-{{ $warna[$presensi->status] ?? 'secondary' }}">

                            {{ $presensi->status }}

                        </span>

                    </td>

                    <td>{{ $presensi->guru->nama }}</td>

                </tr>

                @empty

                <tr>

                    <td colspan="6" class="text-center py-5">

                        Belum ada data presensi.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

<div class="card border-0 shadow-sm mt-4">

    <div class="card-body">

        <h5 class="fw-bold">

            Selamat Datang 👋

        </h5>

        @if(auth()->user()->role == 'admin')

            <p class="mb-0">

                Anda login sebagai <strong>Administrator</strong>.
                Kelola data siswa, guru, presensi, rekap serta laporan melalui menu di sebelah kiri.

            </p>

        @else

            <p class="mb-0">

                Anda login sebagai <strong>Guru</strong>.
                Silakan melakukan presensi siswa dan melihat rekap presensi.

            </p>

        @endif

    </div>

</div>

@endsection