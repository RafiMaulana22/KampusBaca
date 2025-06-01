@extends('layouts.template-admin')

@section('breadcrumb')
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-home"></i>
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('mahasiswa.index') }}">Mahasiswa</a>
        </li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
@endsection

@section('content')
    <div class="container mt-4 mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3"></h1>
            <div>
                <a href="{{ route('mahasiswa.index') }}" class="btn btn-danger btn-sm">
                    <i class="bi bi-arrow-left"></i>
                    Kembali
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        @if ($mahasiswa->foto_mahasiswa)
                            <img src="{{ asset('foto-mahasiswa/' . $mahasiswa->foto_mahasiswa) }}" alt="Foto Mahasiswa"
                                class="img-fluid rounded-circle profile-picture mb-3" id="fotoMahasiswa">
                        @endif
                        <img src="{{ asset('') }}assets/images/user/kampusbaca.png" alt="Foto Mahasiswa"
                            class="img-fluid rounded-circle profile-picture mb-3" id="fotoMahasiswa" style="height: 50%">
                        <h4 class="card-title mb-1" id="namaMahasiswa">{{ $mahasiswa->users->name }}</h4>
                        <p class="text-muted mb-0" id="nimMahasiswa">NIM: {{ $mahasiswa->nim }}</p>
                        <hr>
                        <dl class="row text-start">
                            <dt class="col-sm-5 col-md-12 col-lg-5">
                                <i class="bi bi-envelope-fill text-primary me-2"></i>
                                Email
                            </dt>
                            <dd class="col-sm-7 col-md-12 col-lg-7" id="emailMahasiswa">{{ $mahasiswa->users->email }}</dd>

                            <dt class="col-sm-5 col-md-12 col-lg-5">
                                <i class="bi bi-telephone-fill text-primary me-2"></i>
                                Telepon
                            </dt>
                            <dd class="col-sm-7 col-md-12 col-lg-7" id="nomorTelepon">
                                @if (!$mahasiswa->users->nomor_telepon)
                                    <span class="text-muted">Nomor telepon tidak tersedia</span>
                                @else
                                    <span class="text-muted">{{ $mahasiswa->users->nomor_telepon }}</span>
                                @endif
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="identitas-tab" data-bs-toggle="tab"
                                    data-bs-target="#identitas-tab-pane" type="button" role="tab"
                                    aria-controls="identitas-tab-pane" aria-selected="true">
                                    <i class="bi bi-person-vcard"></i>
                                    Identitas
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="akademik-tab" data-bs-toggle="tab"
                                    data-bs-target="#akademik-tab-pane" type="button" role="tab"
                                    aria-controls="akademik-tab-pane" aria-selected="false">
                                    <i class="bi bi-mortarboard"></i>
                                    Akademik
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="akun-tab" data-bs-toggle="tab" data-bs-target="#akun-tab-pane"
                                    type="button" role="tab" aria-controls="akun-tab-pane" aria-selected="false">
                                    <i class="bi bi-gear"></i>
                                    Akun & Lainnya
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="identitas-tab-pane" role="tabpanel"
                                aria-labelledby="identitas-tab" tabindex="0">
                                <h5 class="card-title mb-3">Data Identitas Utama</h5>
                                <dl class="row">
                                    <dt class="col-sm-4">Tempat Lahir</dt>
                                    <dd class="col-sm-8" id="tempatLahir">
                                        @if (!$mahasiswa->tempat_lahir)
                                            <span class="text-muted">Tempat lahir tidak tersedia</span>
                                        @else
                                            <span class="text-muted">{{ $mahasiswa->tempat_lahir }}</span>
                                        @endif
                                    </dd>

                                    <dt class="col-sm-4">Tanggal Lahir</dt>
                                    <dd class="col-sm-8" id="tanggalLahir">
                                        @if (!$mahasiswa->tanggal_lahir)
                                            <span class="text-muted">Tanggal lahir tidak tersedia</span>
                                        @else
                                            <span
                                                class="text-muted">{{ $mahasiswa->tanggal_lahir->format('d F Y') }}</span>
                                        @endif
                                    </dd>

                                    <dt class="col-sm-4">Jenis Kelamin</dt>
                                    <dd class="col-sm-8" id="jenisKelamin">
                                        @if ($mahasiswa->jenis_kelamin == 'L')
                                            <span class="badge bg-primary">Laki-laki</span>
                                        @elseif($mahasiswa->jenis_kelamin == 'P')
                                            <span class="badge bg-danger">Perempuan</span>
                                        @else
                                            <span class="text-muted">Jenis kelamin tidak tersedia</span>
                                        @endif
                                    </dd>
                                </dl>
                            </div>

                            <div class="tab-pane fade" id="akademik-tab-pane" role="tabpanel"
                                aria-labelledby="akademik-tab" tabindex="0">
                                <h5 class="card-title mb-3">Data Akademik</h5>
                                <dl class="row">
                                    <dt class="col-sm-4">Program Studi/Jurusan</dt>
                                    <dd class="col-sm-8" id="jurusan">
                                        @if ($mahasiswa->jurusans)
                                            <span class="text-muted">{{ $mahasiswa->jurusans->nama_jurusan }}</span>
                                        @else
                                            <span class="text-muted">Jurusan tidak tersedia</span>
                                        @endif
                                    </dd>

                                    <dt class="col-sm-4">Angkatan</dt>
                                    <dd class="col-sm-8" id="angkatan">
                                        @if (!$mahasiswa->angkatan)
                                            <span class="text-muted">Angkatan tidak tersedia</span>
                                        @else
                                            <span class="text-muted">{{ $mahasiswa->angkatan }}</span>
                                        @endif
                                    </dd>

                                    <dt class="col-sm-4">Status Mahasiswa</dt>
                                    <dd class="col-sm-8" id="statusMahasiswa">
                                        @if ($mahasiswa->status_mahasiswa == 'Aktif')
                                            <span class="badge bg-success">Aktif</span>
                                        @elseif($mahasiswa->status_mahasiswa == 'Cuti')
                                            <span class="badge bg-warning">Cuti</span>
                                        @elseif($mahasiswa->status_mahasiswa == 'Lulus')
                                            <span class="badge bg-info">Lulus</span>
                                        @elseif($mahasiswa->status_mahasiswa == 'Drop Out')
                                            <span class="badge bg-danger">Drop Out</span>
                                        @else
                                            <span class="text-muted">Status tidak tersedia</span>
                                        @endif
                                    </dd>
                                </dl>
                            </div>

                            <div class="tab-pane fade" id="akun-tab-pane" role="tabpanel" aria-labelledby="akun-tab"
                                tabindex="0">
                                <h5 class="card-title mb-3">Informasi Akun & Peminjaman</h5>
                                <dl class="row">
                                    <dt class="col-sm-4">Status Akun</dt>
                                    <dd class="col-sm-8" id="statusAkun">
                                        @if ($mahasiswa->users->status_akun == 'Aktif')
                                            <span class="badge bg-success">Aktif</span>
                                        @elseif($mahasiswa->users->status_akun == 'Tidak Aktif')
                                            <span class="badge bg-danger">Tidak Aktif</span>
                                        @else
                                            <span class="text-muted">Status akun tidak tersedia</span>
                                        @endif
                                    </dd>

                                    <dt class="col-sm-4">Kuota Maksimal Peminjaman</dt>
                                    <dd class="col-sm-8" id="kuotaPeminjaman">
                                        @if ($mahasiswa->kuota_maksimal_peminjaman)
                                            <span class="text-muted">{{ $mahasiswa->kuota_maksimal_peminjaman }} Buku</span>
                                        @else
                                            <span class="text-muted">Kuota peminjaman tidak tersedia</span>
                                        @endif
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
