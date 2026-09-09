@extends('layouts.app')

@section('title', 'Tambah Siswa')

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

    <div>
        <h3 class="fw-bold mb-1">
            <i class="fa-solid fa-user-plus text-success me-2"></i>
            Tambah Data Siswa
        </h3>

        <small class="text-muted">
            Tambahkan data siswa dengan lengkap dan benar.
        </small>
    </div>

    <a href="{{ route('siswa.index') }}"
       class="btn btn-secondary">

        <i class="fa-solid fa-arrow-left me-1"></i>
        Kembali

    </a>

</div>


@if($errors->any())

<div class="alert alert-danger border-0 shadow-sm">

    <div class="fw-semibold mb-2">

        <i class="fa-solid fa-circle-exclamation me-2"></i>
        Data belum dapat disimpan.

    </div>

    <ul class="mb-0">

        @foreach($errors->all() as $error)

            <li>{{ $error }}</li>

        @endforeach

    </ul>

</div>

@endif


<div class="card border-0 shadow-sm">

    <div class="card-header bg-white border-0 pt-4 px-4">

        <h5 class="fw-bold mb-1">

            <i class="fa-solid fa-id-card text-success me-2"></i>

            Identitas Siswa

        </h5>

        <small class="text-muted">

            Isi seluruh informasi yang diperlukan.

        </small>

    </div>


    <div class="card-body p-4">

        <form
            action="{{ route('siswa.store') }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf


            <div class="row">


                {{-- NIS --}}

                <div class="col-md-6 mb-3">

                    <label for="nis" class="form-label fw-semibold">

                        NIS

                    </label>

                    <input
                        type="text"
                        id="nis"
                        name="nis"
                        class="form-control @error('nis') is-invalid @enderror"
                        value="{{ old('nis') }}"
                        required
                        autocomplete="off">

                    @error('nis')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- NISN --}}

                <div class="col-md-6 mb-3">

                    <label for="nisn" class="form-label fw-semibold">

                        NISN

                    </label>

                    <input
                        type="text"
                        id="nisn"
                        name="nisn"
                        class="form-control @error('nisn') is-invalid @enderror"
                        value="{{ old('nisn') }}"
                        required
                        autocomplete="off">

                    @error('nisn')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- NAMA --}}

                <div class="col-md-12 mb-3">

                    <label for="nama" class="form-label fw-semibold">

                        Nama Lengkap

                    </label>

                    <input
                        type="text"
                        id="nama"
                        name="nama"
                        class="form-control @error('nama') is-invalid @enderror"
                        value="{{ old('nama') }}"
                        required
                        autocomplete="name">

                    @error('nama')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- TEMPAT LAHIR --}}

                <div class="col-md-6 mb-3">

                    <label for="tempat_lahir" class="form-label fw-semibold">

                        Tempat Lahir

                    </label>

                    <input
                        type="text"
                        id="tempat_lahir"
                        name="tempat_lahir"
                        class="form-control @error('tempat_lahir') is-invalid @enderror"
                        value="{{ old('tempat_lahir') }}"
                        required>

                    @error('tempat_lahir')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- TANGGAL LAHIR --}}

                <div class="col-md-6 mb-3">

                    <label for="tanggal_lahir" class="form-label fw-semibold">

                        Tanggal Lahir

                    </label>

                    <input
                        type="date"
                        id="tanggal_lahir"
                        name="tanggal_lahir"
                        class="form-control @error('tanggal_lahir') is-invalid @enderror"
                        value="{{ old('tanggal_lahir') }}"
                        required>

                    @error('tanggal_lahir')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- JENIS KELAMIN --}}

                <div class="col-md-6 mb-3">

                    <label for="jenis_kelamin" class="form-label fw-semibold">

                        Jenis Kelamin

                    </label>

                    <select
                        id="jenis_kelamin"
                        name="jenis_kelamin"
                        class="form-select @error('jenis_kelamin') is-invalid @enderror">

                        <option value="L"
                            {{ old('jenis_kelamin', 'L') === 'L' ? 'selected' : '' }}>
                            Laki-laki
                        </option>

                        <option value="P"
                            {{ old('jenis_kelamin') === 'P' ? 'selected' : '' }}>
                            Perempuan
                        </option>

                    </select>

                    @error('jenis_kelamin')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- KELAS --}}

                <div class="col-md-6 mb-3">

                    <label for="kelas_id" class="form-label fw-semibold">

                        Kelas

                    </label>

                    <select
                        id="kelas_id"
                        name="kelas_id"
                        class="form-select @error('kelas_id') is-invalid @enderror"
                        required>

                        <option value="">
                            -- Pilih Kelas --
                        </option>

                        @foreach($kelas as $k)

                            <option
                                value="{{ $k->id }}"
                                {{ old('kelas_id') == $k->id ? 'selected' : '' }}>

                                {{ $k->nama_lengkap }}

                            </option>

                        @endforeach

                    </select>

                    @error('kelas_id')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- JABATAN --}}

                <div class="col-md-6 mb-3">

                    <label for="jabatan" class="form-label fw-semibold">

                        Jabatan Kelas

                    </label>

                    <select
                        id="jabatan"
                        name="jabatan"
                        class="form-select @error('jabatan') is-invalid @enderror">

                        <option value=""
                            {{ old('jabatan') === null || old('jabatan') === '' ? 'selected' : '' }}>

                            Tidak Ada Jabatan

                        </option>

                        <option value="Ketua Kelas"
                            {{ old('jabatan') === 'Ketua Kelas' ? 'selected' : '' }}>

                            Ketua Kelas

                        </option>

                        <option value="Wakil Ketua"
                            {{ old('jabatan') === 'Wakil Ketua' ? 'selected' : '' }}>

                            Wakil Ketua

                        </option>

                        <option value="Sekretaris"
                            {{ old('jabatan') === 'Sekretaris' ? 'selected' : '' }}>

                            Sekretaris

                        </option>

                    </select>

                    @error('jabatan')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                    <div class="form-text">

                        Jabatan dapat dikosongkan jika siswa bukan pengurus kelas.

                    </div>

                </div>


                {{-- ALAMAT --}}

                <div class="col-md-12 mb-3">

                    <label for="alamat" class="form-label fw-semibold">

                        Alamat

                    </label>

                    <textarea
                        id="alamat"
                        name="alamat"
                        rows="3"
                        class="form-control @error('alamat') is-invalid @enderror"
                        placeholder="Masukkan alamat lengkap siswa">{{ old('alamat') }}</textarea>

                    @error('alamat')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- FOTO --}}

                <div class="col-md-6 mb-3">

                    <label for="foto" class="form-label fw-semibold">

                        Foto Siswa

                    </label>

                    <input
                        type="file"
                        id="foto"
                        name="foto"
                        class="form-control @error('foto') is-invalid @enderror"
                        accept="image/jpeg,image/png,image/jpg">

                    @error('foto')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                    <div class="form-text">

                        Format JPG, JPEG, atau PNG.

                    </div>

                </div>


                {{-- STATUS --}}

                <div class="col-md-6 mb-3">

                    <label for="aktif" class="form-label fw-semibold">

                        Status Siswa

                    </label>

                    <select
                        id="aktif"
                        name="aktif"
                        class="form-select @error('aktif') is-invalid @enderror">

                        <option value="1"
                            {{ old('aktif', '1') == '1' ? 'selected' : '' }}>

                            Aktif

                        </option>

                        <option value="0"
                            {{ old('aktif') == '0' ? 'selected' : '' }}>

                            Non Aktif

                        </option>

                    </select>

                    @error('aktif')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


            </div>


            <hr class="my-4">


            {{-- ACTION --}}

            <div class="d-flex justify-content-end gap-2">

                <a
                    href="{{ route('siswa.index') }}"
                    class="btn btn-light border">

                    <i class="fa-solid fa-xmark me-1"></i>

                    Batal

                </a>


                <button
                    type="submit"
                    class="btn btn-success">

                    <i class="fa-solid fa-floppy-disk me-1"></i>

                    Simpan Data

                </button>

            </div>


        </form>

    </div>

</div>

@endsection