@extends('layouts.app')

@section('title','Profil Akun')

@section('content')

<div class="card border-0 shadow-sm">

    <div class="card-header bg-success text-white">

        <i class="fa-solid fa-user"></i>

        Profil Akun

    </div>

    <div class="card-body">

        <table class="table">

            <tr>

                <th width="200">

                    Nama

                </th>

                <td>

                    {{ auth()->user()->nama }}

                </td>

            </tr>

            <tr>

                <th>

                    Username

                </th>

                <td>

                    {{ auth()->user()->username }}

                </td>

            </tr>

            <tr>

                <th>

                    Role

                </th>

                <td>

                    {{ ucfirst(str_replace('_',' ',auth()->user()->role)) }}

                </td>

            </tr>

            @if(auth()->user()->siswa)

            <tr>

                <th>

                    Kelas

                </th>

                <td>

                    {{ auth()->user()->siswa->kelas->nama_lengkap ?? '-' }}

                </td>

            </tr>

            @endif

        </table>

        @if(auth()->user()->isAdmin())

        <a href="{{ route('password.edit') }}"
            class="btn btn-success">

            <i class="fa-solid fa-key"></i>

            Ubah Password

        </a>

        @endif

    </div>

</div>

@endsection