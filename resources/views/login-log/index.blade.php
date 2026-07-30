@extends('layouts.app')

@section('title','Riwayat Login')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="fw-bold mb-1">

            <i class="fa-solid fa-clock-rotate-left text-success"></i>

            Riwayat Login

        </h3>

        <small class="text-muted">

            Semua aktivitas login pengguna.

        </small>

    </div>

</div>

<div class="card border-0 shadow-sm">

    <div class="card-header bg-success text-white">

        <form method="GET"
              class="row g-2 align-items-center">

            <div class="col-md-4">

                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Cari nama / username / role..."
                    value="{{ request('search') }}">

            </div>

            <div class="col-md-3">

                <input
                    type="date"
                    name="tanggal"
                    class="form-control"
                    value="{{ request('tanggal') }}">

            </div>

            <div class="col-md-3">

                <button
                    class="btn btn-light">

                    <i class="fa-solid fa-magnifying-glass"></i>

                    Filter

                </button>

                <a href="{{ route('login-log.index') }}"
                   class="btn btn-warning">

                    Reset

                </a>

            </div>

        </form>

    </div>

    <div class="table-responsive">

        <table class="table table-hover align-middle mb-0">

            <thead class="table-light">

                <tr>

                    <th>Waktu</th>

                    <th>Nama</th>

                    <th>Username</th>

                    <th>Role</th>

                    <th>Status</th>

                    <th>IP</th>

                </tr>

            </thead>

            <tbody>

            @forelse($logs as $log)

                <tr>

                    <td>

                        {{ $log->login_at->format('d/m/Y H:i') }}

                    </td>

                    <td>

                        {{ $log->nama }}

                    </td>

                    <td>

                        {{ $log->username }}

                    </td>

                    <td>

                        {{ ucfirst(str_replace('_',' ',$log->role)) }}

                    </td>

                    <td>

                        @if($log->status == 'berhasil')

                            <span class="badge bg-success">

                                Berhasil

                            </span>

                        @else

                            <span class="badge bg-danger">

                                Gagal

                            </span>

                        @endif

                    </td>

                    <td>

                        {{ $log->ip_address }}

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="6"
                        class="text-center py-5">

                        Belum ada riwayat login.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    <div class="card-footer">

        {{ $logs->links() }}

    </div>

</div>

@endsection