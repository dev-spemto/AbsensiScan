@extends('layouts.app')

@section('title', 'Edit Siswa')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="fw-bold mb-0">Edit Data Siswa</h3>
        <small class="text-muted">Perbarui data siswa</small>
    </div>

    <a href="{{ route('siswa.index') }}" class="btn btn-secondary">
        <i class="fa-solid fa-arrow-left"></i>
        Kembali
    </a>

</div>

<div class="card border-0 shadow-sm">

    <div class="card-body">

        <form action="{{ route('siswa.update', $siswa->id) }}" method="POST" enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label">NIS</label>
                    <input type="text" name="nis" class="form-control" value="{{ old('nis', $siswa->nis) }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">NISN</label>
                    <input type="text" name="nisn" class="form-control" value="{{ old('nisn', $siswa->nisn) }}" required>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama', $siswa->nama) }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Jenis Kelamin</label>

                    <select name="jenis_kelamin" class="form-select">

                        <option value="L" {{ $siswa->jenis_kelamin == 'L' ? 'selected' : '' }}>
                            Laki-laki
                        </option>

                        <option value="P" {{ $siswa->jenis_kelamin == 'P' ? 'selected' : '' }}>
                            Perempuan
                        </option>

                    </select>

                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Kelas</label>

                    <select name="kelas_id" class="form-select">

                        @foreach($kelas as $k)

                            <option value="{{ $k->id }}" {{ $siswa->kelas_id == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_lengkap }}
                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">Alamat</label>

                    <textarea name="alamat" rows="3" class="form-control">{{ old('alamat', $siswa->alamat) }}</textarea>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">Foto Baru</label>

                    <input type="file" name="foto" class="form-control">

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">Status</label>

                    <select name="aktif" class="form-select">

                        <option value="1" {{ $siswa->aktif ? 'selected' : '' }}>
                            Aktif
                        </option>

                        <option value="0" {{ !$siswa->aktif ? 'selected' : '' }}>
                            Non Aktif
                        </option>

                    </select>

                </div>

                <div class="col-md-12 mt-3">

                    <button type="submit" class="btn btn-primary">

                        <i class="fa-solid fa-floppy-disk"></i>

                        Update Data

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection