@extends('layouts.app')

@section('title','Tambah Izin / Sakit')

@section('content')

<div class="card shadow-sm">

    <div class="card-header">

        <h5 class="mb-0">

            Tambah Pengajuan Izin / Sakit

        </h5>

    </div>

    <div class="card-body">

        <form
            action="{{ route('izin.store') }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf

            <div class="mb-3">

                <label class="form-label">
                    Siswa
                </label>

                <select
                    name="siswa_id"
                    class="form-select"
                    required>

                    <option value="">
                        -- Pilih Siswa --
                    </option>

                    @foreach($siswas as $siswa)

                        <option value="{{ $siswa->id }}">

                            {{ $siswa->nama }}

                        </option>

                    @endforeach

                </select>

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Tanggal

                </label>

                <input
                    type="date"
                    name="tanggal"
                    class="form-control"
                    value="{{ date('Y-m-d') }}"
                    required>

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Jenis

                </label>

                <select
                    name="jenis"
                    class="form-select"
                    required>

                    <option value="Izin">
                        Izin
                    </option>

                    <option value="Sakit">
                        Sakit
                    </option>

                </select>

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Keterangan

                </label>

                <textarea
                    name="keterangan"
                    class="form-control"
                    rows="4"></textarea>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Bukti Izin / Surat Dokter <span class="text-danger">*</span>
                </label>

                <input
                    type="file"
                    name="bukti"
                    class="form-control"
                    accept=".jpg,.jpeg,.png,.pdf"
                    required>

            </div>

            <button
                class="btn btn-success">

                Simpan

            </button>

            <a
                href="{{ route('izin.index') }}"
                class="btn btn-secondary">

                Kembali

            </a>

        </form>

    </div>

</div>

@endsection