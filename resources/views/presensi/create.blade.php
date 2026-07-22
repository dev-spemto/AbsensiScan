@extends('layouts.app')

@push('styles')

<style>

#hasilScan{

    transition:.35s;

}

.scan-success{

    animation:scanSuccess .45s ease;

}

@keyframes scanSuccess{

    0%{

        transform:scale(.92);

        opacity:.4;

    }

    60%{

        transform:scale(1.03);

    }

    100%{

        transform:scale(1);

        opacity:1;

    }

}

</style>

@endpush

@section('title','Scan Presensi')

@section('content')

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

            <div class="text-center">

                <img id="fotoSiswa"
                     src="https://ui-avatars.com/api/?name=Siswa&size=220"
                     class="img-fluid rounded shadow-sm mb-3"
                     style="max-height:220px;object-fit:cover;">

                <h4 id="namaSiswa" class="fw-bold">

                    -

                </h4>

                <div class="text-muted mb-2">

                    <span id="kelasSiswa">

                        -

                    </span>

                </div>

                <span id="statusSiswa"
                      class="badge bg-secondary fs-6">

                    Menunggu Scan

                </span>

                <div class="mt-3">

                    <strong id="jamScan">

                        --

:--

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

                        </tr>

                    </thead>

                    <tbody id="tbodyRiwayat">

                        @forelse($riwayat as $item)

                        <tr>

                            <td>{{ substr($item->jam_scan,0,5) }}</td>

                            <td>{{ $item->siswa->nama }}</td>

                            <td>{{ $item->siswa->kelas->nama_lengkap }}</td>

                            <td>

                                @php

                                    $warna = [
                                        'Hadir'=>'success',
                                        'Terlambat'=>'warning',
                                        'Izin'=>'primary',
                                        'Sakit'=>'info',
                                        'Alpha'=>'danger',
                                    ];

                                @endphp

                                <span class="badge bg-{{ $warna[$item->status] ?? 'secondary' }}">

                                    {{ $item->status }}

                                </span>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="4"
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

let scanTimeout = null;

let sedangScan = false;

const audioSuccess = new Audio('/sounds/success.mp3');

const audioError = new Audio('/sounds/error.mp3');

barcode.focus();

function scanBarcode(){

    if(sedangScan){

    return;

}

sedangScan = true;

    if(barcode.value.trim()===''){

        sedangScan = false;

        barcode.focus();

        return;

    }

    fetch("{{ route('presensi.scan') }}",{

        method:'POST',

        headers:{

            'Content-Type':'application/json',

            'Accept':'application/json',

            'X-CSRF-TOKEN':document
                .querySelector('meta[name=csrf-token]')
                .content

        },

        body:JSON.stringify({

            barcode:barcode.value

        })

    })

    .then(res=>res.json())

    .then(res=>{

        if(res.success){

            tampilkanData(res);

            sedangScan = false;

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

    sedangScan = false;

}
    })

.catch((error)=>{

    sedangScan = false;

    Swal.fire({

        icon:'error',

        title:'Server Error',

        text:'Terjadi kesalahan pada server.'

    });

    barcode.value='';

    barcode.focus();

    console.error(error);

});

}

barcode.addEventListener('input',function(){

    clearTimeout(scanTimeout);

    scanTimeout = setTimeout(function(){

        if(barcode.value.trim()!==''){

            scanBarcode();

        }

    },150);

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
            warna = 'info';
            break;

        case 'Alpha':
            warna = 'danger';
            break;

    }

    status.className = 'badge fs-6 bg-'+warna;

    status.innerHTML = data.status;
    
    audioSuccess.currentTime = 0;
    
    audioSuccess.play();
    
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

                <span class="badge bg-${warna}">

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