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
    background:#eef2f7;
    font-family:'Segoe UI',sans-serif;
}

.sidebar{
    width:260px;
    min-height:100vh;
    background:linear-gradient(180deg,#198754,#157347);
    position:sticky;
    top:0;
}

.sidebar .logo{
    color:#fff;
    font-size:22px;
    font-weight:700;
    letter-spacing:.5px;
    text-align:center;
    padding:12px 0 25px;
}

.sidebar a{
    color:rgba(255,255,255,.9);
    display:flex;
    align-items:center;
    gap:14px;
    padding:13px 18px;
    margin:5px 0;
    border-radius:12px;
    text-decoration:none;
    transition:.25s;
    font-weight:500;
}

.sidebar a i{
    width:22px;
    text-align:center;
    font-size:16px;
}

.sidebar a:hover{
    background:rgba(255,255,255,.12);
    transform:translateX(4px);
}

.sidebar a.active{
    background:#fff;
    color:#198754;
    box-shadow:0 8px 18px rgba(0,0,0,.12);
}

.content{
    flex:1;
    min-width:0;
}

.topbar{
    background:#fff;
    padding:18px 30px;
    box-shadow:0 2px 15px rgba(0,0,0,.05);
}

.page{
    padding:30px;
}

.user-box{
    border-top:1px solid rgba(255,255,255,.2);
    margin-top:25px;
    padding-top:20px;
    text-align:center;
}

.user-box img{
    width:70px;
    height:70px;
    border-radius:50%;
    object-fit:cover;
    border:3px solid rgba(255,255,255,.4);
}

.user-box h6{
    color:#fff;
    margin-top:10px;
    margin-bottom:2px;
}

.user-box small{
    color:#d8f3dc;
}

.logout-btn{
    margin-top:15px;
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

<a href="{{ route('profil') }}"
class="{{ request()->routeIs('profil') ? 'active' : '' }}">

<i class="fa-solid fa-id-card"></i>

Profil Akun

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

<a href="{{ route('pengurus-kelas.index') }}"
class="{{ request()->routeIs('pengurus-kelas.*') ? 'active' : '' }}">

<i class="fa-solid fa-users"></i>

Pengurus Kelas

</a>

<a href="{{ route('siswa.import') }}"
class="{{ request()->routeIs('siswa.import*') ? 'active' : '' }}">

<i class="fa-solid fa-file-import"></i>

Import Excel

</a>

<a href="{{ route('login-log.index') }}"
class="{{ request()->routeIs('login-log.*') ? 'active' : '' }}">

<i class="fa-solid fa-clock-rotate-left"></i>

Riwayat Login

</a>

<a href="{{ route('activity-log.index') }}"
class="{{ request()->routeIs('activity-log.*') ? 'active' : '' }}">

<i class="fa-solid fa-list-check"></i>

Activity Log

</a>

<a href="{{ route('pengaturan.index') }}"
class="{{ request()->routeIs('pengaturan.*') ? 'active' : '' }}">

<i class="fa-solid fa-gears"></i>

Pengaturan

</a>

@endif

@if(auth()->user()->isPetugasPresensi())

<a href="{{ route('presensi.create') }}"
class="{{ request()->routeIs('presensi.create') ? 'active' : '' }}">

<i class="fa-solid fa-barcode"></i>

Scan Presensi

</a>

<a href="{{ route('presensi.index') }}"
class="{{ request()->routeIs('presensi.index') ? 'active' : '' }}">

<i class="fa-solid fa-calendar-check"></i>

Data Presensi

</a>

@endif

@if(auth()->user()->isGuruAtauAdmin())

<a href="{{ route('rekap.index') }}"
class="{{ request()->routeIs('rekap.*') ? 'active' : '' }}">

<i class="fa-solid fa-chart-column"></i>

Rekap Presensi

</a>

<a href="{{ route('izin.index') }}"
class="{{ request()->routeIs('izin.*') ? 'active' : '' }}">

<i class="fa-solid fa-notes-medical"></i>

Data Izin / Sakit

</a>

@endif

<div class="user-box">

<img src="{{ asset('images/avatar-default.png') }}">

<h6>{{ auth()->user()->nama }}</h6>

<small>{{ ucfirst(str_replace('_',' ',auth()->user()->role)) }}</small>

<form action="{{ route('logout') }}" method="POST" class="logout-btn">

@csrf

<button class="btn btn-light w-100">

<i class="fa-solid fa-right-from-bracket me-2"></i>

Logout

</button>

</form>

</div>

</div>

<div class="content">

<div class="topbar d-flex justify-content-between align-items-center">

<div>

<h4 class="mb-0 fw-bold">

@yield('title','Dashboard')

</h4>

<small class="text-muted">

{{ now()->translatedFormat('l, d F Y') }}

</small>

</div>

<div>

<span class="badge bg-success fs-6 px-3 py-2">

<i class="fa-solid fa-user"></i>

{{ auth()->user()->nama }}

</span>

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

@if($errors->any())

<div class="alert alert-danger">

<ul class="mb-0">

@foreach($errors->all() as $error)

<li>{{ $error }}</li>

@endforeach

</ul>

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