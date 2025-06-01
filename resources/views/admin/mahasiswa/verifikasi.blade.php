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
                                        @elseif ($item->users->status_akun == 'Tidak Aktif')
                                            <span class="badge bg-danger">Tidak Aktif</span>
                                        @else
                                            <span class="badge bg-warning">{{ $item->users->status_akun }}</span>
                                            {{-- Status lain --}}
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
                                                        href="{{ route('mahasiswa.detail', ['mahasiswa' => $item->id]) }}">
                                                        <i class="bi bi-eye me-2"></i>
                                                        Detail
                                                    </a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li>
                                                    {{-- Tombol Verifikasi Akun --}}
                                                    <button type="button" class="dropdown-item text-success"
                                                        {{-- Ubah warna teks --}} data-bs-toggle="modal"
                                                        data-bs-target="#verifikasiMahasiswa{{ $item->id }}">
                                                        {{-- Ubah target modal --}}
                                                        <i class="bi bi-person-check-fill me-2"></i> {{-- Ubah ikon (contoh ikon verifikasi) --}}
                                                        Verifikasi Akun {{-- Ubah teks --}}
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                                {{-- Modal Verifikasi Akun --}}
                                <div class="modal fade" id="verifikasiMahasiswa{{ $item->id }}" tabindex="-1"
                                    {{-- Ubah ID modal --}} aria-labelledby="verifikasiMahasiswaLabel{{ $item->id }}"
                                    aria-hidden="true"> {{-- Ubah aria-labelledby --}}
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="verifikasiMahasiswaLabel{{ $item->id }}">
                                                    {{-- Ubah ID label dan teks judul --}}
                                                    Konfirmasi Verifikasi Akun Mahasiswa</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin memverifikasi akun untuk
                                                <strong>{{ $item->users->name }}</strong> (NIM: {{ $item->nim }})?
                                                {{-- Tambahkan informasi lain jika perlu, misal status saat ini --}}
                                                <br><small>Status saat ini:
                                                    @if ($item->users->status_akun == 'Aktif')
                                                        <span class="badge bg-success">Aktif</span>
                                                    @else
                                                        <span class="badge bg-danger">Tidak Aktif</span>
                                                    @endif
                                                </small>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    Batal
                                                </button>
                                                {{-- Form untuk aksi verifikasi (lebih aman daripada link GET) --}}
                                                <form action="{{ route('mahasiswa.status', ['mahasiswa' => $item->id]) }}"
                                                    method="POST" style="display: inline;"> {{-- Sesuaikan route dan parameter. Mungkin ID user yang diverifikasi? --}}
                                                    @csrf
                                                    @method('PATCH') {{-- Atau POST/PUT, tergantung implementasi backend Anda --}}
                                                    <button type="submit" class="btn btn-success"> {{-- Ubah kelas tombol dan teks --}}
                                                        Ya, Verifikasi Akun
                                                    </button>
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
