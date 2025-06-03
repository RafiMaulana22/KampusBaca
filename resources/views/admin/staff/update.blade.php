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
        {{-- Alert untuk Deskripsi/Petunjuk Form (jika diperlukan untuk edit) --}}
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong class="me-1">Petunjuk Perubahan:</strong>
            Ubah field yang diperlukan. Untuk mengubah password, isi field password. Jika field password
            dikosongkan, password lama tidak akan berubah.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <div class="card">
            <div class="card-header">
                <h5>Form {{ $title }}</h5>
                <small>
                    Silahkan ubah data pada form berikut untuk memperbarui {{ strtolower($title) }}
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

                {{-- Pastikan $staff sudah di-pass ke view dan tidak null --}}
                @if (isset($staff))
                    <form action="{{ route('staff.update', $staff->id) }}" method="POST" novalidate>
                        @csrf

                        <div class="row g-3">
                            {{-- Nama Lengkap --}}
                            <div class="col-6 mb-3">
                                <div class="form-group">
                                    <label for="name" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" id="name" value="{{ old('name', $staff->user->name ?? '') }}"
                                        required>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            {{-- NIP --}}
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="nip" class="form-label">NIP (Nomor Induk Pegawai)</label>
                                    <input type="text" class="form-control @error('nip') is-invalid @enderror"
                                        name="nip" id="nip" value="{{ old('nip', $staff->nip ?? '') }}" required>
                                    @error('nip')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" id="email"
                                        value="{{ old('email', $staff->users->email ?? '') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Password --}}
                            <div class="col-4 mb-3">
                                <div class="form-group">
                                    <label for="password" class="form-label">Password Baru (Opsional)</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        name="password" id="password"
                                        value="{{ old('password', $staff->users->dummy_password ?? '') }}">
                                    {{-- 'required' dihapus, value tidak diisi --}}
                                    <small class="form-text text-muted">
                                        Kosongkan jika tidak ingin mengubah password.
                                    </small>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-4 mb-3">
                                <div class="form-group">
                                    <label for="status_akun" class="form-label">Status Akun</label>
                                    <select class="form-select @error('status_akun') is-invalid @enderror"
                                        name="status_akun" id="status_akun" required>
                                        <option value="" selected disabled>-- Pilih Status Akun --</option>
                                        <option value="Aktif"
                                            {{ $staff->users->status_akun == 'Aktif' ? 'selected' : '' }}>
                                            Aktif
                                        </option>
                                        <option value="Tidak Aktif"
                                            {{ $staff->users->status_akun == 'Tidak Aktif' ? 'selected' : '' }}>
                                            Tidak Aktif
                                        </option>
                                    </select>
                                    @error('status_akun')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="col-12 mb-3">
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-2">Simpan Perubahan</button>
                                    <button type="reset" class="btn btn-warning me-2">Reset Form</button>
                                    {{-- Reset hanya akan mereset ke nilai awal (dari $staff) jika JS tidak dimodifikasi --}}
                                    <a href="{{ route('staff.index') }}" class="btn btn-secondary">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="alert alert-danger">
                        Data {{ strtolower($title) }} tidak ditemukan atau tidak dapat diedit.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
