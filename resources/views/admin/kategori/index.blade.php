@extends('layouts.template-admin')

@section('breadcrumb')
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-home"></i>
            </a>
        </li>
        {{--  <li class="breadcrumb-item">Dashboard</li>  --}}
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
@endsection

@section('content')
    <div class="col-sm-12">
        {{-- Alert untuk Deskripsi Halaman Konten Kategori --}}
        <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
            <strong class="me-1"><i class="bi bi-info-circle-fill"></i> Informasi Halaman:</strong>
            Halaman ini berfungsi untuk mengelola data {{ strtolower($title) }}.
            Anda dapat **menambahkan** {{ strtolower($title) }} menggunakan formulir yang tersedia di sisi
            kiri.
            Daftar {{ strtolower($title) }} yang sudah ada akan ditampilkan dalam tabel di sisi kanan, di mana Anda juga
            dapat melakukan aksi edit atau hapus.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        {{-- Alert untuk menampilkan semua error validasi --}}
        @if ($errors->any())
            <div class="alert alert-danger dark alert-dismissible fade show" role="alert">
                <strong class="me-1">Oops! Terjadi kesalahan:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-3">
            {{-- Kolom Kiri: Form Tambah/Edit Kategori --}}
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header">
                        {{-- Jika $kategori_edit ada, berarti ini form edit, jika tidak, form tambah --}}
                        @if (isset($kategori_edit))
                            <h5>Form Edit {{ $title }}</h5>
                            <small>Silahkan ubah nama {{ strtolower($title) }} pada form di bawah ini.</small>
                        @else
                            <h5>Form Tambah {{ $title }}</h5>
                            <small>Silahkan isi form berikut untuk menambahkan {{ strtolower($title) }} baru.</small>
                        @endif
                    </div>
                    <div class="card-body">
                        @if (isset($kategori_edit))
                            {{-- Form untuk Update Kategori --}}
                            <form action="{{ route('kategori.update', ['kategori' => $kategori_edit->id]) }}"
                                method="POST">
                                @method('PUT')
                            @else
                                {{-- Form untuk Store Kategori Baru --}}
                                <form action="{{ route('kategori.store') }}" method="POST">
                        @endif
                        @csrf
                        <div class="form-group">
                            <label for="nama_kategori" class="col-form-label">Nama Kategori:</label>
                            <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror"
                                value="{{ old('nama_kategori', $kategori_edit->nama_kategori ?? '') }}"
                                name="nama_kategori" id="nama_kategori" required>
                            @error('nama_kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- Tambahkan field lain untuk kategori jika ada, misal deskripsi --}}
                        {{-- <div class="form-group mt-2">
                            <label for="deskripsi_kategori" class="col-form-label">Deskripsi (Opsional):</label>
                            <textarea class="form-control @error('deskripsi_kategori') is-invalid @enderror"
                                      name="deskripsi_kategori" id="deskripsi_kategori" rows="3">{{ old('deskripsi_kategori', $kategori_edit->deskripsi ?? '') }}</textarea>
                            @error('deskripsi_kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> --}}
                        <div class="form-group mt-3">
                            <button class="btn btn-primary" type="submit">
                                {{ isset($kategori_edit) ? 'Update Kategori' : 'Simpan Kategori' }}
                            </button>
                            @if (isset($kategori_edit))
                                <a href="{{ route('kategori.index') }}" class="btn btn-light ms-2">Batal</a>
                                {{-- Sesuaikan route jika nama index berbeda --}}
                            @endif
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Tabel Data Kategori --}}
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5>Data {{ $title }}</h5>
                            <small>
                                Berikut adalah data {{ strtolower($title) }} yang ada di KampusBaca
                            </small>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success dark alert-dismissible fade show" role="alert">
                                <strong>Yeay !</strong> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table id="basic-1" class="display"> {{-- Pastikan ID ini unik atau gunakan kelas untuk inisialisasi DataTable --}}
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Kategori</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kategori as $index => $item)
                                        {{-- Ubah $jurusan menjadi $kategori --}}
                                        <tr>
                                            <td>{{ $index + 1 }}</td> {{-- Menggunakan $index dari loop untuk penomoran --}}
                                            <td>{{ $item->nama_kategori }}</td>
                                            <td>
                                                <a class="btn btn-primary"
                                                    href="{{ route('kategori.edit', ['kategori' => $item->id]) }}">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>
                                                <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal"
                                                    data-bs-target="#hapusKategori{{ $item->id }}">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </td>
                                        </tr>

                                        {{-- Modal Hapus Kategori --}}
                                        <div class="modal fade" id="hapusKategori{{ $item->id }}" tabindex="-1"
                                            aria-labelledby="hapusKategoriLabel{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="hapusKategoriLabel{{ $item->id }}">
                                                            Konfirmasi Hapus {{ $title }}
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah Anda yakin ingin menghapus kategori
                                                        <strong>{{ $item->nama_kategori }}</strong>?
                                                        <p class="mt-2 text-danger">Tindakan ini tidak dapat dibatalkan.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">
                                                            Batal
                                                        </button>
                                                        <a href="{{ route('kategori.destroy', ['kategori' => $item->id]) }}"
                                                            class="btn btn-danger">
                                                            Ya, Hapus
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
