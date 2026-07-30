@extends('adminlte::page')

@section('title', 'Dashboard Guru')


@section('content_header')

<h1>
    Dashboard Guru
</h1>

@endsection



@section('content')


<div class="card">

    <div class="card-body">


        <h3>
            Selamat datang,
            {{ $guru->nama }}
        </h3>


        <hr>


        <p>
            NIP:
            {{ $guru->nip }}
        </p>


        <p>
            Presensi hari ini:
            {{ $presensiHariIni }}
        </p>


    </div>

</div>



<div class="card">


    <div class="card-header">

        Riwayat Presensi Terakhir

    </div>


    <div class="card-body">


        <table class="table table-bordered">


            <thead>

                <tr>

                    <th>Siswa</th>

                    <th>Kelas</th>

                    <th>Status</th>

                </tr>

            </thead>



            <tbody>


            @foreach($presensiTerbaru as $item)


                <tr>

                    <td>
                        {{ $item->siswa->nama ?? '-' }}
                    </td>


                    <td>
                        {{ $item->siswa->kelas->nama ?? '-' }}
                    </td>


                    <td>
                        {{ $item->status }}
                    </td>


                </tr>


            @endforeach


            </tbody>


        </table>


    </div>


</div>


@endsection