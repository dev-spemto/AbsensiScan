@extends('layouts.app')

@section('title', 'Tambah Siswa')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="fw-bold mb-0">Tambah Data Siswa</h3>
        <small class="text-muted">Isi data siswa dengan lengkap</small>
    </div>

    <a href="{{ route('siswa.index') }}" class="btn btn-secondary">
        <i class="fa-solid fa-arrow-left"></i>
        Kembali
    </a>

</div>

<div class="card border-0 shadow-sm">

    <div class="card-body">

        <form action="{{ route('siswa.store') }}" method="POST" enctype="multipart/form-data">

            @csrf

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label">NIS</label>
                    <input type="text" name="nis" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">NISN</label>
                    <input type="text" name="nisn" class="form-control" required>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select">
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Kelas</label>

                    <select name="kelas_id" class="form-select">

                        @foreach($kelas as $k)

                            <option value="{{ $k->id }}">
                                {{ $k->nama_lengkap }}
                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" rows="3" class="form-control"></textarea>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Foto</label>
                    <input type="file" name="foto" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <select name="aktif" class="form-select">
                        <option value="1">Aktif</option>
                        <option value="0">Non Aktif</option>
                    </select>
                </div>

                <div class="col-md-12">
                    <button type="submit" class="btn btn-success">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Simpan Data
                    </button>
                </div>

            </div>

        </form>

    </div>

</div>

@endsection