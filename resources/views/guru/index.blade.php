@extends('layouts.app')

@section('title','Data Guru')

@section('content')

@if(session('success'))

<div class="alert alert-success alert-dismissible fade show">

    <i class="fa-solid fa-circle-check"></i>

    {{ session('success') }}

    <button class="btn-close" data-bs-dismiss="alert"></button>

</div>

@endif

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="fw-bold mb-0">

            Data Guru

        </h3>

        <small class="text-muted">

            Daftar seluruh guru

        </small>

    </div>

    <div>

        <a href="{{ route('guru.create') }}" class="btn btn-success">

            <i class="fa-solid fa-plus"></i>

            Tambah Guru

        </a>

    </div>

</div>

<div class="card border-0 shadow-sm">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-success">

                    <tr>

                        <th width="60">No</th>

                        <th>Foto</th>

                        <th>NIP</th>

                        <th>Nama</th>

                        <th>Username</th>

                        <th>Status</th>

                        <th width="180">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($gurus as $index => $guru)

                    <tr>

                        <td>

                            {{ $gurus->firstItem() + $index }}

                        </td>

                        <td>

                            @if($guru->foto)

                                <img src="{{ asset('storage/'.$guru->foto) }}"
                                     width="45"
                                     height="45"
                                     class="rounded-circle"
                                     style="object-fit:cover;">

                            @else

                                <img src="https://ui-avatars.com/api/?name={{ urlencode($guru->nama) }}"
                                     width="45"
                                     height="45"
                                     class="rounded-circle">

                            @endif

                        </td>

                        <td>

                            {{ $guru->nip }}

                        </td>

                        <td>

                            <strong>{{ $guru->nama }}</strong>

                        </td>

                        <td>

                            {{ $guru->username }}

                        </td>

                        <td>

                            @if($guru->aktif)

                                <span class="badge bg-success">

                                    Aktif

                                </span>

                            @else

                                <span class="badge bg-danger">

                                    Non Aktif

                                </span>

                            @endif

                        </td>

                        <td>

                            <a href="{{ route('guru.show',$guru) }}"
                               class="btn btn-info btn-sm">

                                <i class="fa-solid fa-eye"></i>

                            </a>

                            <a href="{{ route('guru.edit',$guru) }}"
                               class="btn btn-warning btn-sm">

                                <i class="fa-solid fa-pen"></i>

                            </a>

                            <form action="{{ route('guru.destroy',$guru) }}"
                                  method="POST"
                                  class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin ingin menghapus guru ini?')">

                                    <i class="fa-solid fa-trash"></i>

                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7" class="text-center text-muted py-4">

                            Belum ada data guru.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-3">

            {{ $gurus->links() }}

        </div>

    </div>

</div>

@endsection