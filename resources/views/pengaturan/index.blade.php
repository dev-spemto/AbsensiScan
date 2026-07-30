@extends('layouts.app')

@section('title','Pengaturan Sekolah')

@section('content')

<form action="{{ route('pengaturan.update') }}"
      method="POST"
      enctype="multipart/form-data">

@csrf
@method('PUT')

<div class="row">

    {{-- KIRI --}}
    <div class="col-lg-8">

        <div class="card shadow-sm border-0 mb-4">

            <div class="card-header bg-success text-white">

                Informasi Sekolah

            </div>

            <div class="card-body">

                <div class="mb-3">

                    <label class="form-label">

                        Nama Sekolah

                    </label>

                    <input
                        type="text"
                        name="nama_sekolah"
                        class="form-control"
                        value="{{ old('nama_sekolah',$pengaturan->nama_sekolah ?? '') }}">

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Alamat

                    </label>

                    <textarea
                        name="alamat_sekolah"
                        class="form-control"
                        rows="3">{{ old('alamat_sekolah',$pengaturan->alamat_sekolah ?? '') }}</textarea>

                </div>

                <div class="row">

                    <div class="col-md-6">

                        <label class="form-label">

                            Telepon

                        </label>

                        <input
                            type="text"
                            name="telepon"
                            class="form-control"
                            value="{{ old('telepon',$pengaturan->telepon ?? '') }}">

                    </div>

                    <div class="col-md-6">

                        <label class="form-label">

                            Email

                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            value="{{ old('email',$pengaturan->email ?? '') }}">

                    </div>

                </div>

                <div class="mt-3">

                    <label class="form-label">

                        Kepala Sekolah

                    </label>

                    <input
                        type="text"
                        name="kepala_sekolah"
                        class="form-control"
                        value="{{ old('kepala_sekolah',$pengaturan->kepala_sekolah ?? '') }}">

                </div>

            </div>

        </div>

        <div class="card shadow-sm border-0">

            <div class="card-header bg-primary text-white">

                Jam Presensi

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6">

                        <label>Jam Masuk</label>

                        <input
                            type="time"
                            name="jam_masuk"
                            class="form-control"
                            value="{{ old('jam_masuk',$pengaturan->jam_masuk ?? '') }}">

                    </div>

                    <div class="col-md-6">

                        <label>Batas Terlambat</label>

                        <input
                            type="time"
                            name="batas_terlambat"
                            class="form-control"
                            value="{{ old('batas_terlambat',$pengaturan->batas_terlambat ?? '') }}">

                    </div>

                </div>

                <div class="row mt-3">

                    <div class="col-md-6">

                        <label>Scan Mulai</label>

                        <input
                            type="time"
                            name="scan_mulai"
                            class="form-control"
                            value="{{ old('scan_mulai',$pengaturan->scan_mulai ?? '') }}">

                    </div>

                    <div class="col-md-6">

                        <label>Scan Selesai</label>

                        <input
                            type="time"
                            name="scan_selesai"
                            class="form-control"
                            value="{{ old('scan_selesai',$pengaturan->scan_selesai ?? '') }}">

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- KANAN --}}
    <div class="col-lg-4">

        <div class="card shadow-sm border-0 mb-4">

            <div class="card-header bg-warning">

                Logo Sekolah

            </div>

            <div class="card-body text-center">

                @if(!empty($pengaturan->logo))

                    <img
                        src="{{ asset('storage/'.$pengaturan->logo) }}"
                        class="img-fluid rounded mb-3">

                @endif

                <input
                    type="file"
                    name="logo"
                    class="form-control">

            </div>

        </div>

        <div class="card shadow-sm border-0 mb-4">

            <div class="card-header bg-secondary text-white">

                Sistem

            </div>

            <div class="card-body">

                <label class="mb-2">

                    Timezone

                </label>

                <input
                    type="text"
                    name="timezone"
                    class="form-control mb-3"
                    value="{{ old('timezone',$pengaturan->timezone ?? 'Asia/Jakarta') }}">

                <div class="form-check form-switch">

                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="aktifkan_foto"
                        value="1"
                        {{ old('aktifkan_foto',$pengaturan->aktifkan_foto ?? true) ? 'checked' : '' }}>

                    <label class="form-check-label">

                        Aktifkan Foto

                    </label>

                </div>

                <div class="form-check form-switch mt-3">

                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="aktifkan_suara"
                        value="1"
                        {{ old('aktifkan_suara',$pengaturan->aktifkan_suara ?? true) ? 'checked' : '' }}>

                    <label class="form-check-label">

                        Aktifkan Suara

                    </label>

                </div>

            </div>

        </div>

        <button
            class="btn btn-success w-100">

            <i class="fa-solid fa-floppy-disk"></i>

            Simpan Pengaturan

        </button>

    </div>

</div>

</form>

@endsection