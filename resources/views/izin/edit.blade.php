@extends('layouts.app')

@section('title', 'Edit Izin')

@section('content')

<div class="row justify-content-center">

    <div class="col-lg-8">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-warning">

                <h5 class="mb-0">

                    Edit Pengajuan Izin / Sakit

                </h5>

            </div>

            <form
                action="{{ route('izin.update', $izin) }}"
                method="POST">

                @csrf
                @method('PUT')

                <div class="card-body">

                    <div class="mb-3">

                        <label class="form-label">

                            Siswa

                        </label>

                        <select
                            name="siswa_id"
                            class="form-select"
                            required>

                            @foreach($siswas as $siswa)

                                <option
                                    value="{{ $siswa->id }}"
                                    @selected($izin->siswa_id == $siswa->id)>

                                    {{ $siswa->nama }}
                                    ({{ $siswa->nisn }})

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
                            value="{{ $izin->tanggal }}"
                            required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">

                            Jenis

                        </label>

                        <select
                            name="jenis"
                            class="form-select">

                            <option
                                value="Izin"
                                @selected($izin->jenis=='Izin')>

                                Izin

                            </option>

                            <option
                                value="Sakit"
                                @selected($izin->jenis=='Sakit')>

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
                            rows="4"
                            class="form-control">{{ $izin->keterangan }}</textarea>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">

                            Status

                        </label>

                        <select
                            name="status"
                            class="form-select">

                            <option
                                value="Pending"
                                @selected($izin->status=='Pending')>

                                Pending

                            </option>

                            <option
                                value="Disetujui"
                                @selected($izin->status=='Disetujui')>

                                Disetujui

                            </option>

                            <option
                                value="Ditolak"
                                @selected($izin->status=='Ditolak')>

                                Ditolak

                            </option>

                        </select>

                    </div>

                </div>

                <div class="card-footer text-end">

                    <a
                        href="{{ route('izin.index') }}"
                        class="btn btn-secondary">

                        Batal

                    </a>

                    <button
                        class="btn btn-warning">

                        Update

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection