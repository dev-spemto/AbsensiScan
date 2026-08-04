@extends('layouts.app')

@section('title','Dashboard')

@section('content')

{{-- ====================================================== --}}
{{-- Statistik Utama --}}
{{-- ====================================================== --}}

<div class="row g-3 mb-4">

    <div class="col-xl-3 col-md-6">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <div class="text-muted small">

                            Total Siswa

                        </div>

                        <h2 class="fw-bold text-success mb-0">

                            {{ number_format($totalSiswa) }}

                        </h2>

                    </div>

                    <div class="rounded-circle bg-success bg-opacity-10 p-3">

                        <i class="fa-solid fa-user-graduate fa-2x text-success"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="col-xl-3 col-md-6">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <div class="text-muted small">

                            Total Guru

                        </div>

                        <h2 class="fw-bold text-primary mb-0">

                            {{ number_format($totalGuru) }}

                        </h2>

                    </div>

                    <div class="rounded-circle bg-primary bg-opacity-10 p-3">

                        <i class="fa-solid fa-chalkboard-user fa-2x text-primary"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="col-xl-3 col-md-6">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <div class="text-muted small">

                            Total Kelas

                        </div>

                        <h2 class="fw-bold text-warning mb-0">

                            {{ number_format($totalKelas) }}

                        </h2>

                    </div>

                    <div class="rounded-circle bg-warning bg-opacity-10 p-3">

                        <i class="fa-solid fa-school fa-2x text-warning"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="col-xl-3 col-md-6">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <div class="text-muted small">

                            Presensi Hari Ini

                        </div>

                        <h2 class="fw-bold text-info mb-0">

                            {{ $totalScanHariIni }}

                        </h2>

                    </div>

                    <div class="rounded-circle bg-info bg-opacity-10 p-3">

                        <i class="fa-solid fa-calendar-check fa-2x text-info"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

{{-- ====================================================== --}}
{{-- Status Hari Ini --}}
{{-- ====================================================== --}}

<div class="row g-3 mb-4">

    <div class="col-lg-2 col-md-4 col-6">

        <div class="card border-0 shadow-sm text-center h-100">

            <div class="card-body">

                <i class="fa-solid fa-circle-check text-success fa-2x mb-2"></i>

                <h3 class="fw-bold text-success">

                    {{ $hadirHariIni }}

                </h3>

                <div class="small text-muted">

                    Hadir

                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-2 col-md-4 col-6">

        <div class="card border-0 shadow-sm text-center h-100">

            <div class="card-body">

                <i class="fa-solid fa-clock text-danger fa-2x mb-2"></i>

                <h3 class="fw-bold text-danger">

                    {{ $terlambatHariIni }}

                </h3>

                <div class="small text-muted">

                    Terlambat

                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-2 col-md-4 col-6">

        <div class="card border-0 shadow-sm text-center h-100">

            <div class="card-body">

                <i class="fa-solid fa-envelope-open-text text-warning fa-2x mb-2"></i>

                <h3 class="fw-bold text-warning">

                    {{ $izinHariIni }}

                </h3>

                <div class="small text-muted">

                    Izin

                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-2 col-md-4 col-6">

        <div class="card border-0 shadow-sm text-center h-100">

            <div class="card-body">

                <i class="fa-solid fa-notes-medical text-info fa-2x mb-2"></i>

                <h3 class="fw-bold text-info">

                    {{ $sakitHariIni }}

                </h3>

                <div class="small text-muted">

                    Sakit

                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-2 col-md-4 col-6">

        <div class="card border-0 shadow-sm text-center h-100">

            <div class="card-body">

                <i class="fa-solid fa-user-xmark text-secondary fa-2x mb-2"></i>

                <h3 class="fw-bold">

                    {{ $alphaHariIni }}

                </h3>

                <div class="small text-muted">

                    Alpha

                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-2 col-md-4 col-6">

        <div class="card border-0 shadow-sm text-center h-100">

            <div class="card-body">

                <i class="fa-solid fa-user-clock text-dark fa-2x mb-2"></i>

                <h3 class="fw-bold text-dark">

                    {{ $belumPresensiHariIni }}

                </h3>

                <div class="small text-muted">

                    Belum Scan

                </div>

            </div>

        </div>

    </div>

</div>

{{-- ====================================================== --}}
{{-- Ringkasan Dashboard --}}
{{-- ====================================================== --}}

<div class="row g-3 mb-4">

    {{-- Ringkasan Hari Ini --}}

    <div class="col-lg-4">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-header bg-success text-white">

                <i class="fa-solid fa-chart-pie me-2"></i>

                Ringkasan Hari Ini

            </div>

            <div class="card-body">

                <div class="mb-4">

                    <div class="d-flex justify-content-between mb-2">

                        <span>

                            Persentase Kehadiran

                        </span>

                        <strong>

                            {{ $persentaseHadir }}%

                        </strong>

                    </div>

                    <div class="progress" style="height:12px">

                        <div
                            class="progress-bar bg-success"
                            style="width:{{ $persentaseHadir }}%">

                        </div>

                    </div>

                </div>

                <table class="table table-sm align-middle mb-0">

                    <tr>

                        <td>Total Scan</td>

                        <th class="text-end">

                            {{ $totalScanHariIni }}

                        </th>

                    </tr>

                    <tr>

                        <td>Belum Scan</td>

                        <th class="text-end text-danger">

                            {{ $belumPresensiHariIni }}

                        </th>

                    </tr>

                    <tr>

                        <td>Hadir</td>

                        <th class="text-end text-success">

                            {{ $hadirHariIni }}

                        </th>

                    </tr>

                    <tr>

                        <td>Terlambat</td>

                        <th class="text-end text-danger">

                            {{ $terlambatHariIni }}

                        </th>

                    </tr>

                    <tr>

                        <td>Izin</td>

                        <th class="text-end text-warning">

                            {{ $izinHariIni }}

                        </th>

                    </tr>

                    <tr>

                        <td>Sakit</td>

                        <th class="text-end text-info">

                            {{ $sakitHariIni }}

                        </th>

                    </tr>

                    <tr>

                        <td>Alpha</td>

                        <th class="text-end">

                            {{ $alphaHariIni }}

                        </th>

                    </tr>

                </table>

            </div>

        </div>

    </div>

    {{-- Grafik --}}

    <div class="col-lg-5">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-header bg-primary text-white">

                <i class="fa-solid fa-chart-line me-2"></i>

                Grafik Presensi 7 Hari Terakhir

            </div>

            <div class="card-body">

                <div style="height:320px">

                    <canvas id="grafikPresensi"></canvas>

                </div>

            </div>

        </div>

    </div>

    {{-- Sidebar Statistik --}}

    <div class="col-lg-3">

        <div class="card border-0 shadow-sm mb-3">

            <div class="card-header bg-warning">

                <strong>

                    🏆 Kelas Teraktif

                </strong>

            </div>

            <div class="card-body">

                @if($kelasTeraktif)

                    <h5 class="fw-bold">

                        {{ $kelasTeraktif->nama_lengkap }}

                    </h5>

                    <div class="text-muted">

                        {{ $kelasTeraktif->hadir_hari_ini }}

                        siswa hadir hari ini

                    </div>

                @else

                    <div class="text-muted">

                        Belum ada data.

                    </div>

                @endif

            </div>

        </div>

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-success text-white">

                Aktivitas Terakhir

            </div>

            <div class="card-body">

                @if($presensiTerbaru)

                    <h6 class="fw-bold mb-1">

                        {{ $presensiTerbaru->siswa->nama }}

                    </h6>

                    <div class="small text-muted">

                        {{ optional($presensiTerbaru->siswa->kelas)->nama_lengkap }}

                    </div>

                    <hr>

                    <div>

                        <strong>Jam Scan</strong>

                        <br>

                        {{ $presensiTerbaru->jam_scan }}

                    </div>

                    <div class="mt-3">

                        <span class="badge bg-success fs-6">

                            {{ $presensiTerbaru->status }}

                        </span>

                    </div>

                @else

                    <div class="text-muted">

                        Belum ada aktivitas.

                    </div>

                @endif

            </div>

        </div>

    </div>

</div>

{{-- ====================================================== --}}
{{-- Presensi Terakhir --}}
{{-- ====================================================== --}}

<div class="card border-0 shadow-sm">

    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">

        <div>

            <i class="fa-solid fa-clock-rotate-left me-2"></i>

            10 Presensi Terakhir

        </div>

        <span class="badge bg-light text-success">

            {{ $presensiTerakhir->count() }} Data

        </span>

    </div>

    <div class="table-responsive">

        <style>

            #dashboard-presensi-table tbody tr{

                transition:.18s;

            }

            #dashboard-presensi-table tbody tr:hover{

                transform:scale(1.003);

            }

        </style>

    <style>

        .table td{

            vertical-align:middle;

        }

    </style>

        <table
            id="dashboard-presensi-table"
            class="table table-hover align-middle mb-0">

            <thead class="table-light">

                <tr>

                    <th width="90">

                        Jam

                    </th>

                    <th>

                        Nama Siswa

                    </th>

                    <th>

                        Kelas

                    </th>

                    <th>

                        Status

                    </th>

                    <th>

                        Scan Oleh

                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($presensiTerakhir as $item)

                    @php

                        $warna = match($item->status){

                            'Hadir'      => 'success',

                            'Terlambat'  => 'danger',

                            'Izin'       => 'warning',

                            'Sakit'      => 'info',

                            'Alpha'      => 'secondary',

                            default      => 'dark'

                        };

                    @endphp

                    <tr>

                        <td>

                            <strong>

                                {{ $item->jam_scan }}

                            </strong>

                        </td>

                        <td>

                            <div class="d-flex align-items-center">

                                <img
                                    src="{{ $item->siswa->foto
                                        ? asset('storage/'.$item->siswa->foto)
                                        : asset('images/avatar-default.png') }}"
                                    width="42"
                                    height="42"
                                    class="rounded-circle me-3">

                                <div>

                                    <div class="fw-semibold">

                                        {{ $item->siswa->nama }}

                                    </div>

                                    <small class="text-muted">

                                        {{ $item->siswa->nisn }}

                                    </small>

                                </div>

                            </div>

                        </td>

                        <td>

                            <span class="badge bg-light text-dark border">

                                {{ optional($item->siswa->kelas)->nama_lengkap ?? '-' }}

                            </span>

                        </td>

                        <td>

                            <span class="badge rounded-pill bg-{{ $warna }} px-3 py-2">

                                {{ $item->status }}

                            </span>

                        </td>

                        <td>

                            @if($item->scanner)

                                <div class="fw-semibold">

                                    {{ $item->scanner->nama }}

                                </div>

                                <small class="text-muted">

                                    {{ ucwords(str_replace('_',' ',$item->scanner->role)) }}

                                </small>

                            @else

                                <span class="text-muted">

                                    -

                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5" class="text-center py-5">

                            <i class="fa-solid fa-inbox fa-3x text-muted mb-3"></i>

                            <br>

                            Belum ada data presensi hari ini.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const labels = [

@foreach($grafikMingguan as $item)

    '{{ $item['tanggal'] }}',

@endforeach

];

const hadir = [

@foreach($grafikMingguan as $item)

    {{ $item['hadir'] }},

@endforeach

];

const terlambat = [

@foreach($grafikMingguan as $item)

    {{ $item['terlambat'] }},

@endforeach

];

const izin = [

@foreach($grafikMingguan as $item)

    {{ $item['izin'] }},

@endforeach

];

const sakit = [

@foreach($grafikMingguan as $item)

    {{ $item['sakit'] }},

@endforeach

];

const alpha = [

@foreach($grafikMingguan as $item)

    {{ $item['alpha'] }},

@endforeach

];

const ctx = document
    .getElementById('grafikPresensi')
    .getContext('2d');

const gradient = ctx.createLinearGradient(0,0,0,350);

gradient.addColorStop(0,'rgba(25,135,84,.35)');
gradient.addColorStop(.5,'rgba(25,135,84,.15)');
gradient.addColorStop(1,'rgba(25,135,84,0)');

new Chart(ctx,{

    type:'line',

    data:{

        labels:labels,

        datasets:[

            {

                label:'Hadir',

                data:hadir,

                borderColor:'#198754',

                backgroundColor:'rgba(25,135,84,.08)',

                fill:false,

                tension:.35,

                borderWidth:3

            },

            {

                label:'Terlambat',

                data:terlambat,

                borderColor:'#dc3545',

                backgroundColor:'rgba(220,53,69,.08)',

                fill:false,

                tension:.35,

                borderWidth:2

            },

            {

                label:'Izin',

                data:izin,

                borderColor:'#ffc107',

                backgroundColor:'rgba(255,193,7,.08)',

                fill:false,

                tension:.35,

                borderWidth:2

            },

            {

                label:'Sakit',

                data:sakit,

                borderColor:'#0dcaf0',

                backgroundColor:'rgba(13,202,240,.08)',

                fill:false,

                tension:.35,

                borderWidth:2

            },

            {

                label:'Alpha',

                data:alpha,

                borderColor:'#6c757d',

                backgroundColor:'rgba(108,117,125,.08)',

                fill:false,

                tension:.35,

                borderWidth:2

            }

        ]

    },

    options:{

        responsive:true,

        maintainAspectRatio:false,

        interaction:{

            mode:'index',

            intersect:false

        },

        plugins:{

            legend:{

                position:'bottom'

            }

        },

        scales:{

            y:{

                beginAtZero:true,

                ticks:{

                    precision:0

                }

            }

        }

    }

});

</script>

@endpush