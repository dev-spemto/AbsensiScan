@extends('layouts.app')

@push('styles')

<style>

#hasilScan{
    transition:.4s;
    border-radius:18px;
    overflow:hidden;
}

.scan-success{
    animation:scanSuccess .55s ease;
}

@keyframes scanSuccess{

    0%{
        transform:scale(.95);
        opacity:.5;
    }

    50%{
        transform:scale(1.03);
    }

    100%{
        transform:scale(1);
        opacity:1;
    }

}

.bg-purple {
    background-color: #6f42c1 !important;
    color: white !important;
}

#fotoSiswa{
    width:220px;
    height:220px;
    object-fit:cover;
    border-radius:18px;
    transition:.35s;
    border:5px solid #e9ecef;
    box-shadow:0 10px 25px rgba(0,0,0,.12);
}

.scan-success #fotoSiswa{
    transform:scale(1.05);
    border-color:#198754;
}

#namaSiswa{
    font-size:28px;
    font-weight:700;
    letter-spacing:.5px;
}

#kelasSiswa{
    font-size:18px;
}

#jamScan{
    font-size:32px;
    font-weight:bold;
    color:#198754;
}

</style>

@endpush

@section('title','Scan Presensi')

@section('content')

<div class="card border-0 shadow-sm mb-4">

    <div class="card-body">

        <div class="row align-items-center">

            <div class="col-md-2 text-center">

                @if($pengaturan && $pengaturan->logo)

                    <img
                        src="{{ asset('storage/'.$pengaturan->logo) }}"
                        width="90">

                @endif

            </div>

            <div class="col-md-10">

                <h3 class="mb-1">

                    {{ $pengaturan->nama_sekolah ?? 'Nama Sekolah' }}

                </h3>

                <div>

                    Tahun Ajaran :
                    <strong>

                        {{ $tahunAjaran->nama ?? '-' }}

                    </strong>

                </div>

                <div>

                    Jam Scan

                    {{ $pengaturan->scan_mulai }}

                    -

                    {{ $pengaturan->scan_selesai }}

                </div>

            </div>

        </div>

    </div>

</div>

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="fw-bold mb-1">

            <i class="fa-solid fa-barcode text-success"></i>

            Scan Presensi

        </h3>

        <small class="text-muted">

            Scan barcode kartu siswa untuk melakukan presensi.

        </small>

    </div>

    <a href="{{ route('presensi.index') }}"
       class="btn btn-outline-success">

        <i class="fa-solid fa-arrow-left"></i>

        Kembali

    </a>

</div>

<div class="row">

    <div class="col-lg-4">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-success text-white">

                <i class="fa-solid fa-barcode"></i>

                Scanner

            </div>

            <div class="card-body">

                <label class="form-label">

                    Scan Barcode / NISN

                </label>

                <input
                    type="text"
                    id="barcode"
                    class="form-control form-control-lg text-center"
                    autocomplete="off"
                    autofocus
                    placeholder="Tempel barcode di sini">

                <div class="mt-3 text-center">
                    
                    <small class="text-muted">
                        
                        Scanner siap digunakan...
                
                    </small>
                
                </div>

            </div>

        </div>

                    <hr>

            <div id="hasilScan" class="text-center bg-white rounded-4 p-4 shadow-sm">

                <img id="fotoSiswa"
                    src="https://ui-avatars.com/api/?name=Siswa&size=220"
                    alt="Foto Siswa">

                <h3 id="namaSiswa" class="mt-4 mb-1">

                    Menunggu Scan...

                </h3>

                <div id="kelasSiswa" class="text-secondary mb-3">

                    -

                </div>

                <span id="statusSiswa"
                    class="badge bg-secondary px-4 py-2 fs-6">

                    SIAP SCAN

                </span>

                <div class="mt-4">

                    <strong id="jamScan">

                        --:--

                    </strong>

                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-8">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-success text-white d-flex justify-content-between">

                <span>

                    <i class="fa-solid fa-clock-rotate-left"></i>

                    Riwayat Scan Hari Ini

                </span>

                <span>

                    {{ now()->translatedFormat('d F Y') }}

                </span>

            </div>

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th>Jam</th>

                            <th>Nama</th>

                            <th>Kelas</th>

                            <th>Status</th>

                            <th>Scan Oleh</th>

                        </tr>

                    </thead>

                    <tbody id="tbodyRiwayat">

                        @forelse($riwayat as $item)

                        <tr>

                            <td>

                                {{ substr($item->jam_scan,0,5) }}

                            </td>

                            <td>

                                <img
                                    src="{{ $item->siswa->foto
                                        ? asset('storage/'.$item->siswa->foto)
                                        : 'https://ui-avatars.com/api/?name='.urlencode($item->siswa->nama) }}"
                                    width="45"
                                    height="45"
                                    class="rounded-circle border">

                            </td>

                            <td>

                                <strong>

                                    {{ $item->siswa->nama }}

                                </strong>

                            </td>

                            <td>

                                {{ $item->siswa->kelas->nama_lengkap }}

                            </td>

                            <td>

                                @php

                                    $warna = [

                                        'Hadir'=>'success',

                                        'Terlambat'=>'warning',

                                        'Izin'=>'primary',

                                        'Sakit'=>'purple',

                                        'Alpha'=>'danger',

                                    ];

                                @endphp

                                <span class="badge bg-{{ $warna[$item->status] ?? 'secondary' }}">

                                    {{ $item->status }}

                                </span>

                            </td>

                            <td>

                                @php

                                    $roleColor = [

                                        'admin' => 'danger',

                                        'guru' => 'success',

                                        'ketua_kelas' => 'primary',

                                        'sekretaris' => 'purple',

                                    ];

                                @endphp

                                <div>

                                    <strong>

                                        {{ optional($item->scanner)->nama ?? '-' }}

                                    </strong>

                                    <br>

                                    <span class="badge bg-{{ $roleColor[$item->scan_by] ?? 'secondary' }}">

                                        {{ ucwords(str_replace('_',' ',$item->scan_by)) }}

                                    </span>

                                </div>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="6"
                                class="text-center text-muted py-5">

                                Belum ada presensi hari ini.

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@push('scripts')

<script>

const barcode = document.getElementById('barcode');

const foto = document.getElementById('fotoSiswa');

const nama = document.getElementById('namaSiswa');

const kelas = document.getElementById('kelasSiswa');

const status = document.getElementById('statusSiswa');

const jam = document.getElementById('jamScan');

const hasil = document.getElementById('hasilScan');

let sedangScan = false;

const audioSuccess = new Audio('/sounds/success.mp3');

const audioError = new Audio('/sounds/error.mp3');

barcode.focus();

async function scanBarcode(){

    if(sedangScan){
        return;
    }

    sedangScan = true;

    if(barcode.value.trim()===''){
        sedangScan = false;
        barcode.focus();
        return;
    }

    try{

        const response = await fetch("{{ route('presensi.scan') }}",{

            method:'POST',

            headers:{
                'Content-Type':'application/json',
                'Accept':'application/json',
                'X-CSRF-TOKEN':document
                    .querySelector('meta[name=csrf-token]')
                    .content
            },

            body:JSON.stringify({
                barcode:barcode.value.trim()
            })

        });

        const res = await response.json();

        if(res.success){

            tampilkanData(res);

        }else{

            audioError.currentTime = 0;
            audioError.play();

            Swal.fire({
                icon:'warning',
                title:'Perhatian',
                text:res.message,
                timer:1800,
                showConfirmButton:false
            });

            barcode.value='';
            barcode.focus();

        }

    }catch(error){

        console.error(error);

        Swal.fire({
            icon:'error',
            title:'Server Error',
            text:'Terjadi kesalahan pada server.'
        });

    }

    sedangScan = false;

}

barcode.addEventListener('keydown', function(e){

    if(e.key === 'Enter'){

        e.preventDefault();

        if(barcode.value.trim() !== ''){

            scanBarcode();

        }

    }

});

function tampilkanData(data){

    foto.src = data.foto;

    nama.innerHTML = data.nama;

    kelas.innerHTML = data.kelas;

    jam.innerHTML = data.jam.substring(0,5);

    let warna = 'secondary';

    switch(data.status){
        
        case 'Hadir':
            warna = 'success';
            break;

        case 'Terlambat':
            warna = 'warning';
            break;

        case 'Izin':
            warna = 'primary';
            break;

        case 'Sakit':
            warna = '#6f42c1';
            break;

        case 'Alpha':
            warna = 'danger';
            break;

    }

    status.className = 'badge px-4 py-2 fs-6';

    status.style.backgroundColor = warna;

    status.style.color = 'white';

    status.innerHTML = data.status;

    const hasil = document.getElementById('hasilScan');

    console.log(data.status);

    hasil.className = 'text-center rounded-4 p-4 shadow';

    switch(data.status){

    case 'Hadir':

        hasil.classList.add('bg-success','text-white');

        break;

    case 'Terlambat':

        hasil.classList.add('bg-warning');

        break;

    case 'Izin':

        hasil.classList.add('bg-primary','text-white');

        break;

    case 'Sakit':

        hasil.style.backgroundColor = '#6f42c1';

        hasil.style.color = 'white';

        break;

    case 'Alpha':

        hasil.classList.add('bg-danger','text-white');

        break;

    default:

        hasil.classList.add('bg-white');

    }

    audioSuccess.currentTime = 0;
    
    audioSuccess.play();
    
    hasil.classList.remove('scan-success');
    
    void hasil.offsetWidth;
    
    hasil.classList.add('scan-success');
    
    Swal.fire({
    icon:'success',
    title:'Presensi Berhasil',
    html:`
        <strong>${data.nama}</strong><br>
        ${data.kelas}<br><br>
        Status : <b>${data.status}</b>
    `,
    timer:1800,
    showConfirmButton:false
    });

    let tbody = document.getElementById('tbodyRiwayat');

    if(tbody.children.length===1 &&
       tbody.children[0].children.length===1){

        tbody.innerHTML='';

    }

    tbody.insertAdjacentHTML('afterbegin',`

        <tr>

            <td>${data.jam.substring(0,5)}</td>

            <td>${data.nama}</td>

            <td>${data.kelas}</td>

            <td>

                <span class="badge" style="background-color:${warna}; color:white;">

                    ${data.status}

                </span>

            </td>

        </tr>

    `);

    barcode.value='';

    barcode.focus();

}

window.onload = function(){

    barcode.focus();

};

document.addEventListener('click',function(){

    barcode.focus();

});

setInterval(function(){

    if(document.activeElement!==barcode){

        barcode.focus();

    }

},1000);

</script>

@endpush

@endsection