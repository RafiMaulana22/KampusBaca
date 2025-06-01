@extends('layouts.template-admin')

@section('breadcrumb')
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-home"></i>
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('mahasiswa.index') }}">Mahasiswa</a>
        </li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
@endsection

@section('content')
    <div class="col-sm-12">
        {{-- Alert untuk Pesan Error Umum (dari redirect with 'error') --}}
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                <h5>Form {{ $title }}</h5>
                <small>
                    Silahkan isi form berikut untuk menambahkan {{ $title }} baru
                </small>
            </div>
            <div class="card-body">
                <form action="{{ route('mahasiswa.store') }}" method="POST" novalidate>
                    @csrf
                    <div class="row g-3">
                        <div class="col-12 mb-3">
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
                        <div class="col-6 mb-3">
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
                        <div class="col-6 mb-3">
                            <div class="form-group">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" id="password" value="{{ old('password') }}" required>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="form-group">
                                <label for="nim" class="form-label">NIM (Nomor Induk Mahasiswa)</label>
                                <input type="text" class="form-control @error('nim') is-invalid @enderror" name="nim"
                                    id="nim" value="{{ old('nim') }}" required>
                                @error('nim')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="form-group">
                                <label for="jurusan_id" class="form-label">Jurusan</label>
                                <select class="form-select @error('jurusan_id') is-invalid @enderror" name="jurusan_id"
                                    id="jurusan_id" required>
                                    <option value="" selected disabled>-- Pilih Jurusan --</option>
                                    @foreach ($jurusans as $jurusan)
                                        <option value="{{ $jurusan->id }}"
                                            {{ old('jurusan_id') == $jurusan->id ? 'selected' : '' }}>
                                            {{ $jurusan->nama_jurusan }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('jurusan_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label for="angkatan" class="form-label">Angkatan</label>
                                <input type="number" class="form-control @error('angkatan') is-invalid @enderror"
                                    name="angkatan" id="angkatan" value="{{ old('angkatan') }}" required>
                                <small class="form-text text-muted">Masukkan tahun angkatan, misalnya 2023</small>
                                @error('angkatan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                                <button type="reset" class="btn btn-warning me-2">Reset</button>
                                <a href="{{ route('mahasiswa.index') }}" class="btn btn-danger">Kembali</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
