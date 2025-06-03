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
        {{-- Alert untuk Catatan/Deskripsi Halaman --}}
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong class="me-1">Informasi:</strong>
            Halaman ini menampilkan daftar {{ strtolower($title) }}.
            Anda dapat menambahkan data baru menggunakan tombol "Tambah {{ $title }}" di atas,
            atau mengelola data yang sudah ada melalui menu aksi di setiap baris tabel.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5>Data {{ $title }}</h5>
                    <small>
                        Berikut adalah data {{ $title }} yang ada di KampusBaca
                    </small>
                </div>
                {{-- Tombol Tambah Staff --}}
                <a href="{{ route('staff.create') }}" class="btn btn-primary btn-sm">Tambah {{ $title }}</a>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success dark alert-dismissible fade show" role="alert">
                        <strong>Yeay !</strong>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"></span>
                        </button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table id="basic-1" class="display">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIP</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>Peran</th>
                                <th>Status Akun</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Asumsi variabel $mahasiswa sekarang berisi data staff --}}
                            @foreach ($staff as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item->nip }}</td> {{-- Ganti dengan field NIP Anda --}}
                                    <td>{{ $item->users->name }}</td>
                                    <td>{{ $item->users->email }}</td>
                                    <td>
                                        {{-- Sesuaikan dengan cara Anda menyimpan/mengakses peran --}}
                                        {{ $item->users->role }}
                                    </td>
                                    <td>
                                        @if (isset($item->users) && $item->users->status_akun == 'Aktif')
                                            <span class="badge bg-success">Aktif</span>
                                        @elseif (isset($item->users) && $item->users->status_akun == 'Tidak Aktif')
                                            <span class="badge bg-danger">Tidak Aktif</span>
                                        @else
                                            <span class="badge bg-warning">{{ $item->users->status_akun }}</span>
                                        @endif
                                    </td>
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
                                                        href="{{ route('staff.edit', ['staff' => $item->id]) }}">
                                                        {{-- Route untuk edit staff --}}
                                                        <i class="bi bi-pencil-square me-2"></i>
                                                        Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('staff.detail', ['staff' => $item->id]) }}">
                                                        {{-- Route untuk detail staff --}}
                                                        <i class="bi bi-eye me-2"></i>
                                                        Detail
                                                    </a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li>
                                                    {{-- Tombol Hapus Akun --}}
                                                    <button type="button" class="dropdown-item text-danger"
                                                        {{-- Warna teks untuk aksi hapus --}} data-bs-toggle="modal"
                                                        data-bs-target="#hapusStaff{{ $item->id }}">
                                                        {{-- Target modal hapus --}}
                                                        <i class="bi bi-trash me-2"></i> {{-- Ikon hapus --}}
                                                        Hapus {{-- Teks hapus --}}
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                                {{-- Modal Hapus Staff --}}
                                <div class="modal fade" id="hapusStaff{{ $item->id }}" tabindex="-1"
                                    {{-- ID modal hapus --}} aria-labelledby="hapusStaffLabel{{ $item->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="hapusStaffLabel{{ $item->id }}">
                                                    Konfirmasi Hapus Data {{ $title }} {{-- Judul modal hapus --}}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin menghapus data staff atas nama
                                                <strong>{{ $item->users->name ?? 'Data tidak tersedia' }}</strong>
                                                (NIP: {{ $item->nip ?? 'N/A' }})
                                                ?
                                                <br>
                                                <strong class="text-danger">Data yang sudah dihapus tidak dapat
                                                    dikembalikan!</strong>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    Batal
                                                </button>
                                                <a href="{{ route('staff.destroy', ['staff' => $item->id]) }}"
                                                    class="btn btn-danger"> {{-- Tombol konfirmasi hapus --}}
                                                    Ya, Hapus Data
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
