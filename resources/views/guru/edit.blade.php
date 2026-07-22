@extends('layouts.app')

@section('title','Edit Guru')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="fw-bold mb-0">Edit Data Guru</h3>
        <small class="text-muted">Perbarui data guru</small>
    </div>

    <a href="{{ route('guru.index') }}" class="btn btn-secondary">
        <i class="fa-solid fa-arrow-left"></i>
        Kembali
    </a>

</div>

<div class="card shadow-sm border-0">

    <div class="card-body">

        <form action="{{ route('guru.update',$guru) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label>NIP</label>
                    <input type="text"
                           name="nip"
                           class="form-control"
                           value="{{ old('nip',$guru->nip) }}"
                           required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Nama Lengkap</label>
                    <input type="text"
                           name="nama"
                           class="form-control"
                           value="{{ old('nama',$guru->nama) }}"
                           required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Tempat Lahir</label>
                    <input type="text"
                           name="tempat_lahir"
                           class="form-control"
                           value="{{ old('tempat_lahir',$guru->tempat_lahir) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Tanggal Lahir</label>
                    <input type="date"
                           name="tanggal_lahir"
                           class="form-control"
                           value="{{ old('tanggal_lahir',$guru->tanggal_lahir) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Jenis Kelamin</label>

                    <select name="jenis_kelamin" class="form-select">

                        <option value="">- Pilih -</option>

                        <option value="L"
                            {{ old('jenis_kelamin',$guru->jenis_kelamin)=='L' ? 'selected' : '' }}>
                            Laki-laki
                        </option>

                        <option value="P"
                            {{ old('jenis_kelamin',$guru->jenis_kelamin)=='P' ? 'selected' : '' }}>
                            Perempuan
                        </option>

                    </select>

                </div>

                <div class="col-md-6 mb-3">
                    <label>No HP</label>
                    <input type="text"
                           name="no_hp"
                           class="form-control"
                           value="{{ old('no_hp',$guru->no_hp) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Email</label>
                    <input type="email"
                           name="email"
                           class="form-control"
                           value="{{ old('email',$guru->email) }}">
                </div>

                <div class="col-md-6 mb-3">

                    <label>Foto</label>

                    <input type="file"
                           name="foto"
                           class="form-control">

                    @if($guru->foto)

                        <img src="{{ asset('storage/'.$guru->foto) }}"
                             width="100"
                             class="rounded mt-2">

                    @endif

                </div>

                <div class="col-md-12 mb-3">
                    <label>Alamat</label>

                    <textarea name="alamat"
                              rows="3"
                              class="form-control">{{ old('alamat',$guru->alamat) }}</textarea>

                </div>

                <div class="col-md-6 mb-3">
                    <label>Username</label>
                    <input type="text"
                           name="username"
                           class="form-control"
                           value="{{ old('username',$guru->username) }}"
                           required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Password Baru</label>
                    <input type="password"
                           name="password"
                           class="form-control">

                    <small class="text-muted">
                        Kosongkan jika tidak ingin mengganti password.
                    </small>
                </div>

                <div class="col-md-6 mb-3">

                    <label>Status</label>

                    <select name="aktif"
                            class="form-select">

                        <option value="1"
                            {{ $guru->aktif ? 'selected' : '' }}>
                            Aktif
                        </option>

                        <option value="0"
                            {{ !$guru->aktif ? 'selected' : '' }}>
                            Non Aktif
                        </option>

                    </select>

                </div>

                <div class="col-12">

                    <button class="btn btn-success">

                        <i class="fa-solid fa-floppy-disk"></i>

                        Update Data

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection