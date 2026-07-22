<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Rekap Presensi</title>

<style>

body{
    font-family: DejaVu Sans, sans-serif;
    font-size:12px;
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
    padding:6px;
    font-size:11px;
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

<th>Nama Siswa</th>

<th>Kelas</th>

<th>Guru</th>

<th>Status</th>

</tr>

</thead>

<tbody>

@php

$no=1;

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

{{ $presensi->siswa->nama }}

</td>

<td>

{{ $presensi->siswa->kelas->nama_lengkap }}

</td>

<td>

{{ $presensi->guru->nama }}

</td>

<td class="text-center">

{{ $presensi->status }}

</td>

</tr>

@empty

<tr>

<td colspan="7" class="text-center">

Tidak ada data.

</td>

</tr>

@endforelse

</tbody>

</table>

</body>

</html>