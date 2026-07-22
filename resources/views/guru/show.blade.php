@extends('layouts.app')

@section('title','Detail Guru')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="fw-bold mb-0">Detail Guru</h3>
        <small class="text-muted">Informasi lengkap guru</small>
    </div>

    <div>

        <a href="{{ route('guru.edit',$guru) }}" class="btn btn-warning">

            <i class="fa-solid fa-pen"></i>

            Edit

        </a>

        <a href="{{ route('guru.index') }}" class="btn btn-secondary">

            <i class="fa-solid fa-arrow-left"></i>

            Kembali

        </a>

    </div>

</div>

<div class="row">

    <div class="col-lg-4">

        <div class="card border-0 shadow-sm">

            <div class="card-body text-center">

                @if($guru->foto)

                    <img src="{{ asset('storage/'.$guru->foto) }}"
                         class="rounded-circle mb-3"
                         width="180"
                         height="180"
                         style="object-fit:cover;">

                @else

                    <img src="https://ui-avatars.com/api/?name={{ urlencode($guru->nama) }}&size=200"
                         class="rounded-circle mb-3">

                @endif

                <h4 class="fw-bold">

                    {{ $guru->nama }}

                </h4>

                <span class="badge {{ $guru->aktif ? 'bg-success' : 'bg-danger' }}">

                    {{ $guru->aktif ? 'AKTIF' : 'NON AKTIF' }}

                </span>

            </div>

        </div>

    </div>

    <div class="col-lg-8">

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-success text-white">

                <i class="fa-solid fa-user"></i>

                Biodata Guru

            </div>

            <div class="card-body">

                <table class="table table-borderless">

                    <tr>
                        <th width="220">NIP</th>
                        <td>{{ $guru->nip }}</td>
                    </tr>

                    <tr>
                        <th>Nama Lengkap</th>
                        <td>{{ $guru->nama }}</td>
                    </tr>

                    <tr>
                        <th>Tempat Lahir</th>
                        <td>{{ $guru->tempat_lahir ?: '-' }}</td>
                    </tr>

                    <tr>
                        <th>Tanggal Lahir</th>
                        <td>

                            @if($guru->tanggal_lahir)

                                {{ \Carbon\Carbon::parse($guru->tanggal_lahir)->translatedFormat('d F Y') }}

                            @else

                                -

                            @endif

                        </td>
                    </tr>

                    <tr>
                        <th>Jenis Kelamin</th>
                        <td>

                            @if($guru->jenis_kelamin=='L')

                                Laki-laki

                            @elseif($guru->jenis_kelamin=='P')

                                Perempuan

                            @else

                                -

                            @endif

                        </td>
                    </tr>

                    <tr>
                        <th>No HP</th>
                        <td>{{ $guru->no_hp ?: '-' }}</td>
                    </tr>

                    <tr>
                        <th>Email</th>
                        <td>{{ $guru->email ?: '-' }}</td>
                    </tr>

                    <tr>
                        <th>Alamat</th>
                        <td>{{ $guru->alamat ?: '-' }}</td>
                    </tr>

                    <tr>
                        <th>Username</th>
                        <td>{{ $guru->username }}</td>
                    </tr>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection