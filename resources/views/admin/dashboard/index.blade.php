@extends('layouts.template-admin')

@section('breadcrumb')
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item active">
            <i class="fa fa-home"></i>
            {{--  <a href="#">
                <i class="fa fa-home"></i>
            </a>  --}}
        </li>
        {{--  <li class="breadcrumb-item">Dashboard</li>
        <li class="breadcrumb-item active">Default</li>  --}}
    </ol>
@endsection

@section('content')
    {{-- Baris Kartu Statistik Utama --}}
    <div class="row">
        {{-- Statistik Koleksi Buku --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                <b>Total Buku</b>
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalBuku ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-book-half fs-2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Statistik Pengguna --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                <b>Total Pengguna</b>
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPengguna ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-people-fill fs-2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Statistik Peminjaman Aktif --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Peminjaman Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $peminjamanAktif ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-arrow-repeat fs-2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Statistik Peminjaman Terlambat --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Terlambat Kembali</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $peminjamanTerlambat ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-exclamation-triangle-fill fs-2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Baris Grafik dan Buku Terpopuler --}}
    <div class="row">
        {{-- Grafik Tren Peminjaman --}}
        <div class="col-lg-8 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Tren Peminjaman</h6>
                    {{-- Opsi filter grafik bisa ditambahkan di sini --}}
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        {{-- Elemen canvas untuk Chart.js atau library grafik lainnya --}}
                        <canvas id="loanTrendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
