@extends('layouts.app')

@section('title','Dashboard')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="fw-bold mb-1">

            Selamat {{ $greeting }}, {{ auth()->user()->nama }} 👋

        </h3>

        <div class="text-muted">

            {{ now()->translatedFormat('l, d F Y') }}

        </div>

    </div>

    <div class="text-end">

        <div
            id="liveClock"
            class="fw-bold text-success"
            style="font-size:2rem;">

        </div>

    </div>

</div>

{{-- ====================================================== --}}
{{-- Statistik Utama --}}
{{-- ====================================================== --}}

<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-lg rounded-4 h-100 overflow-hidden">
            <div class="card-body d-flex justify-content-between align-items-center p-4">
                <div>
                    <div class="text-muted small mb-1">
                        Total Siswa
                    </div>
                    <h2 class="fw-bold text-success mb-1">
                        {{ number_format($totalSiswa) }}
                    </h2>
                    <small class="text-muted">
                        Siswa aktif
                    </small>
                </div>

                <div class="rounded-circle bg-success-subtle d-flex align-items-center justify-content-center"
                    style="width:70px;height:70px;">
                    <i class="fa-solid fa-user-graduate fa-2x text-success"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-lg rounded-4 h-100 overflow-hidden">
            <div class="card-body d-flex justify-content-between align-items-center p-4">
                <div>
                    <div class="text-muted small mb-1">
                        Total Guru
                    </div>
                    <h2 class="fw-bold text-primary mb-1">
                        {{ number_format($totalGuru) }}
                    </h2>
                    <small class="text-muted">
                        Guru aktif
                    </small>
                </div>

                <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center"
                    style="width:70px;height:70px;">
                    <i class="fa-solid fa-chalkboard-user fa-2x text-primary"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-lg rounded-4 h-100 overflow-hidden">
            <div class="card-body d-flex justify-content-between align-items-center p-4">
                <div>
                    <div class="text-muted small mb-1">
                        Total Kelas
                    </div>
                    <h2 class="fw-bold text-warning mb-1">
                        {{ number_format($totalKelas) }}
                    </h2>
                    <small class="text-muted">
                        Kelas aktif
                    </small>
                </div>

                <div class="rounded-circle bg-warning-subtle d-flex align-items-center justify-content-center"
                    style="width:70px;height:70px;">
                    <i class="fa-solid fa-school fa-2x text-warning"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-lg rounded-4 h-100 overflow-hidden">
            <div class="card-body d-flex justify-content-between align-items-center p-4">
                <div>
                    <div class="text-muted small mb-1">
                        Presensi Hari Ini
                    </div>
                    <h2 class="fw-bold text-info mb-1">
                        {{ $totalScanHariIni }}
                    </h2>
                    <small class="text-muted">
                        Scan berhasil
                    </small>
                </div>

                <div class="rounded-circle bg-info-subtle d-flex align-items-center justify-content-center"
                    style="width:70px;height:70px;">
                    <i class="fa-solid fa-calendar-check fa-2x text-info"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row g-3 mb-5">

    <div class="col">

        <a href="{{ route('presensi.create') }}" class="btn btn-success w-100 py-3 rounded-4 shadow-sm">

            <i class="fa-solid fa-barcode mb-2 d-block fs-3"></i>

            Scan Presensi

        </a>

    </div>

    <div class="col">

        <a href="{{ route('presensi.index') }}" class="btn btn-primary w-100 py-3 rounded-4 shadow-sm">

            <i class="fa-solid fa-calendar-check mb-2 d-block fs-3"></i>

            Data Presensi

        </a>

    </div>

    <div class="col">

        <a href="{{ route('rekap.index') }}" class="btn btn-warning w-100 py-3 rounded-4 shadow-sm">

            <i class="fa-solid fa-chart-column mb-2 d-block fs-3"></i>

            Rekap

        </a>

    </div>

    <div class="col">

        <a href="{{ route('izin.index') }}" class="btn btn-info w-100 py-3 rounded-4 shadow-sm">

            <i class="fa-solid fa-notes-medical mb-2 d-block fs-3"></i>

            Izin

        </a>

    </div>

</div>


{{-- ====================================================== --}}
{{-- Status Hari Ini --}}
{{-- ====================================================== --}}

<div class="row g-4 mb-5">

    @php

        $statusCards = [

            [
                'title' => 'Hadir',
                'value' => $hadirHariIni,
                'icon'  => 'fa-circle-check',
                'color' => 'success',
            ],

            [
                'title' => 'Terlambat',
                'value' => $terlambatHariIni,
                'icon'  => 'fa-clock',
                'color' => 'danger',
            ],

            [
                'title' => 'Izin',
                'value' => $izinHariIni,
                'icon'  => 'fa-envelope-open-text',
                'color' => 'warning',
            ],

            [
                'title' => 'Sakit',
                'value' => $sakitHariIni,
                'icon'  => 'fa-notes-medical',
                'color' => 'info',
            ],

            [
                'title' => 'Alpha',
                'value' => $alphaHariIni,
                'icon'  => 'fa-user-xmark',
                'color' => 'secondary',
            ],

            [
                'title' => 'Belum Scan',
                'value' => $belumPresensiHariIni,
                'icon'  => 'fa-user-clock',
                'color' => 'dark',
            ],

        ];

    @endphp

    @foreach($statusCards as $item)

        <div class="col-xl-2 col-lg-4 col-md-4 col-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body text-center py-4">

                    <div
                        class="rounded-circle bg-{{ $item['color'] }} bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3"
                        style="width:64px;height:64px;">

                        <i class="fa-solid {{ $item['icon'] }} fa-xl text-{{ $item['color'] }}"></i>

                    </div>

                    <h2 class="fw-bold mb-1">

                        {{ $item['value'] }}

                    </h2>

                    <div class="text-muted small">

                        {{ $item['title'] }}

                    </div>

                </div>

            </div>

        </div>

    @endforeach

</div>

{{-- ====================================================== --}}
{{-- Ringkasan Dashboard --}}
{{-- ====================================================== --}}

<div class="row g-4 mb-5">

    <div class="col-lg-8">

        <div class="card border-0 shadow-sm rounded-4 h-100">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>

                        <h5 class="fw-bold mb-1">

                            Grafik Presensi 7 Hari

                        </h5>

                        <small class="text-muted">

                            Statistik kehadiran siswa selama seminggu terakhir.

                        </small>

                    </div>

                </div>

                <div style="height:360px">

                    <canvas id="grafikPresensi"></canvas>

                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-4">

        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-body">

                <h6 class="fw-bold mb-3">

                    Ringkasan Hari Ini

                </h6>

                <div class="d-flex justify-content-between mb-2">

                    <span>Persentase Kehadiran</span>

                    <strong>{{ $persentaseHadir }}%</strong>

                </div>

                <div class="progress mb-4" style="height:10px">

                    <div
                        class="progress-bar bg-success"
                        style="width:{{ $persentaseHadir }}%">

                    </div>

                </div>

                <table class="table table-borderless table-sm mb-0">

                    <tr>

                        <td>Total Scan</td>

                        <td class="text-end fw-bold">

                            {{ $totalScanHariIni }}

                        </td>

                    </tr>

                    <tr>

                        <td>Belum Scan</td>

                        <td class="text-end fw-bold text-danger">

                            {{ $belumPresensiHariIni }}

                        </td>

                    </tr>

                    <tr>

                        <td>Hadir</td>

                        <td class="text-end fw-bold text-success">

                            {{ $hadirHariIni }}

                        </td>

                    </tr>

                    <tr>

                        <td>Terlambat</td>

                        <td class="text-end fw-bold text-danger">

                            {{ $terlambatHariIni }}

                        </td>

                    </tr>

                    <tr>

                        <td>Izin</td>

                        <td class="text-end fw-bold text-warning">

                            {{ $izinHariIni }}

                        </td>

                    </tr>

                    <tr>

                        <td>Sakit</td>

                        <td class="text-end fw-bold text-info">

                            {{ $sakitHariIni }}

                        </td>

                    </tr>

                    <tr>

                        <td>Alpha</td>

                        <td class="text-end fw-bold text-secondary">

                            {{ $alphaHariIni }}

                        </td>

                    </tr>

                </table>

            </div>

        </div>

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                <h6 class="fw-bold mb-3">

                    Aktivitas Terakhir

                </h6>

                @if($presensiTerbaru)

                    <h5 class="fw-bold mb-1">

                        {{ $presensiTerbaru->siswa->nama }}

                    </h5>

                    <div class="text-muted mb-3">

                        {{ optional($presensiTerbaru->siswa->kelas)->nama_lengkap }}

                    </div>

                    <div class="mb-2">

                        <strong>Jam Scan</strong>

                        <br>

                        {{ $presensiTerbaru->jam_scan }}

                    </div>

                    <span class="badge bg-success fs-6">

                        {{ $presensiTerbaru->status }}

                    </span>

                @else

                    <div class="text-muted">

                        Belum ada aktivitas.

                    </div>

                @endif

                @if($kelasTeraktif)

                    <hr>

                    <small class="text-muted">

                        Kelas Teraktif

                    </small>

                    <div class="fw-bold">

                        {{ $kelasTeraktif->nama_lengkap }}

                    </div>

                    <small>

                        {{ $kelasTeraktif->hadir_hari_ini }} siswa hadir

                    </small>

                @endif

            </div>

        </div>

    </div>

</div>

{{-- ====================================================== --}}
{{-- Presensi Terakhir --}}
{{-- ====================================================== --}}

<div class="card border-0 shadow rounded-4">

    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center rounded-top-4">

        <div class="fw-semibold">

            <i class="fa-solid fa-clock-rotate-left me-2"></i>

            10 Presensi Terakhir

        </div>

        <span class="badge bg-light text-success px-3 py-2">

            {{ $presensiTerakhir->count() }} Data

        </span>

    </div>

    <div class="table-responsive">

        <style>

            #dashboard-presensi-table{

                margin-bottom:0;

            }

            #dashboard-presensi-table thead th{

                background:#f8fafc;
                border:0;
                color:#6c757d;
                font-size:.82rem;
                font-weight:700;
                letter-spacing:.5px;
                text-transform:uppercase;
                padding:16px;

            }

            #dashboard-presensi-table tbody td{

                padding:16px;
                vertical-align:middle;
                border-color:#edf2f7;

            }

            #dashboard-presensi-table tbody tr{

                transition:all .2s ease;

            }

            #dashboard-presensi-table tbody tr:hover{

                background:#f8fffb;
                transform:scale(1.003);

            }

            .avatar-dashboard{

                width:46px;
                height:46px;
                object-fit:cover;
                border-radius:50%;
                border:2px solid #e9ecef;

            }

        </style>

        <table
            id="dashboard-presensi-table"
            class="table table-hover align-middle">

            <thead>

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

                            'Hadir' => 'success',
                            'Terlambat' => 'danger',
                            'Izin' => 'warning',
                            'Sakit' => 'info',
                            'Alpha' => 'secondary',
                            default => 'dark'

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
                                    src="{{ $item->siswa->foto ? asset('storage/'.$item->siswa->foto) : asset('images/avatar-default.png') }}"
                                    class="avatar-dashboard me-3">

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

                            <span class="badge bg-light text-dark border px-3 py-2">

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

const ctx = document.getElementById('grafikPresensi').getContext('2d');

const gradient = ctx.createLinearGradient(0, 0, 0, 360);

gradient.addColorStop(0, 'rgba(25,135,84,.28)');
gradient.addColorStop(.45, 'rgba(25,135,84,.10)');
gradient.addColorStop(1, 'rgba(25,135,84,0)');

function updateClock(){

    const now = new Date();

    document.getElementById('liveClock').innerHTML =
        now.toLocaleTimeString('id-ID');

}

updateClock();

setInterval(updateClock,1000);

new Chart(ctx, {

    type: 'line',

    data: {

        labels,

        datasets: [

            {

                label: 'Hadir',

                data: hadir,

                borderColor: '#198754',

                backgroundColor: gradient,

                fill: true,

                tension: .38,

                borderWidth: 3,

                pointRadius: 4,

                pointHoverRadius: 6,

                pointBackgroundColor: '#198754'

            },

            {

                label: 'Terlambat',

                data: terlambat,

                borderColor: '#dc3545',

                backgroundColor: 'transparent',

                fill: false,

                tension: .38,

                borderWidth: 2,

                pointRadius: 3

            },

            {

                label: 'Izin',

                data: izin,

                borderColor: '#ffc107',

                backgroundColor: 'transparent',

                fill: false,

                tension: .38,

                borderWidth: 2,

                pointRadius: 3

            },

            {

                label: 'Sakit',

                data: sakit,

                borderColor: '#0dcaf0',

                backgroundColor: 'transparent',

                fill: false,

                tension: .38,

                borderWidth: 2,

                pointRadius: 3

            },

            {

                label: 'Alpha',

                data: alpha,

                borderColor: '#6c757d',

                backgroundColor: 'transparent',

                fill: false,

                tension: .38,

                borderWidth: 2,

                pointRadius: 3

            }

        ]

    },

    options: {

        responsive: true,

        maintainAspectRatio: false,

        interaction: {

            mode: 'index',

            intersect: false

        },

        plugins: {

            legend: {

                position: 'bottom',

                labels: {

                    usePointStyle: true,

                    padding: 20

                }

            }

        },

        scales: {

            x: {

                grid: {

                    display: false

                }

            },

            y: {

                beginAtZero: true,

                ticks: {

                    precision: 0

                },

                grid: {

                    color: '#eef2f7'

                }

            }

        }

    }

});

</script>

@endpush