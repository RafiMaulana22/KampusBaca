@extends('layouts.template-auth')

@section('content')
    <h3 class="text-center">REGISTER</h3>
    <h6 class="text-center">Enter your Username and Password For Login or Signup</h6>
    <div class="card mt-4 p-4">
        <form class="theme-form" action="{{ route('register') }}" method="POST" novalidate>
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="col-form-label">Nama Lengkap</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name') }}" placeholder="Masukkan nama lengkap Anda">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="col-form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" placeholder="Masukkan email Anda">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="col-form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                            value="{{ old('password') }}" placeholder="Masukkan password Anda">
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="col-form-label">NIM (Nomor Induk Mahasiswa)</label>
                        <input type="text" class="form-control @error('nim') is-invalid @enderror" name="nim"
                            value="{{ old('nim') }}" placeholder="Masukkan NIM Anda">
                        @error('nim')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="col-form-label">Jurusan</label>
                        <select class="form-select mb-1 @error('jurusan_id') is-invalid @enderror" name="jurusan_id">
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
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="col-form-label">Angkatan</label>
                        <input type="number" class="form-control @error('angkatan') is-invalid @enderror" name="angkatan"
                            value="{{ old('angkatan') }}" placeholder="Masukkan tahun angkatan Anda">
                        <small class="form-text text-muted">Masukkan tahun angkatan, misalnya 2023</small>
                        @error('angkatan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row g-2 mt-2">
                <div class="col-lg-3 col-md-4">
                    <button type="submit" class="btn btn-secondary btn-sm">Register</button>
                </div>
                <div class="col-md-8">
                    <div class="text-start mt-2 m-l-20">
                        Are you already user?&nbsp;&nbsp;
                        <a href="{{ route('login') }}" class="btn-link text-capitalize">Login</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
