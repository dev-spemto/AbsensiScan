@extends('layouts.app')

@section('title', 'Detail Izin')

@section('content')

<div class="row justify-content-center">

    <div class="col-lg-8">

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-success text-white">

                <h5 class="mb-0">

                    Detail Pengajuan Izin

                </h5>

            </div>

            <div class="card-body">

                <table class="table">

                    <tr>

                        <th width="180">Nama Siswa</th>

                        <td>{{ $izin->siswa->nama }}</td>

                    </tr>

                    <tr>

                        <th>NISN</th>

                        <td>{{ $izin->siswa->nisn }}</td>

                    </tr>

                    <tr>

                        <th>Tanggal</th>

                        <td>{{ \Carbon\Carbon::parse($izin->tanggal)->format('d-m-Y') }}</td>

                    </tr>

                    <tr>

                        <th>Jenis</th>

                        <td>

                            <span class="badge bg-{{ $izin->jenis == 'Sakit' ? 'danger' : 'warning' }}">

                                {{ $izin->jenis }}

                            </span>

                        </td>

                    </tr>

                    <tr>

                        <th>Status</th>

                        <td>

                            @php
                                $warna = match($izin->status){
                                    'Pending' => 'warning',
                                    'Disetujui' => 'success',
                                    'Ditolak' => 'danger',
                                    default => 'secondary'
                                };
                            @endphp

                            <span class="badge bg-{{ $warna }}">

                                {{ $izin->status }}

                            </span>

                        </td>

                    </tr>

                    <tr>

                        <th>Keterangan</th>

                        <td>{{ $izin->keterangan ?: '-' }}</td>

                    </tr>

                    <tr>

                        <th>Bukti</th>

                        <td>

                            @if($izin->bukti)

                                @php
                                    $ext = strtolower(pathinfo($izin->bukti, PATHINFO_EXTENSION));
                                @endphp

                                @if(in_array($ext,['jpg','jpeg','png','gif','webp']))

                                    <img
                                        src="{{ asset('storage/'.$izin->bukti) }}"
                                        class="img-fluid rounded border mb-2"
                                        style="max-height:350px;">

                                @endif

                                <br>

                                <a
                                    href="{{ asset('storage/'.$izin->bukti) }}"
                                    target="_blank"
                                    class="btn btn-outline-primary btn-sm">

                                    <i class="fa-solid fa-eye"></i>

                                    Lihat / Download Bukti

                                </a>

                            @else

                                -

                            @endif

                        </td>

                    </tr>

                </table>

            </div>

            <div class="card-footer d-flex justify-content-between">

                <a
                    href="{{ route('izin.index') }}"
                    class="btn btn-secondary">

                    Kembali

                </a>

                @if($izin->status == 'Pending')

                <div>

                    <form
                        action="{{ route('izin.update',$izin) }}"
                        method="POST"
                        class="d-inline">

                        @csrf
                        @method('PUT')

                        <input type="hidden" name="siswa_id" value="{{ $izin->siswa_id }}">
                        <input type="hidden" name="tanggal" value="{{ $izin->tanggal }}">
                        <input type="hidden" name="jenis" value="{{ $izin->jenis }}">
                        <input type="hidden" name="keterangan" value="{{ $izin->keterangan }}">
                        <input type="hidden" name="status" value="Disetujui">

                        <button class="btn btn-success">

                            <i class="fa-solid fa-check"></i>

                            Setujui

                        </button>

                    </form>

                    <form
                        action="{{ route('izin.update',$izin) }}"
                        method="POST"
                        class="d-inline">

                        @csrf
                        @method('PUT')

                        <input type="hidden" name="siswa_id" value="{{ $izin->siswa_id }}">
                        <input type="hidden" name="tanggal" value="{{ $izin->tanggal }}">
                        <input type="hidden" name="jenis" value="{{ $izin->jenis }}">
                        <input type="hidden" name="keterangan" value="{{ $izin->keterangan }}">
                        <input type="hidden" name="status" value="Ditolak">

                        <button class="btn btn-danger">

                            <i class="fa-solid fa-xmark"></i>

                            Tolak

                        </button>

                    </form>

                </div>

                @endif

            </div>

        </div>

    </div>

</div>

@endsection