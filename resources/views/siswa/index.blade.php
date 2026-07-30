@extends('layouts.app')

@section('content')

@if(session('success'))

<div class="alert alert-success alert-dismissible fade show" role="alert">

    <i class="fa-solid fa-circle-check me-2"></i>

    {{ session('success') }}

    <button type="button"
            class="btn-close"
            data-bs-dismiss="alert">
    </button>

</div>

@endif

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="fw-bold mb-0">

            <i class="fa-solid fa-user-graduate text-success"></i>

            Data Siswa

        </h3>

        <small class="text-muted">

            Daftar seluruh siswa

        </small>

    </div>

    <div>

        <a href="{{ route('siswa.import') }}" class="btn btn-primary">

            <i class="fa-solid fa-file-import"></i>

            Import Excel

        </a>

        <a href="{{ route('siswa.create') }}" class="btn btn-success">

            <i class="fa-solid fa-plus"></i>

            Tambah Siswa

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
                        <th>NIS</th>
                        <th>NISN</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Jabatan</th>
                        <th>Status</th>
                        <th width="170" class="text-center">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($siswas as $index => $siswa)

                    <tr>

                        <td>

                            {{ $siswas->firstItem() + $index }}

                        </td>

                        <td>

                            @if($siswa->foto)

                                <img
                                    src="{{ asset('storage/'.$siswa->foto) }}"
                                    width="45"
                                    height="45"
                                    class="rounded-circle border"
                                    style="object-fit:cover;">

                            @else

                                <img
                                    src="https://ui-avatars.com/api/?name={{ urlencode($siswa->nama) }}&background=198754&color=fff"
                                    width="45"
                                    height="45"
                                    class="rounded-circle">

                            @endif

                        </td>

                        <td>{{ $siswa->nis }}</td>

                        <td>{{ $siswa->nisn }}</td>

                        <td>

                            <strong>{{ $siswa->nama }}</strong>

                        </td>

                        <td>

                            {{ $siswa->kelas->nama_lengkap }}

                        </td>

                        <td>

                            @if($siswa->jabatan == 'Ketua Kelas')

                                <span class="badge bg-success">

                                    Ketua Kelas

                                </span>

                            @elseif($siswa->jabatan == 'Sekretaris')

                                <span class="badge bg-primary">

                                    Sekretaris

                                </span>

                            @else

                                <span class="text-muted">

                                    -

                                </span>

                            @endif

                        </td>

                        <td>

                            @if($siswa->aktif)

                                <span class="badge bg-success">

                                    Aktif

                                </span>

                            @else

                                <span class="badge bg-danger">

                                    Non Aktif

                                </span>

                            @endif

                        </td>

                        <td class="text-center">

                            <a href="{{ route('siswa.show', $siswa) }}"
                               class="btn btn-info btn-sm"
                               title="Detail">

                                <i class="fa-solid fa-eye"></i>

                            </a>

                            <a href="{{ route('siswa.edit', $siswa) }}"
                               class="btn btn-warning btn-sm"
                               title="Edit">

                                <i class="fa-solid fa-pen"></i>

                            </a>

                            <form action="{{ route('siswa.destroy', $siswa) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus data siswa ini?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-danger btn-sm"
                                        title="Hapus">

                                    <i class="fa-solid fa-trash"></i>

                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="9" class="text-center text-muted py-5">

                            <i class="fa-solid fa-folder-open fa-2x mb-3 d-block"></i>

                            Belum ada data siswa.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-3">

            {{ $siswas->links() }}

        </div>

    </div>

</div>

@endsection