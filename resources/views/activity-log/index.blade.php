@extends('layouts.app')

@section('title','Activity Log')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="fw-bold mb-1">

            <i class="fa-solid fa-clock-rotate-left text-success"></i>

            Activity Log

        </h3>

        <small class="text-muted">

            Riwayat seluruh aktivitas pengguna sistem.

        </small>

    </div>

</div>

<div class="card shadow-sm border-0 mb-4">

    <div class="card-body">

        <form method="GET">

            <div class="row g-3">

                <div class="col-lg-4">

                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Cari aktivitas..."
                        value="{{ request('search') }}">

                </div>

                <div class="col-lg-2">

                    <select
                        name="user"
                        class="form-select">

                        <option value="">

                            Semua User

                        </option>

                        @foreach($users as $user)

                            <option
                                value="{{ $user->id }}"
                                @selected(request('user')==$user->id)>

                                {{ $user->nama }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-lg-2">

                    <select
                        name="modul"
                        class="form-select">

                        <option value="">

                            Semua Modul

                        </option>

                        @foreach($moduls as $modul)

                            <option
                                value="{{ $modul }}"
                                @selected(request('modul')==$modul)>

                                {{ $modul }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-lg-2">

                    <input
                        type="date"
                        name="tanggal"
                        class="form-control"
                        value="{{ request('tanggal') }}">

                </div>

                <div class="col-lg-2 d-grid">

                    <button
                        class="btn btn-success">

                        <i class="fa fa-search"></i>

                        Filter

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

<div class="card shadow-sm border-0">

    <div class="card-header bg-success text-white">

        Activity Log

    </div>

    <div class="table-responsive">

        <table class="table table-hover align-middle mb-0">

            <thead class="table-light">

                <tr>

                    <th width="180">

                        Waktu

                    </th>

                    <th width="220">

                        User

                    </th>

                    <th width="180">

                        Modul

                    </th>

                    <th>

                        Aktivitas

                    </th>

                </tr>

            </thead>

            <tbody>

            @forelse($logs as $log)

                <tr>

                    <td>

                        <strong>

                            {{ $log->created_at->format('d M Y') }}

                        </strong>

                        <br>

                        <small class="text-muted">

                            {{ $log->created_at->format('H:i:s') }}

                        </small>

                    </td>

                    <td>

                        {{ $log->user->nama ?? '-' }}

                    </td>

                    <td>

                        @php

                            $warna='secondary';

                            if($log->modul=='Siswa') $warna='primary';
                            if($log->modul=='Guru') $warna='success';
                            if($log->modul=='Pengurus Kelas') $warna='warning';
                            if($log->modul=='Presensi') $warna='danger';
                            if($log->modul=='Login') $warna='dark';

                        @endphp

                        <span class="badge bg-{{ $warna }}">

                            {{ $log->modul }}

                        </span>

                    </td>

                    <td>

                        {{ $log->aktivitas }}

                    </td>

                </tr>

            @empty

                <tr>

                    <td
                        colspan="4"
                        class="text-center py-5">

                        <i class="fa-solid fa-folder-open fa-3x text-secondary mb-3"></i>

                        <br>

                        Belum ada aktivitas.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    @if($logs->hasPages())

        <div class="card-footer">

            {{ $logs->links() }}

        </div>

    @endif

</div>

@endsection