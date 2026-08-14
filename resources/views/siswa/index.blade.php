@extends('layouts.app')

@section('title', 'Data Siswa')

@section('content')

<style>
    .student-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
    }

    .student-page-title {
        display: flex;
        align-items: center;
        gap: 13px;
    }

    .student-page-icon {
        width: 46px;
        height: 46px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 13px;
        background: #e8f5ee;
        color: #198754;
        font-size: 19px;
    }

    .student-page-title h3 {
        margin: 0;
        font-size: 22px;
        font-weight: 700;
    }

    .student-page-title small {
        color: #6b7280;
    }

    .student-actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .student-actions .btn {
        border-radius: 9px;
        font-weight: 600;
    }

    .student-table-card {
        border: 0;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0, 0, 0, .05);
    }

    .student-table-card .card-body {
        padding: 0;
    }

    .student-table-wrapper {
        overflow-x: auto;
    }

    .student-table {
        width: 100%;
        min-width: 950px;
        margin: 0;
        vertical-align: middle;
    }

    .student-table thead th {
        padding: 14px 15px;
        background: #f0f8f4;
        color: #374151;
        border-bottom: 1px solid #dfe9e3;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
        text-transform: uppercase;
        letter-spacing: .25px;
    }

    .student-table tbody td {
        padding: 13px 15px;
        border-color: #edf0f2;
        font-size: 13px;
    }

    .student-table tbody tr {
        transition: background .18s ease;
    }

    .student-table tbody tr:hover {
        background: #f8fbf9;
    }

    .student-number {
        width: 55px;
        color: #6b7280;
        font-weight: 600;
    }

    .student-photo {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e5e7eb;
        background: #f3f4f6;
    }

    .student-name {
        color: #111827;
        font-weight: 700;
    }

    .student-code {
        color: #6b7280;
        font-size: 12px;
    }

    .student-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 9px;
        border-radius: 7px;
        font-size: 11px;
        font-weight: 700;
    }

    .badge-active {
        background: #e8f7ee;
        color: #157347;
    }

    .badge-inactive {
        background: #fdecec;
        color: #b42318;
    }

    .badge-ketua {
        background: #e8f7ee;
        color: #157347;
    }

    .badge-sekretaris {
        background: #eaf2ff;
        color: #175cd3;
    }

    .student-actions-cell {
        white-space: nowrap;
        text-align: center;
    }

    .student-action {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 0;
        border-radius: 8px;
        margin: 0 2px;
        transition: transform .18s ease, opacity .18s ease;
    }

    .student-action:hover {
        transform: translateY(-2px);
    }

    .student-action-view {
        background: #e8f4ff;
        color: #0d6efd;
    }

    .student-action-edit {
        background: #fff4d6;
        color: #a15c00;
    }

    .student-action-delete {
        background: #fdeaea;
        color: #dc3545;
    }

    .student-empty {
        padding: 60px 20px !important;
        text-align: center;
        color: #9ca3af;
    }

    .student-empty-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 14px;
        border-radius: 16px;
        background: #f3f4f6;
        color: #9ca3af;
        font-size: 24px;
    }

    .student-pagination {
        padding: 18px 20px;
        border-top: 1px solid #edf0f2;
    }

    .student-pagination .pagination {
        margin: 0;
    }

    .student-pagination .page-link {
        border: 0;
        margin: 0 2px;
        border-radius: 8px;
        color: #198754;
    }

    .student-pagination .page-item.active .page-link {
        background: #198754;
        color: #fff;
    }

    .student-alert {
        border: 0;
        border-radius: 12px;
    }

    @media (max-width: 767.98px) {

        .student-page-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .student-actions {
            width: 100%;
        }

        .student-actions .btn {
            flex: 1;
        }

        .student-page-title h3 {
            font-size: 19px;
        }

    }
</style>

@if(session('success'))

    <div class="alert alert-success student-alert alert-dismissible fade show" role="alert">

        <i class="fa-solid fa-circle-check me-2"></i>

        {{ session('success') }}

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
        ></button>

    </div>

@endif

<div class="student-page-header">

    <div class="student-page-title">

        <div class="student-page-icon">

            <i class="fa-solid fa-user-graduate"></i>

        </div>

        <div>

            <h3>Data Siswa</h3>

            <small>
                Daftar seluruh siswa
            </small>

        </div>

    </div>

    <div class="student-actions">

        <a
            href="{{ route('siswa.import') }}"
            class="btn btn-primary"
        >

            <i class="fa-solid fa-file-import me-1"></i>

            Import Excel

        </a>

        <a
            href="{{ route('siswa.create') }}"
            class="btn btn-success"
        >

            <i class="fa-solid fa-plus me-1"></i>

            Tambah Siswa

        </a>

    </div>

</div>

<div class="card student-table-card">

    <div class="card-body">

        <div class="student-table-wrapper">

            <table class="table student-table">

                <thead>

                    <tr>

                        <th class="student-number">
                            No
                        </th>

                        <th>
                            Foto
                        </th>

                        <th>
                            NIS
                        </th>

                        <th>
                            NISN
                        </th>

                        <th>
                            Nama
                        </th>

                        <th>
                            Kelas
                        </th>

                        <th>
                            Jabatan
                        </th>

                        <th>
                            Status
                        </th>

                        <th width="150" class="text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                @forelse($siswas as $index => $siswa)

                    <tr>

                        <td class="student-number">

                            {{ $siswas->firstItem() + $index }}

                        </td>

                        <td>

                            @if($siswa->foto)

                                <img
                                    src="{{ asset('storage/'.$siswa->foto) }}"
                                    alt="{{ $siswa->nama }}"
                                    class="student-photo"
                                >

                            @else

                                <img
                                    src="https://ui-avatars.com/api/?name={{ urlencode($siswa->nama) }}&background=198754&color=fff&size=100"
                                    alt="{{ $siswa->nama }}"
                                    class="student-photo"
                                >

                            @endif

                        </td>

                        <td>

                            <span class="student-code">
                                {{ $siswa->nis ?: '-' }}
                            </span>

                        </td>

                        <td>

                            <span class="student-code">
                                {{ $siswa->nisn ?: '-' }}
                            </span>

                        </td>

                        <td>

                            <div class="student-name">
                                {{ $siswa->nama }}
                            </div>

                        </td>

                        <td>

                            {{ optional($siswa->kelas)->nama_lengkap ?? '-' }}

                        </td>

                        <td>

                            @if($siswa->jabatan === 'Ketua Kelas')

                                <span class="student-badge badge-ketua">

                                    <i class="fa-solid fa-crown"></i>

                                    Ketua Kelas

                                </span>

                            @elseif($siswa->jabatan === 'Sekretaris')

                                <span class="student-badge badge-sekretaris">

                                    <i class="fa-solid fa-pen"></i>

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

                                <span class="student-badge badge-active">

                                    <i class="fa-solid fa-circle-check"></i>

                                    Aktif

                                </span>

                            @else

                                <span class="student-badge badge-inactive">

                                    <i class="fa-solid fa-circle-xmark"></i>

                                    Nonaktif

                                </span>

                            @endif

                        </td>

                        <td class="student-actions-cell">

                            <a
                                href="{{ route('siswa.show', $siswa) }}"
                                class="student-action student-action-view"
                                title="Detail"
                            >

                                <i class="fa-solid fa-eye"></i>

                            </a>

                            <a
                                href="{{ route('siswa.edit', $siswa) }}"
                                class="student-action student-action-edit"
                                title="Edit"
                            >

                                <i class="fa-solid fa-pen"></i>

                            </a>

                            <form
                                action="{{ route('siswa.destroy', $siswa) }}"
                                method="POST"
                                class="d-inline delete-student-form"
                            >

                                @csrf

                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="student-action student-action-delete"
                                    title="Hapus"
                                >

                                    <i class="fa-solid fa-trash"></i>

                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="9"
                            class="student-empty"
                        >

                            <div class="student-empty-icon">

                                <i class="fa-solid fa-folder-open"></i>

                            </div>

                            <div class="fw-semibold text-secondary">
                                Belum ada data siswa
                            </div>

                            <small>
                                Data siswa akan muncul di sini setelah ditambahkan.
                            </small>

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        @if($siswas->hasPages())

            <div class="student-pagination">

                {{ $siswas->links() }}

            </div>

        @endif

    </div>

</div>

@endsection

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.delete-student-form').forEach(function (form) {

        form.addEventListener('submit', function (event) {

            event.preventDefault();

            Swal.fire({
                title: 'Hapus data siswa?',
                text: 'Data siswa yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                focusCancel: true
            }).then(function (result) {

                if (result.isConfirmed) {
                    form.submit();
                }

            });

        });

    });

});

</script>

@endpush