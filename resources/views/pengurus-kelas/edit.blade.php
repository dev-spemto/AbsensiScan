@extends('layouts.app')

@section('title','Edit Pengurus Kelas')

@section('content')

<div class="row justify-content-center">

    <div class="col-lg-8">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-success text-white">

                <i class="fa-solid fa-users"></i>

                Edit Pengurus Kelas

            </div>

            <div class="card-body">

                <form method="POST"
                      action="{{ route('pengurus-kelas.update',$pengurus->id) }}">

                    @csrf
                    @method('PUT')

                    <div class="mb-4">

                        <label class="form-label fw-bold">

                            Kelas

                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="{{ $pengurus->kelas->nama_lengkap }}"
                            readonly>

                    </div>

                    <div class="mb-4">

                        <label class="form-label">

                            Ketua Kelas

                        </label>

                        <select
                            name="ketua_siswa_id"
                            class="form-select">

                            <option value="">-- Pilih Ketua --</option>

                            @foreach($siswas as $siswa)

                                <option
                                    value="{{ $siswa->id }}"
                                    {{ $pengurus->ketua_siswa_id == $siswa->id ? 'selected' : '' }}>

                                    {{ $siswa->nama }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="mb-4">

                        <label class="form-label">

                            Wakil Ketua

                        </label>

                        <select
                            name="wakil_siswa_id"
                            class="form-select">

                            <option value="">-- Pilih Wakil --</option>

                            @foreach($siswas as $siswa)

                                <option
                                    value="{{ $siswa->id }}"
                                    {{ $pengurus->wakil_siswa_id == $siswa->id ? 'selected' : '' }}>

                                    {{ $siswa->nama }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="mb-4">

                        <label class="form-label">

                            Sekretaris

                        </label>

                        <select
                            name="sekretaris_siswa_id"
                            class="form-select">

                            <option value="">-- Pilih Sekretaris --</option>

                            @foreach($siswas as $siswa)

                                <option
                                    value="{{ $siswa->id }}"
                                    {{ $pengurus->sekretaris_siswa_id == $siswa->id ? 'selected' : '' }}>

                                    {{ $siswa->nama }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <hr>

                    <div class="alert alert-info mb-4">

                        <strong>Informasi Akun Login</strong>

                        <ul class="mb-0 mt-2">

                            <li>Username Ketua : <strong>spemto@{{ strtolower($pengurus->kelas->tingkat.$pengurus->kelas->nama_kelas) }}</strong></li>

                            <li>Password Ketua : <strong>ketua@{{ strtolower($pengurus->kelas->tingkat.$pengurus->kelas->nama_kelas) }}</strong></li>

                            <li>Username Wakil : <strong>wakil@{{ strtolower($pengurus->kelas->tingkat.$pengurus->kelas->nama_kelas) }}</strong></li>

                            <li>Password Wakil : <strong>wakil@{{ strtolower($pengurus->kelas->tingkat.$pengurus->kelas->nama_kelas) }}</strong></li>

                            <li>Username Sekretaris : <strong>sekretaris@{{ strtolower($pengurus->kelas->tingkat.$pengurus->kelas->nama_kelas) }}</strong></li>

                            <li>Password Sekretaris : <strong>sekretaris@{{ strtolower($pengurus->kelas->tingkat.$pengurus->kelas->nama_kelas) }}</strong></li>

                        </ul>

                    </div>

                    <div class="d-flex gap-2">

                        <button
                            type="submit"
                            class="btn btn-success">

                            <i class="fa-solid fa-floppy-disk"></i>

                            Simpan

                        </button>

                        <a
                            href="{{ route('pengurus-kelas.index') }}"
                            class="btn btn-secondary">

                            <i class="fa-solid fa-arrow-left"></i>

                            Kembali

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection