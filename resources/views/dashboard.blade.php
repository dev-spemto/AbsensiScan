@extends('layouts.app')

@section('title','Dashboard')

@section('content')

{{-- ====================================================== --}}
{{-- Header --}}
{{-- ====================================================== --}}

<div class="card border-0 shadow-sm mb-4">

    <div class="card-body d-flex justify-content-between align-items-center">

        <div>

            <h3 class="fw-bold mb-1">

                {{ $pengaturan->nama_sekolah ?? 'Presensi Siswa' }}

            </h3>

            <div class="text-muted">

                Selamat datang,

                <strong>{{ auth()->user()->nama }}</strong>

            </div>

        </div>

        @if(!empty($pengaturan->logo))

            <img
                src="{{ asset('storage/'.$pengaturan->logo) }}"
                width="80"
                class="rounded">

        @endif

    </div>

</div>

{{-- ====================================================== --}}
{{-- Statistik --}}
{{-- ====================================================== --}}

<div class="row g-3 mb-4">

    <div class="col-lg-3 col-md-6">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <div class="d-flex justify-content-between">

                    <div>

                        <small class="text-muted">

                            Total Siswa

                        </small>

                        <h2 class="fw-bold text-success mb-0">

                            {{ number_format($totalSiswa) }}

                        </h2>

                    </div>

                    <i class="fa-solid fa-user-graduate fa-3x text-success opacity-75"></i>

                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-3 col-md-6">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <div class="d-flex justify-content-between">

                    <div>

                        <small class="text-muted">

                            Total Guru

                        </small>

                        <h2 class="fw-bold text-primary mb-0">

                            {{ number_format($totalGuru) }}

                        </h2>

                    </div>

                    <i class="fa-solid fa-chalkboard-user fa-3x text-primary opacity-75"></i>

                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-3 col-md-6">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <div class="d-flex justify-content-between">

                    <div>

                        <small class="text-muted">

                            Hadir

                        </small>

                        <h2 class="fw-bold text-success mb-0">

                            {{ $hadirHariIni }}

                        </h2>

                    </div>

                    <i class="fa-solid fa-circle-check fa-3x text-success opacity-75"></i>

                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-3 col-md-6">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <div class="d-flex justify-content-between">

                    <div>

                        <small class="text-muted">

                            Terlambat

                        </small>

                        <h2 class="fw-bold text-danger mb-0">

                            {{ $terlambatHariIni }}

                        </h2>

                    </div>

                    <i class="fa-solid fa-clock fa-3x text-danger opacity-75"></i>

                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-4 col-md-6">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <div class="d-flex justify-content-between">

                    <div>

                        <small class="text-muted">

                            Izin

                        </small>

                        <h3 class="fw-bold text-warning mb-0">

                            {{ $izinHariIni }}

                        </h3>

                    </div>

                    <i class="fa-solid fa-envelope-open-text fa-2x text-warning"></i>

                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-4 col-md-6">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <div class="d-flex justify-content-between">

                    <div>

                        <small class="text-muted">

                            Sakit

                        </small>

                        <h3 class="fw-bold text-info mb-0">

                            {{ $sakitHariIni }}

                        </h3>

                    </div>

                    <i class="fa-solid fa-notes-medical fa-2x text-info"></i>

                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-4 col-md-12">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <div class="d-flex justify-content-between">

                    <div>

                        <small class="text-muted">

                            Alpha

                        </small>

                        <h3 class="fw-bold text-dark mb-0">

                            {{ $alphaHariIni }}

                        </h3>

                    </div>

                    <i class="fa-solid fa-user-xmark fa-2x text-dark"></i>

                </div>

            </div>

        </div>

    </div>

</div>

{{-- ====================================================== --}}
{{-- Ringkasan --}}
{{-- ====================================================== --}}

<div class="row mb-4">

    <div class="col-lg-4">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-header bg-success text-white">

                Ringkasan Hari Ini

            </div>

            <div class="card-body">

                <table class="table table-sm mb-0">

                    <tr>

                        <td>Total Scan</td>

                        <th class="text-end">

                            {{ $totalScanHariIni }}

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

                <hr>

                @if($presensiTerbaru)

                    <div class="small">

                        <div class="fw-bold text-success mb-2">

                            Aktivitas Terakhir

                        </div>

                        <div>

                            <strong>{{ $presensiTerbaru->siswa->nama }}</strong>

                        </div>

                        <div class="text-muted">

                            {{ optional($presensiTerbaru->siswa->kelas)->nama_kelas }}

                        </div>

                        <div>

                            {{ $presensiTerbaru->jam_scan }}

                        </div>

                        <div class="mt-2">

                            <span class="badge bg-success">

                                {{ $presensiTerbaru->status }}

                            </span>

                        </div>

                    </div>

                @else

                    <div class="text-muted">

                        Belum ada aktivitas presensi.

                    </div>

                @endif

            </div>

        </div>

    </div>

    <div class="col-lg-8">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-header bg-primary text-white">

                Grafik Presensi Mingguan

            </div>

            <div class="card-body">

                <div style="height:320px">

                    <canvas id="grafikPresensi"></canvas>

                </div>

            </div>

        </div>

    </div>

</div>

{{-- ====================================================== --}}
{{-- Presensi Terakhir --}}
{{-- ====================================================== --}}

<div class="card border-0 shadow-sm">

    <div class="card-header bg-success text-white">

        <i class="fa-solid fa-clock-rotate-left"></i>

        10 Presensi Terakhir

    </div>

    <div class="table-responsive">

        <table class="table table-hover align-middle mb-0">

            <thead class="table-light">

                <tr>

                    <th>Jam</th>

                    <th>Nama</th>

                    <th>Kelas</th>

                    <th>Status</th>

                    <th>Scan Oleh</th>

                </tr>

            </thead>

            <tbody>

            @forelse($presensiTerakhir as $item)

                <tr>

                    <td>{{ $item->jam_scan }}</td>

                    <td>{{ $item->siswa->nama }}</td>

                    <td>{{ optional($item->siswa->kelas)->nama_kelas ?? '-' }}</td>

                    <td>

                        @php

                            $warna = match($item->status){

                                'Hadir' => 'success',
                                'Terlambat' => 'danger',
                                'Izin' => 'warning',
                                'Sakit' => 'info',
                                default => 'secondary'

                            };

                        @endphp

                        <span class="badge bg-{{ $warna }}">

                            {{ $item->status }}

                        </span>

                    </td>

                    <td>{{ $item->scanner->nama ?? '-' }}</td>

                </tr>

            @empty

                <tr>

                    <td colspan="5" class="text-center py-5">

                        Belum ada data presensi.

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

'{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat("d M") }}',

@endforeach

];

const data = [

@foreach($grafikMingguan as $item)

{{ $item->total }},

@endforeach

];

new Chart(document.getElementById('grafikPresensi'),{

    type:'line',

    data:{

        labels:labels,

        datasets:[{

            label:'Presensi',

            data:data,

            tension:.35,

            fill:true,

        }]

    },

    options:{

        responsive:true,

        maintainAspectRatio:false,

        plugins:{

            legend:{

                display:false

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