@extends('layouts.app')

@section('title','Detail Presensi')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="fw-bold mb-0">

            Detail Presensi

        </h3>

        <small class="text-muted">

            Informasi lengkap presensi siswa

        </small>

    </div>

    <div>

        <a href="{{ route('presensi.edit',$presensi) }}" class="btn btn-warning">

            <i class="fa-solid fa-pen"></i>

            Edit

        </a>

        <a href="{{ route('presensi.index') }}" class="btn btn-secondary">

            <i class="fa-solid fa-arrow-left"></i>

            Kembali

        </a>

    </div>

</div>


<div class="card border-0 shadow-sm">

    <div class="card-header bg-success text-white">

        <i class="fa-solid fa-calendar-check"></i>

        Detail Presensi

    </div>

    <div class="card-body">

        <table class="table table-borderless">

            <tr>
                <th width="220">Nama Siswa</th>
                <td>{{ $presensi->siswa->nama }}</td>
            </tr>

            <tr>
                <th>Kelas</th>
                <td>{{ $presensi->siswa->kelas->nama_lengkap }}</td>
            </tr>

            <tr>
                <th>Guru</th>
                <td>{{ $presensi->guru->nama }}</td>
            </tr>

            <tr>
                <th>Tahun Ajaran</th>
                <td>{{ $presensi->tahunAjaran->tahun }}</td>
            </tr>

            <tr>
                <th>Tanggal</th>
                <td>{{ $presensi->tanggal->format('d F Y') }}</td>
            </tr>

            <tr>
                <th>Jam Scan</th>
                <td>{{ $presensi->jam_scan }}</td>
            </tr>

            <tr>
                <th>Status</th>

                <td>

                    @php

                        $warna = [
                            'Hadir'=>'success',
                            'Terlambat'=>'warning',
                            'Sakit'=>'info',
                            'Izin'=>'primary',
                            'Alpha'=>'danger',
                        ];

                    @endphp

                    <span class="badge bg-{{ $warna[$presensi->status] ?? 'secondary' }}">

                        {{ $presensi->status }}

                    </span>

                </td>

            </tr>

            <tr>
                <th>Metode</th>
                <td>{{ $presensi->metode }}</td>
            </tr>

            <tr>
                <th>Device</th>
                <td>{{ $presensi->device_name ?? '-' }}</td>
            </tr>

            <tr>
                <th>Keterangan</th>
                <td>{{ $presensi->keterangan ?? '-' }}</td>
            </tr>

        </table>

    </div>

</div>

@endsection