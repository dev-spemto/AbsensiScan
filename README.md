<div align="center">

  <img src="https://img.icons8.com/isometric-folders/512/qr-code.png" alt="AbsensiScan Logo" width="120" height="120" />

  # 📲 AbsensiScan — SPEMTO v1.0
  **Web-Based QR Code Attendance & Permission Management System**
  
  *Sistem Presensi Online Siswa & Manajemen Perizinan Berbasis QR Code dari Kartu Pelajar untuk SMP Muhammadiyah Tonjong*

  [![Laravel Version](https://img.shields.io/badge/Laravel-v11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
  [![PHP Version](https://img.shields.io/badge/PHP-%3E%3D%208.2-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
  [![Bootstrap](https://img.shields.io/badge/Bootstrap-5.x-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)](https://getbootstrap.com)
  [![MySQL Engine](https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
  [![License](https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge)](LICENSE)

  [Fitur Utama](#-fitur-unggulan) • [Arsitektur System](#-arsitektur--alur-sistem) • [Panduan Instalasi](#-panduan-instalasi) • [Struktur Direktori](#-struktur-direktori-utama) • [Tim Pengembang](#-tim-pengembang--kontak)

</div>

---

## 📌 Tentang Project

**AbsensiScan SPEMTO v1.0** adalah sistem manajemen presensi digital dan pengajuan perizinan siswa yang terintegrasi secara otomatis menggunakan **Scanner QR Code Kartu Pelajar**. Aplikasi ini dikembangkan khusus untuk menyederhanakan operasional kehadiran, rekapitulasi data harian, serta pemantauan perizinan di **SMP Muhammadiyah Tonjong, Kabupaten Brebes**.

Aplikasi ini menggunakan backend tangguh **Laravel 11**, database relasional **MySQL**, serta otentikasi multi-role aman berbasis **Sanctum API Tokens** & **Custom Access Control**.

---

## 🔥 Fitur Unggulan

| Emoji | Fitur Utama | Deskripsi Detail |
| :---: | :--- | :--- |
| 🏷️ | **Scan QR Code Kartu Pelajar** | Pemindaian kehadiran super cepat menggunakan QR Scanner/Barcode Scanner pada kartu pelajar siswa dengan pencatatan `jam_scan` dan `tanggal` otomatis. |
| 👥 | **Master Data Terstruktur** | Pengelolaan data lengkap `Siswa`, `Guru`, `Kelas` (7A–9C), serta pendaftaran aktif `Tahun Ajaran` (2026/2027). |
| 🔑 | **Multi-Role Access Control** | Pembagian hak akses khusus untuk **Administrator/Petugas**, **Guru / Wali Kelas**, serta **Siswa / Pengurus Kelas**. |
| 📝 | **Manajemen Izin & Sakit** | Pengajuan dan persetujuan (approval) surat izin/sakit siswa secara terpusat dengan dukungan lampiran dokumen bukti. |
| 🛡️ | **Integritas Relasi Wali & Pengurus** | Pemetaan otomatis antara Ketua Kelas/Pengurus Kelas ke daftar `Siswa` dan Wali Kelas ke tabel `User`. |
| 📜 | **Activity & Login Logging** | Pencatatan otomatis setiap aksi pengguna (*Activity Logs*) dan histori masuk akun (*Login Logs*) untuk keamanan data. |
| 🧹 | **Optimized Caching & Symlink** | Mendukung pemuatan gambar bukti izin/foto via `storage:link` dan siap di-deploy ke server produksi secara cepat. |

---

## 🏗️ Arsitektur & Alur Sistem

```text
ALUR PROSES PRESENSI & IZIN:

[Scanner QR Code / User Device] 
       │
       ▼ (Kirim NISN / Code)
[Laravel Backend Engine]
       │
       ▼
{Autentikasi & Validasi}
       ├──────► (Valid QR Scan) ──► [Record Presensi: jam_scan & tanggal] ──┐
       │                                                                    │
       └──────► (Form Pengajuan) ──► [Record Izin/Sakit: Pending] ──────────┼──► [(MySQL Database)] ──► [Dashboard Rekapitulasi]
                                                                            │
```

---

## 🛠️ Tech Stack & Modul

* **Core Engine:** PHP 8.2+ & Laravel Framework 11.x
* **Database:** MySQL 8.0+
* **Authentication:** Laravel Sanctum / Token-Based API
* **Frontend UI:** Bootstrap 5, AdminLTE, OverlayScrollbars
* **Helpers:** QrCode Helper Engine & Activity Logger

---

## 🚀 Panduan Instalasi

### Requirement Environment
* PHP >= 8.2
* MySQL / MariaDB Server
* Composer >= 2.x
* Web Server (Nginx / Apache / XAMPP)

### Langkah Instalasi (Local Development)

1. **Clone Repository**
   ```bash
   git clone https://github.com/dev-spemto/AbsensiScan.git
   cd AbsensiScan/server
   ```

2. **Install Dependency Composer**
   ```bash
   composer install
   ```

3. **Konfigurasi File Environment**
   Salin file `.env.example` menjadi `.env`, lalu sesuaikan konfigurasi database Anda:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

   *Atur kredensial database pada file `.env`:*
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=presensi_siswa
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Jalankan Migrasi Database & Seeder**
   ```bash
   php artisan migrate --seed
   ```

5. **Hubungkan Symlink Storage**
   *(Wajib untuk direktori foto & file bukti izin)*
   ```bash
   php artisan storage:link
   ```

6. **Jalankan Server Lokal**
   ```bash
   php artisan serve
   ```
   Akses dashboard melalui browser di: `http://127.0.0.1:8000`

---

## 📂 Struktur Direktori Utama

```text
AbsensiScan/server/
├── app/
│   ├── Helpers/
│   │   └── QrCodeHelper.php         # Engine Helper Pembuat/Pembaca QR Code
│   ├── Http/Controllers/           # Controller Presensi, Izin, Siswa, & Auth
│   └── Models/                     # Eloquent Models (Siswa, Presensi, Izin, dll)
├── database/
│   └── migrations/                  # 19 File Migrasi Database
├── public/
│   ├── storage/                     # Symlink Direktori Penyimpanan Berkas
│   └── vendor/                      # Asset Frontend (AdminLTE, OverlayScrollbars)
├── resources/
│   └── views/                       # Blade Views Tampilan Application UI
├── routes/
│   ├── api.php                      # Endpoint API Scanner & Mobile
│   └── web.php                      # Routing Dashboard & Auth Session
└── README.md                        # Dokumentasi Resmi Project
```

---

## ⚙️ Persiapan Deployment Produksi

Jika hendak merilis aplikasi ke server produksi (*production VPS/Hosting*), jalankan perintah optimasi berikut:

```bash
# Set .env: APP_ENV=production & APP_DEBUG=false

php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

---

## 📞 Tim Pengembang & Kontak

Sistem ini dikembangkan dan dikelola secara penuh oleh **Tim IT / Dev SPEMTO**:

* 🏫 **Lembaga:** SMP Muhammadiyah Tonjong (SPEMTO)
* 📍 **Alamat:** Jl. Raya Linggapura No.46, Kecamatan Tonjong, Kabupaten Brebes, Jawa Tengah
* 🌐 **Website Resmi:** [https://smpmuhtonjong.sch.id](https://smpmuhtonjong.sch.id)
* 🐙 **GitHub Organization:** [@dev-spemto](https://github.com/dev-spemto)

---

<div align="center">

  **© 2026 Tim IT SMP Muhammadiyah Tonjong. All Rights Reserved.**  
  *Dedicated to Digitalizing School Attendance & Operational Excellence.*

</div>