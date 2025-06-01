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
                        Berikut adalah data {{ $title }} yang ada di KampusBaca
                    </small>
                </div>
                <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary btn-sm">Tambah {{ $title }}</a>
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
                                <th>NIM</th>
                                <th>Nama Mahasiswa</th>
                                <th>Fakultas</th>
                                <th>Program Studi</th>
                                <th>Status Akun</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($mahasiswa as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item->nim }}</td>
                                    <td>{{ $item->users->name }}</td>
                                    <td>{{ $item->jurusans->fakultas->nama_fakultas }}</td>
                                    <td>{{ $item->jurusans->nama_jurusan }}</td>
                                    <td>
                                        @if ($item->users->status_akun == 'Aktif')
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light dropdown-toggle" type="button"
                                                id="actionDropdown{{ $item->id }}" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical"></i>
                                                {{-- Atau bi-three-dots untuk horizontal --}}
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="actionDropdown{{ $item->id }}">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('mahasiswa.edit', ['mahasiswa' => $item->id]) }}">
                                                        <i class="bi bi-pencil-square me-2"></i>
                                                        Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('mahasiswa.detail', ['mahasiswa' => $item->id]) }}">
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
                                                        data-bs-target="#hapusMahasiswa{{ $item->id }}">
                                                        <i class="bi bi-trash me-2"></i>
                                                        Hapus
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                                {{--  Modal Hapus  --}}
                                <div class="modal fade" id="hapusMahasiswa{{ $item->id }}" tabindex="-1"
                                    aria-labelledby="hapusMahasiswaLabel{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="hapusMahasiswaLabel{{ $item->id }}">
                                                    Konfirmasi Hapus Mahasiswa</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin menghapus
                                                <strong>{{ $item->users->name }}</strong>
                                                ?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    Batal
                                                </button>
                                                <a href="{{ route('mahasiswa.destroy', ['mahasiswa' => $item->id]) }}"
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
