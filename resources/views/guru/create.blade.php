@extends('layouts.app')

@section('title','Tambah Guru')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="fw-bold mb-0">Tambah Data Guru</h3>
        <small class="text-muted">Isi data guru dengan lengkap</small>
    </div>

    <a href="{{ route('guru.index') }}" class="btn btn-secondary">
        <i class="fa-solid fa-arrow-left"></i>
        Kembali
    </a>

</div>

<div class="card shadow-sm border-0">

    <div class="card-body">

        <form action="{{ route('guru.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label>NIP</label>
                    <input type="text"
                           name="nip"
                           class="form-control"
                           required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Nama Lengkap</label>
                    <input type="text"
                           name="nama"
                           class="form-control"
                           required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Tempat Lahir</label>
                    <input type="text"
                           name="tempat_lahir"
                           class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Tanggal Lahir</label>
                    <input type="date"
                           name="tanggal_lahir"
                           class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Jenis Kelamin</label>

                    <select name="jenis_kelamin"
                            class="form-select">

                        <option value="">- Pilih -</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>

                    </select>

                </div>

                <div class="col-md-6 mb-3">
                    <label>No HP</label>
                    <input type="text"
                           name="no_hp"
                           class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Email</label>
                    <input type="email"
                           name="email"
                           class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Foto</label>
                    <input type="file"
                           name="foto"
                           class="form-control">
                </div>

                <div class="col-md-12 mb-3">
                    <label>Alamat</label>

                    <textarea name="alamat"
                              rows="3"
                              class="form-control"></textarea>

                </div>

                <div class="col-md-6 mb-3">
                    <label>Username</label>
                    <input type="text"
                           name="username"
                           class="form-control"
                           required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Password</label>
                    <input type="password"
                           name="password"
                           class="form-control"
                           required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Status</label>

                    <select name="aktif"
                            class="form-select">

                        <option value="1">Aktif</option>
                        <option value="0">Non Aktif</option>

                    </select>

                </div>

                <div class="col-md-12">

                    <button class="btn btn-success">

                        <i class="fa-solid fa-floppy-disk"></i>

                        Simpan Data

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection