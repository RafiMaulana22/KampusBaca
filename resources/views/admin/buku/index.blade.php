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
        {{-- Alert Deskripsi Halaman --}}
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="bi bi-info-circle-fill me-2"></i>
            Halaman ini menampilkan daftar <strong>Data {{ $title }}</strong>. Anda dapat melakukan pencarian,
            melihat detail, mengubah, atau menghapus data melalui tabel di bawah dan tombol aksi yang tersedia.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5>Data {{ $title }}</h5>
                    <small>
                        Berikut adalah data {{ strtolower($title) }} yang ada di KampusBaca
                    </small>
                </div>
                <a href="{{ route('buku.create') }}" class="btn btn-primary btn-sm">Tambah {{ $title }}</a>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success dark alert-dismissible fade show" role="alert">
                        <strong>Yeay !</strong>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger dark alert-dismissible fade show" role="alert">
                        <strong>Oops !</strong>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table id="basic-1" class="display"> {{-- Pastikan ID ini sesuai untuk DataTables jika digunakan --}}
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar Sampul</th>
                                <th>Judul Buku</th>
                                <th>Tahun Terbit</th>
                                <th>Kategori</th>
                                <th>Status Ketersediaan</th>
                                <th>Tgl. Ditambahkan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($buku as $item)
                                {{-- Ganti $mahasiswa menjadi $buku --}}
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>
                                        @if ($item->gambar_sampul)
                                            <img src="{{ asset($item->gambar_sampul) }}" alt="Sampul {{ $item->judul }}"
                                                style="width: 50px; height: 70px; object-fit: cover; border-radius: 4px;"
                                                onError="this.onerror=null;this.src='{{ asset('assets/images/buku/sampul-KampusBaca.png') }}';">
                                            {{-- Fallback jika gambar error --}}
                                        @else
                                            <img src="{{ asset('assets/images/buku/sampul-KampusBaca.png') }}"
                                                alt="Sampul Default" {{-- Path ke gambar default Anda --}}
                                                style="width: 50px; height: 70px; object-fit: cover; border-radius: 4px;">
                                        @endif
                                    </td>
                                    <td>{{ $item->judul }}</td>
                                    <td>{{ $item->tahun_terbit ?? 'N/A' }}</td>
                                    <td>
                                        {{ $item->kategoris->nama_kategori }}
                                    </td>
                                    <td>
                                        @if ($item->status_ketersediaan == 'Tersedia')
                                            <span class="badge bg-success">Tersedia</span>
                                        @elseif ($item->status_ketersediaan == 'Dipinjam')
                                            <span class="badge bg-warning text-dark">Dipinjam</span>
                                        @else
                                            <span class="badge bg-info">{{ $item->status_ketersediaan ?? 'N/A' }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->created_at ? $item->created_at->isoFormat('D MMM YYYY') : 'N/A' }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light dropdown-toggle" type="button"
                                                id="actionDropdown{{ $item->id }}" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="actionDropdown{{ $item->id }}">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('buku.edit', ['buku' => $item->id]) }}">
                                                        <i class="bi bi-pencil-square me-2"></i>
                                                        Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('buku.detail', ['buku' => $item->id]) }}">
                                                        {{-- Sesuaikan jika nama route detail berbeda --}}
                                                        <i class="bi bi-eye me-2"></i>
                                                        Detail
                                                    </a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li>
                                                    <button type="button" class="dropdown-item text-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#hapusBuku{{ $item->id }}">
                                                        <i class="bi bi-trash me-2"></i>
                                                        Hapus
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                                {{-- Modal Hapus Buku --}}
                                <div class="modal fade" id="hapusBuku{{ $item->id }}" tabindex="-1"
                                    aria-labelledby="hapusBukuLabel{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="hapusBukuLabel{{ $item->id }}">
                                                    Konfirmasi Hapus {{ $title }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin menghapus buku berjudul
                                                <strong>"{{ $item->judul }}"</strong>?
                                                <p class="mt-2 text-danger">Tindakan ini tidak dapat dibatalkan.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    Batal
                                                </button>
                                                <a href="{{ route('buku.destroy', ['buku' => $item->id]) }}"
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
@endsection
