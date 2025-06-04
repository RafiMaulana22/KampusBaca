@extends('layouts.template-admin')

@section('breadcrumb')
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-home"></i>
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('kategori.index') }}">Kategori</a>
        </li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
@endsection

@section('content')
    <div class="row g-3">
        {{-- Kolom Kiri: Form Tambah/Edit Kategori --}}
        <div class="col-sm-4">
            <div class="card">
                <div class="card-header">
                    <h5>Form {{ $title }}</h5>
                    <small>Silahkan ubah nama {{ strtolower($title) }} pada form di bawah ini.</small>
                </div>
                <div class="card-body">
                    {{-- Form untuk Update Kategori --}}
                    <form action="{{ route('kategori.update', ['kategori' => $kategori->id]) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama_kategori" class="col-form-label">Nama Kategori:</label>
                            <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror"
                                value="{{ old('nama_kategori', $kategori->nama_kategori ?? '') }}" name="nama_kategori"
                                id="nama_kategori" required>
                            @error('nama_kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <button class="btn btn-primary btn-sm" type="submit">
                                Update Kategori
                            </button>
                            <a href="{{ route('kategori.index') }}" class="btn btn-light btn-sm ms-2">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-sm-8">
            {{-- Alert untuk Deskripsi/Petunjuk Form Edit --}}
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong class="me-1"><i class="bi bi-info-circle-fill"></i> Petunjuk:</strong>
                Anda sedang mengubah data untuk {{ strtolower($title) }}
                @if (isset($kategori) && $kategori->nama_kategori)
                    '<strong>{{ $kategori->nama_kategori }}</strong>'.
                @else
                    ini.
                @endif
                Silakan perbarui field di samping ini dan klik tombol "Update {{ $title }}" untuk menyimpan perubahan.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endsection
