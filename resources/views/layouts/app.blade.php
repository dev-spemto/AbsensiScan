<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Presensi Siswa')</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        rel="stylesheet"
    >

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>

        :root {
            --primary: #198754;
            --primary-dark: #157347;
            --primary-soft: #e8f5ee;
            --sidebar-width: 270px;
            --topbar-height: 72px;
            --bg: #f4f7fb;
            --text: #1f2937;
            --muted: #6b7280;
            --border: #e5e7eb;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            min-height: 100%;
        }

        body {
            margin: 0;
            background: var(--bg);
            color: var(--text);
            font-family: 'Segoe UI', sans-serif;
        }

        a {
            text-decoration: none;
        }

        /* =========================================================
           APP
        ========================================================= */

        .app {
            min-height: 100vh;
            display: flex;
        }

        /* =========================================================
           SIDEBAR
        ========================================================= */

        .sidebar {
            width: var(--sidebar-width);
            min-width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1050;
            display: flex;
            flex-direction: column;
            background: linear-gradient(
                180deg,
                var(--primary) 0%,
                var(--primary-dark) 100%
            );
            color: #fff;
            padding: 18px 14px;
            overflow-y: auto;
            transition: transform .3s ease;
        }

        .sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,.25);
            border-radius: 20px;
        }

        /* =========================================================
           BRAND
        ========================================================= */

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 10px 22px;
            color: #fff;
        }

        .brand-icon {
            width: 44px;
            height: 44px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 13px;
            background: rgba(255,255,255,.16);
            font-size: 20px;
        }

        .brand-title {
            font-size: 18px;
            font-weight: 700;
            line-height: 1.1;
        }

        .brand-subtitle {
            display: block;
            margin-top: 3px;
            color: rgba(255,255,255,.72);
            font-size: 11px;
        }

        /* =========================================================
           MENU
        ========================================================= */

        .menu-section {
            margin-top: 12px;
        }

        .menu-label {
            padding: 8px 12px;
            color: rgba(255,255,255,.52);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .sidebar-menu {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .sidebar-menu a {
            position: relative;
            display: flex;
            align-items: center;
            gap: 13px;
            min-height: 44px;
            padding: 10px 12px;
            border-radius: 11px;
            color: rgba(255,255,255,.88);
            font-size: 14px;
            font-weight: 500;
            transition:
                background .2s ease,
                color .2s ease,
                transform .2s ease;
        }

        .sidebar-menu a i {
            width: 21px;
            text-align: center;
            font-size: 15px;
            flex-shrink: 0;
        }

        .sidebar-menu a:hover {
            background: rgba(255,255,255,.12);
            color: #fff;
            transform: translateX(2px);
        }

        .sidebar-menu a.active {
            background: #fff;
            color: var(--primary);
            box-shadow: 0 7px 18px rgba(0,0,0,.12);
        }

        .sidebar-menu a.active i {
            color: var(--primary);
        }

        /* =========================================================
           USER AREA
        ========================================================= */

        .sidebar-bottom {
            margin-top: auto;
            padding-top: 16px;
        }

        .user-box {
            padding: 14px 12px;
            border-top: 1px solid rgba(255,255,255,.18);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 11px;
            margin-bottom: 13px;
        }

        .user-avatar {
            width: 44px;
            height: 44px;
            flex-shrink: 0;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255,255,255,.45);
            background: rgba(255,255,255,.12);
        }

        .user-name {
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            line-height: 1.2;
        }

        .user-role {
            margin-top: 3px;
            color: rgba(255,255,255,.7);
            font-size: 11px;
        }

        .logout-btn {
            width: 100%;
            border: 0;
            border-radius: 9px;
            padding: 9px 12px;
            font-size: 13px;
            font-weight: 600;
        }

        /* =========================================================
           MAIN CONTENT
        ========================================================= */

        .main {
            width: calc(100% - var(--sidebar-width));
            min-width: 0;
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        /* =========================================================
           TOPBAR
        ========================================================= */

        .topbar {
            height: var(--topbar-height);
            position: sticky;
            top: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 0 30px;
            background: rgba(255,255,255,.96);
            border-bottom: 1px solid var(--border);
            box-shadow: 0 2px 12px rgba(0,0,0,.04);
            backdrop-filter: blur(10px);
        }

        .topbar-left {
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .page-title {
            margin: 0;
            color: #111827;
            font-size: 20px;
            font-weight: 700;
        }

        .page-date {
            margin-top: 2px;
            color: var(--muted);
            font-size: 12px;
        }

        .mobile-menu-btn {
            width: 40px;
            height: 40px;
            display: none;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border);
            border-radius: 10px;
            background: #fff;
            color: var(--primary);
            font-size: 17px;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 8px 13px;
            border-radius: 10px;
            background: var(--primary-soft);
            color: var(--primary-dark);
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
        }

        /* =========================================================
           PAGE
        ========================================================= */

        .page {
            padding: 28px 30px;
        }

        /* =========================================================
           ALERT
        ========================================================= */

        .page-alert {
            border: 0;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,.04);
        }

        /* =========================================================
           OVERLAY
        ========================================================= */

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 1040;
            background: rgba(0,0,0,.45);
        }

        /* =========================================================
           RESPONSIVE TABLET
        ========================================================= */

        @media (max-width: 991.98px) {

            :root {
                --sidebar-width: 260px;
            }

            .sidebar {
                transform: translateX(-100%);
                box-shadow: 8px 0 30px rgba(0,0,0,.15);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .sidebar-overlay.show {
                display: block;
            }

            .main {
                width: 100%;
                margin-left: 0;
            }

            .mobile-menu-btn {
                display: flex;
            }

            .topbar {
                padding: 0 20px;
            }

            .page {
                padding: 24px 20px;
            }
        }

        /* =========================================================
           RESPONSIVE MOBILE
        ========================================================= */

        @media (max-width: 575.98px) {

            .topbar {
                height: 64px;
                padding: 0 14px;
            }

            .page-title {
                font-size: 17px;
            }

            .page-date {
                display: none;
            }

            .topbar-user {
                width: 40px;
                height: 40px;
                justify-content: center;
                padding: 0;
                border-radius: 50%;
            }

            .topbar-user span {
                display: none;
            }

            .page {
                padding: 18px 14px;
            }

            .sidebar {
                width: 280px;
                min-width: 280px;
            }
        }

        /* ==================================================
        BARCODE SISWA
        ================================================== */

        .student-barcode {
            display: inline-block;
            background: #fff;
            padding: 8px 12px;
            border-radius: 6px;
        }

        .student-barcode-image {
            display: block;
            width: 100%;
            max-width: 360px;
            height: auto;
            margin: auto;
        }

        .student-barcode-number {
            margin-top: 5px;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 2px;
        }

    </style>

    @stack('styles')

</head>

<body>

<div class="app">

    {{-- =========================================================
         SIDEBAR
    ========================================================== --}}

    <aside class="sidebar" id="sidebar">

        <div class="brand">

            <div class="brand-icon">
                <i class="fa-solid fa-school"></i>
            </div>

            <div>
                <div class="brand-title">
                    Presensi Siswa
                </div>

                <span class="brand-subtitle">
                    Sistem Presensi Sekolah
                </span>
            </div>

        </div>

        {{-- =====================================================
             MENU UTAMA
        ====================================================== --}}

        <div class="menu-section">

            <div class="menu-label">
                Utama
            </div>

            <nav class="sidebar-menu">

                <a
                    href="{{ route('dashboard') }}"
                    class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"
                >
                    <i class="fa-solid fa-house"></i>
                    <span>Dashboard</span>
                </a>

                <a
                    href="{{ route('profil') }}"
                    class="{{ request()->routeIs('profil') ? 'active' : '' }}"
                >
                    <i class="fa-solid fa-id-card"></i>
                    <span>Profil Akun</span>
                </a>

            </nav>

        </div>

        {{-- =====================================================
             DATA MASTER
        ====================================================== --}}

        @if(auth()->user()->isAdmin())

            <div class="menu-section">

                <div class="menu-label">
                    Data Master
                </div>

                <nav class="sidebar-menu">

                    <a
                        href="{{ route('siswa.index') }}"
                        class="{{ request()->routeIs('siswa.*') && !request()->routeIs('siswa.import*') ? 'active' : '' }}"
                    >
                        <i class="fa-solid fa-user-graduate"></i>
                        <span>Data Siswa</span>
                    </a>

                    <a
                        href="{{ route('guru.index') }}"
                        class="{{ request()->routeIs('guru.*') ? 'active' : '' }}"
                    >
                        <i class="fa-solid fa-chalkboard-user"></i>
                        <span>Data Guru</span>
                    </a>

                    <a
                        href="{{ route('pengurus-kelas.index') }}"
                        class="{{ request()->routeIs('pengurus-kelas.*') ? 'active' : '' }}"
                    >
                        <i class="fa-solid fa-users"></i>
                        <span>Pengurus Kelas</span>
                    </a>

                    <a
                        href="{{ route('siswa.import') }}"
                        class="{{ request()->routeIs('siswa.import*') ? 'active' : '' }}"
                    >
                        <i class="fa-solid fa-file-import"></i>
                        <span>Import Excel</span>
                    </a>

                </nav>

            </div>

        @endif

        {{-- =====================================================
             PRESENSI
        ====================================================== --}}

        @if(auth()->user()->isPetugasPresensi())

            <div class="menu-section">

                <div class="menu-label">
                    Presensi
                </div>

                <nav class="sidebar-menu">

                    <a
                        href="{{ route('presensi.create') }}"
                        class="{{ request()->routeIs('presensi.create') ? 'active' : '' }}"
                    >
                        <i class="fa-solid fa-barcode"></i>
                        <span>Scan Presensi</span>
                    </a>

                    <a
                        href="{{ route('presensi.index') }}"
                        class="{{ request()->routeIs('presensi.index') ? 'active' : '' }}"
                    >
                        <i class="fa-solid fa-calendar-check"></i>
                        <span>Data Presensi</span>
                    </a>

                </nav>

            </div>

        @endif

        {{-- =====================================================
             REKAP
        ====================================================== --}}

        @if(auth()->user()->isGuruAtauAdmin())

            <div class="menu-section">

                <div class="menu-label">
                    Laporan
                </div>

                <nav class="sidebar-menu">

                    <a
                        href="{{ route('rekap.index') }}"
                        class="{{ request()->routeIs('rekap.*') ? 'active' : '' }}"
                    >
                        <i class="fa-solid fa-chart-column"></i>
                        <span>Rekap Presensi</span>
                    </a>

                    <a
                        href="{{ route('izin.index') }}"
                        class="{{ request()->routeIs('izin.*') ? 'active' : '' }}"
                    >
                        <i class="fa-solid fa-notes-medical"></i>
                        <span>Izin / Sakit</span>
                    </a>

                </nav>

            </div>

        @endif

        {{-- =====================================================
             SISTEM
        ====================================================== --}}

        @if(auth()->user()->isAdmin())

            <div class="menu-section">

                <div class="menu-label">
                    Sistem
                </div>

                <nav class="sidebar-menu">

                    <a
                        href="{{ route('login-log.index') }}"
                        class="{{ request()->routeIs('login-log.*') ? 'active' : '' }}"
                    >
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        <span>Riwayat Login</span>
                    </a>

                    <a
                        href="{{ route('activity-log.index') }}"
                        class="{{ request()->routeIs('activity-log.*') ? 'active' : '' }}"
                    >
                        <i class="fa-solid fa-list-check"></i>
                        <span>Activity Log</span>
                    </a>

                    <a
                        href="{{ route('pengaturan.index') }}"
                        class="{{ request()->routeIs('pengaturan.*') ? 'active' : '' }}"
                    >
                        <i class="fa-solid fa-gears"></i>
                        <span>Pengaturan</span>
                    </a>

                </nav>

            </div>

        @endif

        {{-- =====================================================
             USER
        ====================================================== --}}

        <div class="sidebar-bottom">

            <div class="user-box">

                <div class="user-info">

                    <img
                        src="{{ asset('images/avatar-default.png') }}"
                        alt="Avatar"
                        class="user-avatar"
                    >

                    <div>

                        <div class="user-name">
                            {{ auth()->user()->nama }}
                        </div>

                        <div class="user-role">
                            {{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}
                        </div>

                    </div>

                </div>

                <form
                    action="{{ route('logout') }}"
                    method="POST"
                >

                    @csrf

                    <button
                        type="submit"
                        class="btn btn-light logout-btn"
                    >
                        <i class="fa-solid fa-right-from-bracket me-2"></i>
                        Logout
                    </button>

                </form>

            </div>

        </div>

    </aside>

    {{-- =========================================================
         OVERLAY MOBILE
    ========================================================== --}}

    <div
        class="sidebar-overlay"
        id="sidebarOverlay"
    ></div>

    {{-- =========================================================
         MAIN
    ========================================================== --}}

    <main class="main">

        {{-- =====================================================
             TOPBAR
        ====================================================== --}}

        <header class="topbar">

            <div class="topbar-left">

                <button
                    type="button"
                    class="mobile-menu-btn"
                    id="mobileMenuBtn"
                    aria-label="Buka menu"
                >
                    <i class="fa-solid fa-bars"></i>
                </button>

                <div>

                    <h1 class="page-title">
                        @yield('title', 'Dashboard')
                    </h1>

                    <div class="page-date">
                        {{ now()->translatedFormat('l, d F Y') }}
                    </div>

                </div>

            </div>

            <div class="topbar-user">

                <i class="fa-solid fa-user"></i>

                <span>
                    {{ auth()->user()->nama }}
                </span>

            </div>

        </header>

        {{-- =====================================================
             CONTENT
        ====================================================== --}}

        <div class="page">

            @if(session('success'))

                <div class="alert alert-success page-alert">
                    <i class="fa-solid fa-circle-check me-2"></i>
                    {{ session('success') }}
                </div>

            @endif

            @if(session('error'))

                <div class="alert alert-danger page-alert">
                    <i class="fa-solid fa-circle-exclamation me-2"></i>
                    {{ session('error') }}
                </div>

            @endif

            @if($errors->any())

                <div class="alert alert-danger page-alert">

                    <div class="fw-semibold mb-1">
                        Terjadi kesalahan:
                    </div>

                    <ul class="mb-0">

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif

            @yield('content')

        </div>

    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const menuButton = document.getElementById('mobileMenuBtn');

    function openSidebar() {

        if (!sidebar || !overlay) {
            return;
        }

        sidebar.classList.add('show');
        overlay.classList.add('show');
        document.body.style.overflow = 'hidden';

    }

    function closeSidebar() {

        if (!sidebar || !overlay) {
            return;
        }

        sidebar.classList.remove('show');
        overlay.classList.remove('show');
        document.body.style.overflow = '';

    }

    if (menuButton) {

        menuButton.addEventListener('click', function () {

            if (sidebar.classList.contains('show')) {
                closeSidebar();
            } else {
                openSidebar();
            }

        });

    }

    if (overlay) {

        overlay.addEventListener('click', function () {
            closeSidebar();
        });

    }

    document.querySelectorAll('.sidebar-menu a').forEach(function (link) {

        link.addEventListener('click', function () {

            if (window.innerWidth <= 991) {
                closeSidebar();
            }

        });

    });

    window.addEventListener('resize', function () {

        if (window.innerWidth > 991) {
            closeSidebar();
        }

    });

});

</script>

@stack('scripts')

</body>

</html>