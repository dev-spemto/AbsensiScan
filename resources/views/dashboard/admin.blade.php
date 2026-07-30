@extends('adminlte::page')

@section('title', 'Dashboard Admin')


@section('content_header')

    <h1>
        Dashboard Administrator
    </h1>

@endsection



@section('content')


<div class="row">


    <div class="col-lg-3 col-6">

        <div class="small-box bg-info">

            <div class="inner">

                <h3>{{ $totalSiswa }}</h3>

                <p>Total Siswa</p>

            </div>

        </div>

    </div>



    <div class="col-lg-3 col-6">

        <div class="small-box bg-success">

            <div class="inner">

                <h3>{{ $totalGuru }}</h3>

                <p>Total Guru</p>

            </div>

        </div>

    </div>



    <div class="col-lg-3 col-6">

        <div class="small-box bg-warning">

            <div class="inner">

                <h3>{{ $totalKelas }}</h3>

                <p>Total Kelas</p>

            </div>

        </div>

    </div>



    <div class="col-lg-3 col-6">

        <div class="small-box bg-danger">

            <div class="inner">

                <h3>{{ $presensiHariIni }}</h3>

                <p>Presensi Hari Ini</p>

            </div>

        </div>

    </div>


</div>



<div class="card">

    <div class="card-header">

        <h3 class="card-title">
            Presensi Terbaru
        </h3>

    </div>


    <div class="card-body">


        <table class="table table-bordered">

            <thead>

                <tr>

                    <th>Siswa</th>

                    <th>Kelas</th>

                    <th>Guru</th>

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
                        {{ $item->guru->nama ?? '-' }}
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