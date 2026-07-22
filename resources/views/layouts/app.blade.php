<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<meta name="csrf-token" content="{{ csrf_token() }}">

<title>@yield('title','Presensi Siswa')</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>

body{
    background:#f5f6fa;
}

.sidebar{
    width:250px;
    min-height:100vh;
    background:#198754;
}

.sidebar .logo{
    font-size:24px;
    font-weight:bold;
    color:white;
}

.sidebar a{
    color:white;
    text-decoration:none;
    display:block;
    padding:12px 18px;
    border-radius:8px;
    margin-bottom:5px;
    transition:.2s;
}

.sidebar a:hover{
    background:rgba(255,255,255,.15);
}

.sidebar a.active{
    background:white;
    color:#198754;
}

.content{
    flex:1;
}

.topbar{
    background:white;
    padding:15px;
    box-shadow:0 2px 10px rgba(0,0,0,.08);
}

.page{
    padding:25px;
}

</style>

@stack('styles')

</head>

<body>

<div class="d-flex">

<div class="sidebar p-3">

<div class="logo mb-4">

<i class="fa-solid fa-school"></i>

Presensi Siswa

</div>

<a href="{{ route('dashboard') }}"
class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">

    <i class="fa-solid fa-house"></i>

    Dashboard

</a>

@if(auth()->user()->isAdmin())

<a href="{{ route('siswa.index') }}"
class="{{ request()->routeIs('siswa.*') ? 'active' : '' }}">

    <i class="fa-solid fa-user-graduate"></i>

    Data Siswa

</a>

<a href="{{ route('guru.index') }}"
class="{{ request()->routeIs('guru.*') ? 'active' : '' }}">

    <i class="fa-solid fa-chalkboard-user"></i>

    Data Guru

</a>

<a href="{{ route('siswa.import') }}"
class="{{ request()->routeIs('siswa.import*') ? 'active' : '' }}">

    <i class="fa-solid fa-file-import"></i>

    Import Excel

</a>

@endif

<a href="{{ route('presensi.index') }}"
class="{{ request()->routeIs('presensi.*') ? 'active' : '' }}">

    <i class="fa-solid fa-calendar-check"></i>

    Presensi

</a>

<a href="{{ route('rekap.index') }}"
class="{{ request()->routeIs('rekap.*') ? 'active' : '' }}">

    <i class="fa-solid fa-chart-column"></i>

    Rekap Presensi

</a>

<hr class="text-white">

<form action="{{ route('logout') }}" method="POST">

    @csrf

    <button class="btn btn-link text-white text-decoration-none p-0">

        <i class="fa-solid fa-right-from-bracket"></i>

        Logout

    </button>

</form>

</div>

<div class="content">

<div class="topbar d-flex justify-content-between align-items-center">

<h4 class="mb-0">

@yield('title','Dashboard')

</h4>

<div>

<i class="fa-solid fa-user"></i>

{{ auth()->user()->nama ?? 'Administrator' }}

</div>

</div>

<div class="page">

@if(session('success'))

<div class="alert alert-success">

{{ session('success') }}

</div>

@endif

@if(session('error'))

<div class="alert alert-danger">

{{ session('error') }}

</div>

@endif

@yield('content')

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>

</html>