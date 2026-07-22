@extends('layouts.app')

@section('title', 'Edit Presensi')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="fw-bold mb-1">

            <i class="fa-solid fa-pen-to-square text-warning"></i>

            Edit Presensi

        </h3>

        <small class="text-muted">

            Perbarui status presensi siswa

        </small>

    </div>

    <a href="{{ route('presensi.index') }}" class="btn btn-secondary">

        <i class="fa-solid fa-arrow-left"></i>

        Kembali

    </a>

</div>

<div class="card border-0 shadow-sm">

    <div class="card-body">

        <form action="{{ route('presensi.update',$presensi) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="form-label">Nama Siswa</label>

                    <input type="text"
                           class="form-control"
                           value="{{ $presensi->siswa->nama }}"
                           readonly>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">Kelas</label>

                    <input type="text"
                           class="form-control"
                           value="{{ $presensi->siswa->kelas->nama_lengkap }}"
                           readonly>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">Guru</label>

                    <input type="text"
                           class="form-control"
                           value="{{ $presensi->guru->nama }}"
                           readonly>

                </div>

                <div class="col-md-3 mb-3">

                    <label class="form-label">Tanggal</label>

                    <input type="text"
                           class="form-control"
                           value="{{ $presensi->tanggal->format('d-m-Y') }}"
                           readonly>

                </div>

                <div class="col-md-3 mb-3">

                    <label class="form-label">Jam Scan</label>

                    <input type="text"
                           class="form-control"
                           value="{{ substr($presensi->jam_scan,0,5) }}"
                           readonly>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">Status</label>

                    <select name="status" class="form-select" required>

                        <option value="Hadir" {{ $presensi->status=='Hadir' ? 'selected' : '' }}>
                            Hadir
                        </option>

                        <option value="Terlambat" {{ $presensi->status=='Terlambat' ? 'selected' : '' }}>
                            Terlambat
                        </option>

                        <option value="Sakit" {{ $presensi->status=='Sakit' ? 'selected' : '' }}>
                            Sakit
                        </option>

                        <option value="Izin" {{ $presensi->status=='Izin' ? 'selected' : '' }}>
                            Izin
                        </option>

                        <option value="Alpha" {{ $presensi->status=='Alpha' ? 'selected' : '' }}>
                            Alpha
                        </option>

                    </select>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">Metode</label>

                    <select name="metode" class="form-select">

                        <option value="Barcode" {{ $presensi->metode=='Barcode' ? 'selected' : '' }}>
                            Barcode
                        </option>

                        <option value="QR" {{ $presensi->metode=='QR' ? 'selected' : '' }}>
                            QR
                        </option>

                        <option value="RFID" {{ $presensi->metode=='RFID' ? 'selected' : '' }}>
                            RFID
                        </option>

                        <option value="Fingerprint" {{ $presensi->metode=='Fingerprint' ? 'selected' : '' }}>
                            Fingerprint
                        </option>

                        <option value="FaceID" {{ $presensi->metode=='FaceID' ? 'selected' : '' }}>
                            Face ID
                        </option>

                        <option value="Manual" {{ $presensi->metode=='Manual' ? 'selected' : '' }}>
                            Manual
                        </option>

                    </select>

                </div>

                <div class="col-12 mb-3">

                    <label class="form-label">Keterangan</label>

                    <textarea name="keterangan"
                              rows="4"
                              class="form-control">{{ old('keterangan',$presensi->keterangan) }}</textarea>

                </div>

                <div class="col-12">

                    <button class="btn btn-success">

                        <i class="fa-solid fa-floppy-disk"></i>

                        Simpan Perubahan

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection