<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Print Rekap Presensi</title>

<style>

body{
    font-family:Arial, Helvetica, sans-serif;
    font-size:12px;
    color:#000;
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
    background:#f1f1f1;
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

$role = [

    'admin' => 'Admin',

    'guru' => 'Guru',

    'ketua_kelas' => 'Ketua Kelas',

    'sekretaris' => 'Sekretaris',

];

@endphp

@forelse($presensis as $index => $presensi)

<tr>

<td class="text-center">

{{ $index + 1 }}

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

<script>

window.onload = function(){

    window.print();

}

</script>

</body>

</html>