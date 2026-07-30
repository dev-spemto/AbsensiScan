@extends('layouts.app')

@section('title','Pengurus Kelas')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="fw-bold mb-1">

            <i class="fa-solid fa-users text-success"></i>

            Pengurus Kelas

        </h3>

        <small class="text-muted">

            Pengaturan Ketua, Wakil, dan Sekretaris setiap kelas

        </small>

    </div>

</div>

<div class="card shadow-sm border-0">

    <div class="card-header bg-success text-white">

        <i class="fa-solid fa-list"></i>

        Daftar Pengurus Kelas

    </div>

    <div class="table-responsive">

        <table class="table table-hover align-middle mb-0">

            <thead class="table-light">

                <tr>

                    <th width="60">No</th>

                    <th>Kelas</th>

                    <th>Ketua</th>

                    <th>Wakil</th>

                    <th>Sekretaris</th>

                    <th width="220">Aksi</th>

                </tr>

            </thead>

            <tbody>

            @forelse($pengurus as $index => $item)

                <tr>

                    <td>

                        {{ $index + 1 }}

                    </td>

                    <td>

                        <strong>

                            {{ $item->kelas->nama_lengkap }}

                        </strong>

                    </td>

                    <td>

                        @if($item->ketua)

                            <strong>{{ $item->ketua->nama }}</strong>

                            <br>

                            <small class="text-muted">
                                {{ optional($item->ketuaUser)->username }}
                            </small>

                        @else

                            <span class="text-muted">-</span>

                        @endif

                    </td>

                    <td>

                        @if($item->wakil)

                            <strong>{{ $item->wakil->nama }}</strong>

                            <br>

                            <small class="text-muted">

                                {{ optional($item->wakilUser)->username }}

                            </small>

                        @else

                            <span class="text-muted">-</span>

                        @endif

                    </td>

                    <td>

                        @if($item->sekretaris)

                            <strong>{{ $item->sekretaris->nama }}</strong>

                            <br>

                            <small class="text-muted">

                                {{ optional($item->sekretarisUser)->username }}

                            </small>

                        @else

                            <span class="text-muted">-</span>

                        @endif

                    </td>

                    <td>

                        <div class="d-grid gap-2">

                            <a href="{{ route('pengurus-kelas.edit',$item->id) }}"
                               class="btn btn-warning btn-sm">

                                <i class="fa-solid fa-pen"></i>

                                Edit Pengurus

                            </a>

                            <a href="{{ route('pengurus-kelas.password',$item->id) }}"
                               class="btn btn-primary btn-sm">

                                <i class="fa-solid fa-key"></i>

                                Ubah Password

                            </a>

                            <form action="{{ route('pengurus-kelas.reset-password',$item->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Password akan dikembalikan ke default. Lanjutkan?')">

                                @csrf

                                <button
                                    type="submit"
                                    class="btn btn-danger btn-sm w-100">

                                    <i class="fa-solid fa-rotate-left"></i>

                                    Reset Password

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="6" class="text-center py-5">

                        <i class="fa-solid fa-folder-open fa-3x text-secondary mb-3"></i>

                        <br>

                        Belum ada data pengurus kelas.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection