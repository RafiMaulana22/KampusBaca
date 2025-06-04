@extends('layouts.template-admin')

@section('style')
    <style>
        .book-cover-detail {
            max-width: 300px;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .detail-section {
            margin-bottom: 2rem;
        }

        .detail-label {
            font-weight: 600;
            color: #555;
        }

        .badge-container .badge {
            margin-right: 5px;
            margin-bottom: 5px;
        }

        .action-buttons a,
        .action-buttons button {
            margin-right: 10px;
        }
    </style>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-home"></i>
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('buku.index') }}">Buku</a>
        </li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="row mb-3">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Detail Buku: {{ $buku->judul }}</h4>
                    <div>
                        <a href="{{ route('buku.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Buku
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Alert jika ada --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="row">
                    {{-- Kolom Kiri: Gambar Sampul & Aksi Utama --}}
                    <div class="col-lg-4 col-md-5 mb-4 text-center text-md-start">
                        <img src="{{ $buku->gambar_sampul ? asset($buku->gambar_sampul) : asset('assets/images/buku/sampul_KampusBaca.png') }}"
                            alt="Sampul {{ $buku->judul }}" class="book-cover-detail mb-3" height="490px">

                        <div class="action-buttons mb-3">
                            @if ($buku->file_buku)
                                <a href="{{ asset($buku->file_buku) }}" target="_blank"
                                    class="btn btn-success w-100 mb-2">
                                    <i class="bi bi-book-fill"></i> Baca / Unduh Buku
                                </a>
                            @else
                                <button class="btn btn-secondary w-100 mb-2" disabled>
                                    <i class="bi bi-x-circle"></i> File Buku Tidak Tersedia
                                </button>
                            @endif
                            {{-- Asumsi ada Gate atau Policy untuk otorisasi --}}
                            @can('update', $buku)
                                <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-primary w-100 mb-2">
                                    <i class="bi bi-pencil-square"></i> Edit Buku
                                </a>
                            @endcan
                            @can('delete', $buku)
                                <form action="{{ route('buku.destroy', $buku->id) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?');"
                                    class="d-inline w-100">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="bi bi-trash-fill"></i> Hapus Buku
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>

                    {{-- Kolom Kanan: Detail Teks --}}
                    <div class="col-lg-8 col-md-7">
                        <h2 class="card-title mb-1">{{ $buku->judul }}</h2>

                        <div class="detail-section">
                            <h5>
                                <i class="bi bi-info-circle-fill text-primary me-2"></i>Informasi Umum</h5>
                            <div class="row">
                                <div class="col-sm-6 mb-2">
                                    <span class="detail-label">Tahun Terbit:</span> {{ $buku->tahun_terbit ?: '-' }}
                                </div>
                                <div class="col-sm-6 mb-2">
                                </div>
                                <div class="col-sm-6 mb-2">
                                    <span class="detail-label">Bahasa:</span> {{ $buku->bahasa ?: '-' }}
                                </div>
                            </div>
                        </div>

                        <div class="detail-section">
                            <h5>
                                <i class="bi bi-file-earmark-binary-fill text-secondary me-2"></i>
                                Detail File Digital
                            </h5>
                            <div class="row">
                                <div class="col-sm-6 mb-2">
                                    <span class="detail-label">Format File:</span>
                                    {{ $buku->tipe_file ?: ($buku->file_buku ? strtoupper(pathinfo($buku->file_buku, PATHINFO_EXTENSION)) : '-') }}
                                </div>
                                <div class="col-sm-6 mb-2">
                                </div>
                                <div class="col-sm-6 mb-2">
                                    <span class="detail-label">Jumlah Salinan Digital:</span>
                                    {{ $buku->jumlah_salinan_digital == -1 || $buku->jumlah_salinan_digital === null || $buku->jumlah_salinan_digital == 0 ? 'Tidak Terbatas' : $buku->jumlah_salinan_digital }}
                                </div>
                            </div>
                        </div>

                        <div class="detail-section">
                            <h5><i class="bi bi-gear-fill text-muted me-2"></i>Informasi Administratif</h5>
                            <div class="row">
                                <div class="col-sm-6 mb-2">
                                    <span class="detail-label">Status Ketersediaan:</span>
                                    <span
                                        class="badge bg-{{ $buku->status_ketersediaan == 'Tersedia' ? 'info' : 'secondary' }}">
                                        {{ $buku->status_ketersediaan ?: 'Tidak Diketahui' }}
                                    </span>
                                </div>
                                <div class="col-sm-6 mb-2">
                                    <span class="detail-label">Tanggal Ditambahkan:</span>
                                    {{ $buku->created_at ? $buku->created_at->isoFormat('D MMMM YYYY, HH:mm') : '-' }}
                                </div>
                                <div class="col-sm-6 mb-2">
                                    <span class="detail-label">Ditambahkan Oleh:</span>
                                    {{ $buku->users ? $buku->users->name : 'Sistem' }}
                                    {{-- Asumsi ada relasi 'ditambahkanOleh' ke model User/Staf yang memiliki 'nama_lengkap' --}}
                                </div>
                                <div class="col-sm-6 mb-2">
                                    <span class="detail-label">Terakhir Diperbarui:</span>
                                    {{ $buku->updated_at ? $buku->updated_at->isoFormat('D MMMM YYYY, HH:mm') : '-' }}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
