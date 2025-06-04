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
                <ul class="mb-0 mt-2" style="padding-left: 1.5rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                {{-- Mengubah Judul Form --}}
                <h5>Form Edit {{ $title }}</h5>
                <small>
                    Silahkan ubah data {{ strtolower($title) }} berikut jika diperlukan.
                </small>
            </div>
            <div class="card-body">
                {{-- Mengubah action route dan menambahkan method PUT --}}
                <form action="{{ route('buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data"
                    novalidate>
                    @csrf
                    @method('PUT') {{-- Method spoofing untuk update --}}

                    <div class="row g-3">
                        {{-- Judul Buku --}}
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label for="judul_buku" class="form-label">Judul Buku <span
                                        class="text-danger">*</span></label>
                                {{-- Mengisi value dengan data yang ada --}}
                                <input type="text" class="form-control @error('judul_buku') is-invalid @enderror"
                                    name="judul_buku" id="judul_buku" value="{{ old('judul_buku', $buku->judul) }}"
                                    required>
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
                                {{-- Mengisi value dengan data yang ada --}}
                                <input type="number" class="form-control @error('tahun_terbit') is-invalid @enderror"
                                    name="tahun_terbit" id="tahun_terbit"
                                    value="{{ old('tahun_terbit', $buku->tahun_terbit) }}"
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
                                {{-- Mengisi value dengan data yang ada --}}
                                <input type="text" class="form-control @error('bahasa') is-invalid @enderror"
                                    name="bahasa" id="bahasa" value="{{ old('bahasa', $buku->bahasa) }}"
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
                                        <option
                                            value="{{ $item->id }} {{ ($item->id == $buku->kategori_id) ? 'selected' : '' }}">
                                            {{ $item->nama_kategori }}
                                        </option>
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
                                <label for="gambar_sampul" class="form-label">Ganti Gambar Sampul (Opsional)</label>
                                <input type="file" class="form-control @error('gambar_sampul') is-invalid @enderror"
                                    name="gambar_sampul" id="gambar_sampul" accept="image/*" onchange="previewImage()">
                                @error('gambar_sampul')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <p class="mt-2 mb-1">Gambar Sampul Saat Ini:</p>
                                <img id="gambar-sampul-preview" {{-- Menampilkan gambar sampul yang ada, atau placeholder jika tidak ada --}}
                                    src="{{ $buku->gambar_sampul ? asset($buku->gambar_sampul) : asset('assets/images/buku/sampul_KampusBaca.png') }}"
                                    alt="Pratinjau Gambar Sampul" class="img-thumbnail"
                                    style="max-width: 150px; max-height: 200px; display: block;" />
                                <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti. Format: JPG, PNG,
                                    WEBP. Maks: 2MB.</small>
                            </div>
                        </div>

                        {{-- File Buku --}}
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="file_buku" class="form-label">Ganti File Buku (PDF, EPUB) (Opsional)</label>
                                <input type="file" class="form-control @error('file_buku') is-invalid @enderror"
                                    name="file_buku" id="file_buku" accept=".pdf,.epub"> {{-- required dihilangkan --}}
                                @error('file_buku')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                @if ($buku->file_buku)
                                    <p class="mt-2 mb-0">File Buku Saat Ini:
                                        <a href="{{ asset($buku->file_buku) }}" target="_blank">
                                            {{ $buku->file_buku ?: 'Lihat File' }}
                                        </a>
                                    </p>
                                @else
                                    <p class="mt-2 mb-0 text-warning">Belum ada file buku terunggah.</p>
                                @endif
                                <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti. Format: PDF,
                                    EPUB. Maks: 10MB.</small>
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="col-12 mb-3 mt-4">
                            <div class="d-flex justify-content-end">
                                {{-- Mengubah teks tombol submit --}}
                                <button type="submit" class="btn btn-primary me-2">Update Buku</button>
                                <button type="reset" class="btn btn-warning me-2"
                                    onclick="resetPreviewToOriginal()">Reset
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
        // Simpan path gambar asli untuk reset
        const originalImageSrc =
            "{{ $buku->gambar_sampul ? asset('storage/' . $buku->gambar_sampul) : asset('assets/images/buku/sampul_KampusBaca.png') }}";

        function previewImage() {
            const image = document.querySelector('#gambar_sampul');
            const imgPreview = document.querySelector('#gambar-sampul-preview');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }

        function resetPreviewToOriginal() {
            const imgPreview = document.querySelector('#gambar-sampul-preview');
            document.querySelector('#gambar_sampul').value = ""; // Mengosongkan input file
            imgPreview.src = originalImageSrc; // Kembalikan ke gambar asli buku atau placeholder
            // Anda mungkin juga ingin mereset field lain jika diperlukan oleh tombol "Reset Form" standar
            // Namun, tombol reset HTML standar akan mereset ke nilai `value` awal yang dimuat dari server.
            // Fungsi ini lebih spesifik untuk preview gambar jika tombol reset di-custom.
        }

        // Jika Anda menggunakan tombol reset HTML (<button type="reset"...>),
        // maka preview gambar akan kembali ke `src` awal saat halaman dimuat.
        // Fungsi `resetPreviewToOriginal` di atas berguna jika Anda ingin kontrol lebih
        // atau jika tombol reset memanggil JavaScript secara eksplisit.
        // Untuk tombol reset standar yang sudah ada, `resetPreview()` di `onclick` diubah menjadi `resetPreviewToOriginal()`
        // agar bisa mengembalikan ke gambar asli.
    </script>
@endsection
