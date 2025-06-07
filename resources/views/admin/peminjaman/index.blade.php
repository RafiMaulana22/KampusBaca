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
                    <table id="basic-1" class="display">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Buku</th>
                                <th>Peminjam</th>
                                <th>NIM</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($peminjamans as $item)
                                {{-- Ubah $mahasiswa menjadi $peminjamans --}}
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item->buku->judul }}</td>
                                    <td>{{ $item->mahasiswas->users->name }}</td>
                                    <td>
                                        {{ $item->mahasiswas->users->nim }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->isoFormat('D MMM YYYY') }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($item->tanggal_kembali)->isoFormat('D MMM YYYY') }}
                                    </td>
                                    <td>
                                        @if ($item->status_peminjaman == 'Dipinjam')
                                            <span class="badge bg-warning">Dipinjam</span>
                                        @endif
                                        <span class="badge bg-success">Dikembalikan</span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light dropdown-toggle" type="button"
                                                id="actionDropdown{{ $item->id }}" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="actionDropdown{{ $item->id }}">
                                                @if ($item->status == 'Dipinjam')
                                                    <li>
                                                        <button type="button" class="dropdown-item text-success"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#kembalikanBukuModal{{ $item->id }}">
                                                            <i class="bi bi-check-circle me-2"></i>Tandai Kembali
                                                        </button>
                                                    </li>
                                                @endif
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('peminjaman.show', $item->id) }}">
                                                        <i class="bi bi-eye me-2"></i>Detail Peminjaman
                                                    </a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li>
                                                    <button type="button" class="dropdown-item text-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#hapusPeminjaman{{ $item->id }}">
                                                        <i class="bi bi-trash me-2"></i>Hapus Riwayat
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                                {{-- Modal Hapus Peminjaman --}}
                                <div class="modal fade" id="hapusPeminjaman{{ $item->id }}" tabindex="-1"
                                    aria-labelledby="hapusPeminjamanLabel{{ $item->id }}" aria-hidden="true">
                                    {{-- ... (konten modal hapus disesuaikan untuk peminjaman) ... --}}
                                </div>

                                {{-- Modal Konfirmasi Pengembalian Buku --}}
                                <div class="modal fade" id="kembalikanBukuModal{{ $item->id }}" tabindex="-1"
                                    aria-labelledby="kembalikanBukuModalLabel{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="kembalikanBukuModalLabel{{ $item->id }}">
                                                    Konfirmasi Pengembalian Buku</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin menandai buku
                                                <strong>"{{ $item->buku->judul_buku ?? '' }}"</strong> yang dipinjam oleh
                                                <strong>{{ $item->user->name ?? '' }}</strong> telah dikembalikan?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <form action="{{ route('peminjaman.kembalikan', $item->id) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-success">Ya, Tandai
                                                        Kembali</button>
                                                </form>
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
