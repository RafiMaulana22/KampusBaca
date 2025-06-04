@extends('layouts.template-admin')

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
    <div class="col-sm-12">
        {{-- Alert untuk Pesan Error Umum (dari redirect with 'error' di controller) --}}
        @if (session('error'))
            <div class="alert alert-danger dark alert-dismissible fade show" role="alert">
                <strong class="me-1"><i class="bi bi-exclamation-triangle-fill"></i> Gagal!</strong>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Alert untuk menampilkan semua error validasi dari Laravel --}}
        @if ($errors->any())
            <div class="alert alert-danger dark alert-dismissible fade show" role="alert">
                <strong class="me-1"><i class="bi bi-exclamation-circle-fill"></i> Oops! Ada beberapa hal yang perlu
                    diperbaiki:</strong>
                <ul class="mb-0 mt-2" style="padding-left: 1.5rem;"> {{-- Menambahkan sedikit padding kiri untuk list --}}
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h5>Form {{ $title }}</h5>
                <small>
                    Silahkan isi form berikut untuk menambahkan {{ strtolower($title) }} baru
                </small>
            </div>
            <div class="card-body">
                <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="row g-3">
                        {{-- Judul Buku --}}
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label for="judul_buku" class="form-label">Judul Buku <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('judul_buku') is-invalid @enderror"
                                    name="judul_buku" id="judul_buku" value="{{ old('judul_buku') }}" required>
                                @error('judul_buku')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Tahun Terbit --}}
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="tahun_terbit" class="form-label">Tahun Terbit <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('tahun_terbit') is-invalid @enderror"
                                    name="tahun_terbit" id="tahun_terbit" value="{{ old('tahun_terbit') }}"
                                    placeholder="Contoh: {{ date('Y') }}" min="1000" max="{{ date('Y') }}"
                                    required>
                                @error('tahun_terbit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Bahasa --}}
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="bahasa" class="form-label">Bahasa <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('bahasa') is-invalid @enderror"
                                    name="bahasa" id="bahasa" value="{{ old('bahasa') }}"
                                    placeholder="Contoh: Indonesia, Inggris" required>
                                @error('bahasa')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Kategori (Multi-select) --}}
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label for="kategori_id" class="form-label">
                                    Kategori
                                    <span class="text-danger">*</span></label>
                                <select name="kategori_id" id="kategori_id" class="form-select">
                                    <option value="" selected disabled>-- Pilih Kategori --</option>
                                    @foreach ($kategoris as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama_kategori }}</option>
                                    @endforeach
                                </select>
                                @error('kategori_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Gambar Sampul --}}
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="gambar_sampul" class="form-label">Gambar Sampul (Opsional)</label>
                                <input type="file" class="form-control @error('gambar_sampul') is-invalid @enderror"
                                    name="gambar_sampul" id="gambar_sampul" accept="image/*" onchange="previewImage()">
                                @error('gambar_sampul')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <img id="gambar-sampul-preview"
                                    src="{{ asset('assets/images/buku/sampul_KampusBaca.png') }}"
                                    alt="Pratinjau Gambar Sampul" class="mt-2 img-thumbnail"
                                    style="max-width: 150px; max-height: 200px; display: block;" />
                                <small class="form-text text-muted">Format: JPG, PNG, WEBP. Maks: 2MB.</small>
                            </div>
                        </div>

                        {{-- File Buku --}}
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="file_buku" class="form-label">File Buku (PDF, EPUB) <span
                                        class="text-danger">*</span></label>
                                <input type="file" class="form-control @error('file_buku') is-invalid @enderror"
                                    name="file_buku" id="file_buku" accept=".pdf,.epub" required>
                                @error('file_buku')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small class="form-text text-muted">Format: PDF, EPUB. Maks: 10MB.</small>
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="col-12 mb-3 mt-4">
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary me-2">Simpan Buku</button>
                                <button type="reset" class="btn btn-warning me-2" onclick="resetPreview()">Reset
                                    Form</button>
                                <a href="{{ route('buku.index') }}" class="btn btn-danger">Kembali</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // ... (fungsi previewImage dan resetPreview tetap sama) ...
        function previewImage() {
            const inputFile = document.getElementById('gambar_sampul');
            const preview = document.getElementById('gambar-sampul-preview');
            const defaultImage = "{{ asset('assets/images/buku/sampul_KampusBaca.png') }}";

            if (inputFile.files && inputFile.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(inputFile.files[0]);
            } else {
                preview.src = defaultImage;
            }
        }

        function resetPreview() {
            const preview = document.getElementById('gambar-sampul-preview');
            const defaultImage = "{{ asset('assets/images/buku/sampul_KampusBaca.png') }}";
            preview.src = defaultImage;
        }

        document.addEventListener('DOMContentLoaded', function() {
            const inputFile = document.getElementById('gambar_sampul');
            if (!inputFile.value) {
                resetPreview();
            }
        });
    </script>
@endsection
