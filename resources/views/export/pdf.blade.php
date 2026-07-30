<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Rekap Presensi</title>

<style>

body{
    font-family: DejaVu Sans, sans-serif;
    font-size:11px;
}

h2{
    text-align:center;
    margin-bottom:5px;
}

p{
    text-align:center;
    margin-top:0;
    margin-bottom:20px;
}

table{
    width:100%;
    border-collapse:collapse;
}

table th,
table td{
    border:1px solid #000;
    padding:5px;
    font-size:10px;
}

table th{
    background:#e9ecef;
    text-align:center;
}

.text-center{
    text-align:center;
}

</style>

</head>

<body>

<h2>

REKAP PRESENSI SISWA

</h2>

<p>

SMP Muhammadiyah Tonjong

</p>

<table>

<thead>

<tr>

<th>No</th>

<th>Tanggal</th>

<th>Jam</th>

<th>Nama</th>

<th>Kelas</th>

<th>Status</th>

<th>Petugas Scan</th>

<th>Role</th>

<th>Guru</th>

<th>Metode</th>

</tr>

</thead>

<tbody>

@php

$no = 1;

$role = [

    'admin' => 'Admin',

    'guru' => 'Guru',

    'ketua_kelas' => 'Ketua Kelas',

    'sekretaris' => 'Sekretaris',

];

@endphp

@forelse($presensis as $presensi)

<tr>

<td class="text-center">

{{ $no++ }}

</td>

<td>

{{ \Carbon\Carbon::parse($presensi->tanggal)->format('d-m-Y') }}

</td>

<td>

{{ substr($presensi->jam_scan,0,5) }}

</td>

<td>

{{ optional($presensi->siswa)->nama ?? '-' }}

</td>

<td>

{{ optional(optional($presensi->siswa)->kelas)->nama_lengkap ?? '-' }}

</td>

<td class="text-center">

{{ $presensi->status }}

</td>

<td>

{{ optional($presensi->scanner)->nama ?? '-' }}

</td>

<td>

{{ $role[$presensi->scan_by] ?? '-' }}

</td>

<td>

{{ optional($presensi->guru)->nama ?? '-' }}

</td>

<td>

{{ $presensi->metode }}

</td>

</tr>

@empty

<tr>

<td colspan="10" class="text-center">

Tidak ada data.

</td>

</tr>

@endforelse

</tbody>

</table>

</body>

</html>