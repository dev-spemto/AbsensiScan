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

                <small>Hadir</small>

            </div>

        </div>

    </div>

    <div class="col-lg-2 col-md-4">

        <div class="card border-warning shadow-sm">

            <div class="card-body text-center">

                <h3 class="fw-bold text-warning">

                    {{ $terlambat }}

                </h3>

                <small>Terlambat</small>

            </div>

        </div>

    </div>

    <div class="col-lg-2 col-md-4">

        <div class="card border-primary shadow-sm">

            <div class="card-body text-center">

                <h3 class="fw-bold text-primary">

                    {{ $izin }}

                </h3>

                <small>Izin</small>

            </div>

        </div>

    </div>

    <div class="col-lg-2 col-md-4">

        <div class="card border-info shadow-sm">

            <div class="card-body text-center">

                <h3 class="fw-bold text-info">

                    {{ $sakit }}

                </h3>

                <small>Sakit</small>

            </div>

        </div>

    </div>

    <div class="col-lg-2 col-md-4">

        <div class="card border-danger shadow-sm">

            <div class="card-body text-center">

                <h3 class="fw-bold text-danger">

                    {{ $alpha }}

                </h3>

                <small>Alpha</small>

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

                    <label class="form-label">Tanggal</label>

                    <input
                        type="date"
                        name="tanggal"
                        class="form-control"
                        value="{{ request('tanggal') }}">

                </div>

                <div class="col-md-3 mb-3">

                    <label class="form-label">Bulan</label>

                    <select name="bulan" class="form-select">

                        <option value="">Semua Bulan</option>

                        @for($i=1;$i<=12;$i++)

                            <option
                                value="{{ $i }}"
                                {{ request('bulan')==$i ? 'selected' : '' }}>

                                {{ DateTime::createFromFormat('!m',$i)->format('F') }}

                            </option>

                        @endfor

                    </select>

                </div>

                <div class="col-md-3 mb-3">

                    <label class="form-label">Kelas</label>

                    <select name="kelas" class="form-select">

                        <option value="">Semua Kelas</option>

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

                    <label class="form-label">Siswa</label>

                    <select name="siswa" class="form-select">

                        <option value="">Semua Siswa</option>

                        @foreach($siswas as $siswa)

                            <option
                                value="{{ $siswa->id }}"
                                {{ request('siswa')==$siswa->id ? 'selected':'' }}>

                                {{ $siswa->nama }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-md-3 mb-3">

                    <label class="form-label">Guru</label>

                    <select name="guru" class="form-select">

                        <option value="">Semua Guru</option>

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

                    <label class="form-label">Petugas Scan</label>

                    <select name="scanner" class="form-select">

                        <option value="">Semua Petugas</option>

                        @foreach($scanners as $user)

                            <option
                                value="{{ $user->id }}"
                                {{ request('scanner')==$user->id ? 'selected':'' }}>

                                {{ $user->nama }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-md-3 mb-3">

                    <label class="form-label">Scan Oleh</label>

                    <select name="scan_by" class="form-select">

                        <option value="">Semua</option>

                        <option value="admin" {{ request('scan_by')=='admin' ? 'selected':'' }}>Admin</option>

                        <option value="guru" {{ request('scan_by')=='guru' ? 'selected':'' }}>Guru</option>

                        <option value="ketua_kelas" {{ request('scan_by')=='ketua_kelas' ? 'selected':'' }}>Ketua Kelas</option>

                        <option value="sekretaris" {{ request('scan_by')=='sekretaris' ? 'selected':'' }}>Sekretaris</option>

                    </select>

                </div>

                <div class="col-md-3 mb-3">

                    <label class="form-label">Status</label>

                    <select name="status" class="form-select">

                        <option value="">Semua</option>

                        <option value="Hadir" {{ request('status')=='Hadir' ? 'selected':'' }}>Hadir</option>

                        <option value="Terlambat" {{ request('status')=='Terlambat' ? 'selected':'' }}>Terlambat</option>

                        <option value="Izin" {{ request('status')=='Izin' ? 'selected':'' }}>Izin</option>

                        <option value="Sakit" {{ request('status')=='Sakit' ? 'selected':'' }}>Sakit</option>

                        <option value="Alpha" {{ request('status')=='Alpha' ? 'selected':'' }}>Alpha</option>

                    </select>

                </div>

                <div class="col-md-3 mb-3">

                    <label class="form-label">Metode</label>

                    <select name="metode" class="form-select">

                        <option value="">Semua Metode</option>

                        <option value="Barcode" {{ request('metode')=='Barcode' ? 'selected':'' }}>Barcode</option>

                        <option value="Manual" {{ request('metode')=='Manual' ? 'selected':'' }}>Manual</option>

                    </select>

                </div>

                <div class="col-md-3 mb-3">

                    <label class="form-label">Tahun Ajaran</label>

                    <select name="tahun_ajaran" class="form-select">

                        <option value="">Semua Tahun Ajaran</option>

                        @foreach($tahunAjarans as $ta)

                            <option
                                value="{{ $ta->id }}"
                                {{ request('tahun_ajaran')==$ta->id ? 'selected':'' }}>

                                {{ $ta->nama }}

                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

            <div class="d-flex flex-wrap gap-2">

                <button class="btn btn-success">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    Tampilkan
                </button>

                <a href="{{ route('rekap.index') }}" class="btn btn-secondary">
                    <i class="fa-solid fa-rotate-left"></i>
                    Reset
                </a>

                <a href="{{ route('rekap.export.excel', request()->query()) }}" class="btn btn-success">
                    <i class="fa-solid fa-file-excel"></i>
                    Export Excel
                </a>

                <a href="{{ route('rekap.export.pdf', request()->query()) }}" class="btn btn-danger">
                    <i class="fa-solid fa-file-pdf"></i>
                    Export PDF
                </a>

                <a href="{{ route('rekap.print', request()->query()) }}" target="_blank" class="btn btn-dark">
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

                    <th width="60">No</th>

                    <th>Tanggal</th>

                    <th>Jam</th>

                    <th>Siswa</th>

                    <th>Kelas</th>

                    <th>Status</th>

                    <th>Petugas Scan</th>

                    <th>Role</th>

                    <th>Guru Mapel</th>

                    <th>Metode</th>

                </tr>

            </thead>

            <tbody>

            @php

                $warna = [

                    'Hadir'     => 'success',

                    'Terlambat' => 'warning',

                    'Izin'      => 'primary',

                    'Sakit'     => 'info',

                    'Alpha'     => 'danger',

                ];

                $roleColor = [

                    'admin'        => 'danger',

                    'guru'         => 'success',

                    'ketua_kelas'  => 'primary',

                    'sekretaris'   => 'warning',

                ];

                $roleText = [

                    'admin'        => 'Admin',

                    'guru'         => 'Guru',

                    'ketua_kelas'  => 'Ketua Kelas',

                    'sekretaris'   => 'Sekretaris',

                ];

                $metodeColor = [

                    'Barcode' => 'success',

                    'Manual'  => 'secondary',

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

                    <div class="d-flex align-items-center">

                        <img
                            src="{{ $presensi->siswa->foto
                                ? asset('storage/'.$presensi->siswa->foto)
                                : 'https://ui-avatars.com/api/?name='.urlencode($presensi->siswa->nama) }}"
                            width="45"
                            height="45"
                            class="rounded-circle border me-2"
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

                    {{ optional($presensi->siswa->kelas)->nama_lengkap }}

                </td>

                <td>

                    <span class="badge bg-{{ $warna[$presensi->status] ?? 'secondary' }}">

                        {{ $presensi->status }}

                    </span>

                </td>

                <td>

                    {{ optional($presensi->scanner)->nama ?? '-' }}

                </td>

                <td>

                    <span class="badge bg-{{ $roleColor[$presensi->scan_by] ?? 'secondary' }}">

                        {{ $roleText[$presensi->scan_by] ?? '-' }}

                    </span>

                </td>

                <td>

                    {{ optional($presensi->guru)->nama ?? '-' }}

                </td>

                <td>

                    <span class="badge bg-{{ $metodeColor[$presensi->metode] ?? 'dark' }}">

                        {{ $presensi->metode }}

                    </span>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="10" class="text-center py-5">

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

{{-- Informasi --}}

<div class="card border-0 shadow-sm mt-4">

    <div class="card-header bg-light">

        <i class="fa-solid fa-circle-info text-success"></i>

        Informasi Rekap Presensi

    </div>

    <div class="card-body">

        <div class="row g-3">

            <div class="col-lg-3 col-md-6">

                <div class="border rounded-3 p-3 h-100">

                    <div class="fw-bold text-success mb-2">

                        <i class="fa-solid fa-barcode"></i>

                        Barcode

                    </div>

                    <small class="text-muted">

                        Presensi menggunakan barcode/NISN sehingga proses
                        pencatatan lebih cepat dan meminimalkan kesalahan input.

                    </small>

                </div>

            </div>

            <div class="col-lg-3 col-md-6">

                <div class="border rounded-3 p-3 h-100">

                    <div class="fw-bold text-primary mb-2">

                        <i class="fa-solid fa-user-check"></i>

                        Status

                    </div>

                    <small class="text-muted">

                        Rekap menampilkan status Hadir, Terlambat, Izin,
                        Sakit maupun Alpha sesuai hasil presensi.

                    </small>

                </div>

            </div>

            <div class="col-lg-3 col-md-6">

                <div class="border rounded-3 p-3 h-100">

                    <div class="fw-bold text-warning mb-2">

                        <i class="fa-solid fa-user-shield"></i>

                        Petugas Scan

                    </div>

                    <small class="text-muted">

                        Setiap transaksi menyimpan informasi petugas yang
                        melakukan scan beserta hak aksesnya.

                    </small>

                </div>

            </div>

            <div class="col-lg-3 col-md-6">

                <div class="border rounded-3 p-3 h-100">

                    <div class="fw-bold text-danger mb-2">

                        <i class="fa-solid fa-file-export"></i>

                        Export

                    </div>

                    <small class="text-muted">

                        Hasil rekap sesuai filter dapat langsung diekspor
                        ke Excel, PDF ataupun dicetak.

                    </small>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection