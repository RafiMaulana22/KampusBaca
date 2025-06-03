@extends('layouts.template-admin')

@section('breadcrumb')
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-home"></i>
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('staff.index') }}">Staff</a>
        </li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
@endsection

@section('content')
    <div class="col-sm-12">
        {{-- Alert untuk Deskripsi/Petunjuk Form --}}
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong class="me-1">Petunjuk Pengisian:</strong>
            Harap lengkapi semua field di bawah ini dengan data yang valid untuk menambahkan {{ strtolower($title) }} baru.
            Pastikan NIP dan Email yang Anda masukkan belum pernah terdaftar sebelumnya.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Form {{ $title }}</h5> {{-- $title akan diisi "Staff" atau "Tambah Staff" dari controller --}}
                <small>
                    Silahkan isi form berikut untuk menambahkan {{ strtolower($title) }} baru
                </small>
            </div>
            <div class="card-body">
                {{-- Alert untuk Pesan Error Umum (dari redirect with 'error') --}}
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <form action="{{ route('staff.store') }}" method="POST" novalidate> {{-- Ubah route ke staff.store --}}
                    @csrf
                    <div class="row g-3">
                        {{-- Nama Lengkap --}}
                        <div class="col-6 mb-3">
                            <div class="form-group">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" id="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- NIP --}}
                        <div class="col-md-6 mb-3"> {{-- Bisa juga col-12 jika ingin NIP full width --}}
                            <div class="form-group">
                                <label for="nip" class="form-label">NIP (Nomor Induk Pegawai)</label>
                                <input type="text" class="form-control @error('nip') is-invalid @enderror" name="nip"
                                    id="nip" value="{{ old('nip') }}" required>
                                @error('nip')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" id="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Password --}}
                        <div class="col-6 mb-3"> {{-- Atau col-md-6 jika ingin layout yang berbeda --}}
                            <div class="form-group">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" id="password" required> {{-- Sebaiknya value="{{ old('password') }}" tidak digunakan untuk password --}}
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="col-12 mb-3">
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                                <button type="reset" class="btn btn-warning me-2">Reset</button>
                                <a href="{{ route('staff.index') }}" class="btn btn-danger">Kembali</a>
                                {{-- Ubah route ke staff.index --}}
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
