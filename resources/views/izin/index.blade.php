@extends('layouts.app')

@section('title','Data Izin / Sakit')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">

    <h4 class="mb-0">

        <i class="fa-solid fa-notes-medical text-success"></i>

        Data Izin / Sakit

    </h4>

    <a href="{{ route('izin.create') }}" class="btn btn-success">

        <i class="fa-solid fa-plus"></i>

        Tambah Pengajuan

    </a>

</div>

<div class="card shadow-sm">

    <div class="table-responsive">

        <table class="table table-hover align-middle mb-0">

            <thead class="table-success">

                <tr>

                    <th width="60">No</th>
                    <th>Siswa</th>
                    <th>Tanggal</th>
                    <th>Jenis</th>
                    <th>Bukti</th>
                    <th>Status</th>
                    <th width="180">Aksi</th>

                </tr>

            </thead>

            <tbody>

                @forelse($izins as $izin)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $izin->siswa->nama }}</td>

                    <td>{{ $izin->tanggal }}</td>

                    <td>

                        <span class="badge bg-{{ $izin->jenis == 'Sakit' ? 'danger' : 'warning' }}">

                            {{ $izin->jenis }}

                        </span>

                    </td>

                    <td>

                        @if($izin->bukti)

                            <a href="{{ asset('storage/'.$izin->bukti) }}"
                               target="_blank"
                               class="btn btn-sm btn-outline-primary">

                                <i class="fa-solid fa-eye"></i>

                                Lihat Bukti

                            </a>

                        @else

                            <span class="text-muted">

                                -

                            </span>

                        @endif

                    </td>

                    <td>

                        @php

                            $warna = match($izin->status) {
                                'Pending' => 'warning',
                                'Disetujui' => 'success',
                                'Ditolak' => 'danger',
                                default => 'secondary',
                            };

                        @endphp

                        <span class="badge bg-{{ $warna }}">

                            {{ $izin->status }}

                        </span>

                    </td>

                    <td>

                        <a href="{{ route('izin.show',$izin) }}"
                           class="btn btn-sm btn-info">

                            <i class="fa-solid fa-circle-info"></i>

                            Detail

                        </a>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="7" class="text-center text-muted py-4">

                        Belum ada data izin.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

<div class="mt-3">

    {{ $izins->links() }}

</div>

@endsection