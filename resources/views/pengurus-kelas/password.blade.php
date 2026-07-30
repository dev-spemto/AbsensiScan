@extends('layouts.app')

@section('title','Ubah Password Pengurus')

@section('content')

<div class="row justify-content-center">

    <div class="col-lg-7">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-success text-white">

                <i class="fa-solid fa-key"></i>

                Ubah Password Pengurus Kelas

            </div>

            <div class="card-body">

                <div class="alert alert-info">

                    <strong>Kelas :</strong>

                    {{ $pengurus->kelas->nama_lengkap }}

                    <hr>

                    <small>

                        Kosongkan password apabila akun tersebut tidak ingin diubah.

                    </small>

                </div>

                <form action="{{ route('pengurus-kelas.password.update',$pengurus->id) }}"
                      method="POST">

                    @csrf

                    @method('PUT')

                    {{-- Ketua --}}

                    <div class="mb-4">

                        <label class="form-label fw-bold">

                            Ketua Kelas

                        </label>

                        <input
                            type="text"
                            class="form-control mb-2"
                            value="{{ optional($pengurus->ketuaUser)->username }}"
                            readonly>

                        <input
                            type="password"
                            name="ketua_password"
                            class="form-control"
                            placeholder="Password baru Ketua">

                    </div>

                    {{-- Wakil --}}

                    <div class="mb-4">

                        <label class="form-label fw-bold">

                            Wakil Kelas

                        </label>

                        <input
                            type="text"
                            class="form-control mb-2"
                            value="{{ optional($pengurus->wakilUser)->username }}"
                            readonly>

                        <input
                            type="password"
                            name="wakil_password"
                            class="form-control"
                            placeholder="Password baru Wakil">

                    </div>

                    {{-- Sekretaris --}}

                    <div class="mb-4">

                        <label class="form-label fw-bold">

                            Sekretaris

                        </label>

                        <input
                            type="text"
                            class="form-control mb-2"
                            value="{{ optional($pengurus->sekretarisUser)->username }}"
                            readonly>

                        <input
                            type="password"
                            name="sekretaris_password"
                            class="form-control"
                            placeholder="Password baru Sekretaris">

                    </div>

                    <div class="d-flex justify-content-between">

                        <a href="{{ route('pengurus-kelas.index') }}"
                           class="btn btn-secondary">

                            <i class="fa-solid fa-arrow-left"></i>

                            Kembali

                        </a>

                        <button
                            class="btn btn-success">

                            <i class="fa-solid fa-floppy-disk"></i>

                            Simpan Password

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection