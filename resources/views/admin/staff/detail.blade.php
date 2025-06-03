@extends('layouts.template-admin')

@section('breadcrumb')
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-home"></i>
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('staff.index') }}">Staff</a>
        </li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
@endsection

@section('content')
    <div class="container mt-4 mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Detail {{ $title ?? 'Staff' }}</h1> {{-- Menampilkan judul halaman --}}
            <div>
                <a href="{{ route('staff.index') }}" class="btn btn-danger btn-sm"> {{-- Ubah route ke staff.index --}}
                    <i class="bi bi-arrow-left"></i>
                    Kembali
                </a>
            </div>
        </div>

        <div class="row">
            {{-- Kolom Kiri: Informasi Dasar & Kontak --}}
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        {{-- Foto Staff --}}
                        @if (isset($staff->foto_staff))
                            {{-- Sesuaikan dengan field foto Anda, misal $staff->foto_staff atau $staff->users->profile_photo_path --}}
                            <img src="{{ asset('foto-staff/' . $staff->foto_staff) }}"
                                alt="Foto {{ $staff->users->name ?? 'Staff' }}"
                                class="img-fluid rounded-circle profile-picture mb-3"
                                style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                            <img src="{{ asset('') }}assets/images/user/kampusbaca.png" alt="Foto Staff Default"
                                {{-- Ganti dengan path placeholder Anda --}} class="img-fluid rounded-circle profile-picture mb-3"
                                style="width: 150px; height: 150px; object-fit: cover;">
                        @endif

                        <h4 class="card-title mb-1">{{ $staff->users->name ?? 'Nama Tidak Tersedia' }}</h4>
                        <p class="text-muted mb-0">NIP: {{ $staff->nip ?? 'NIP Tidak Tersedia' }}</p>
                        <hr>
                        <dl class="row text-start">
                            <dt class="col-sm-5 col-md-12 col-lg-5">
                                <i class="bi bi-envelope-fill text-primary me-2"></i>
                                Email
                            </dt>
                            <dd class="col-sm-7 col-md-12 col-lg-7">{{ $staff->users->email ?? '-' }}</dd>

                            <dt class="col-sm-5 col-md-12 col-lg-5">
                                <i class="bi bi-telephone-fill text-primary me-2"></i>
                                Telepon
                            </dt>
                            <dd class="col-sm-7 col-md-12 col-lg-7">
                                {{ $staff->users->nomor_telepon ?? 'Tidak tersedia' }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Detail dengan Tabs --}}
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="kepegawaian-tab" data-bs-toggle="tab"
                                    {{-- Ubah dari akademik ke kepegawaian --}} data-bs-target="#kepegawaian-tab-pane" type="button"
                                    role="tab" aria-controls="kepegawaian-tab-pane" aria-selected="false">
                                    <i class="bi bi-briefcase-fill"></i> {{-- Ubah ikon --}}
                                    Kepegawaian
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="akun-tab" data-bs-toggle="tab" data-bs-target="#akun-tab-pane"
                                    type="button" role="tab" aria-controls="akun-tab-pane" aria-selected="false">
                                    <i class="bi bi-gear"></i>
                                    Akun
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            {{-- Tab Kepegawaian --}}
                            <div class="tab-pane fade" id="kepegawaian-tab-pane" role="tabpanel"
                                aria-labelledby="kepegawaian-tab" tabindex="0">
                                <h5 class="card-title mb-3">Data Kepegawaian</h5>
                                <dl class="row">
                                    <dt class="col-sm-4">Jabatan</dt>
                                    <dd class="col-sm-8">
                                        {{ $staff->users->role ?? 'Tidak tersedia' }} {{-- Asumsi field 'jabatan' di model Staff --}}
                                    </dd>

                                    <dt class="col-sm-4">Tanggal Mulai Bekerja</dt>
                                    <dd class="col-sm-8">
                                        @if ($staff->users->created_at)
                                            {{-- Asumsi tanggal mulai bekerja diambil dari created_at user --}}
                                            {{ \Carbon\Carbon::parse($staff->users->created_at)->isoFormat('D MMMM YYYY') }}
                                        @else
                                            Tidak tersedia
                                        @endif
                                    </dd>
                                    {{-- Tambahkan field kepegawaian lain jika ada --}}
                                </dl>
                            </div>

                            {{-- Tab Akun --}}
                            <div class="tab-pane fade" id="akun-tab-pane" role="tabpanel" aria-labelledby="akun-tab"
                                tabindex="0">
                                <h5 class="card-title mb-3">Informasi Akun</h5>
                                <dl class="row">
                                    <dt class="col-sm-4">Status Akun</dt>
                                    <dd class="col-sm-8">
                                        @if (isset($staff->users) && $staff->users->status_akun == 'Aktif')
                                            <span class="badge bg-success">Aktif</span>
                                        @elseif (isset($staff->users) && $staff->users->status_akun == 'Tidak Aktif')
                                            <span class="badge bg-danger">Tidak Aktif</span>
                                        @else
                                            <span class="text-muted">Tidak tersedia</span>
                                        @endif
                                    </dd>
                                    <dt class="col-sm-4">Peran Sistem</dt>
                                    <dd class="col-sm-8">
                                        {{ $staff->users->role ?? 'Belum ada peran' }} {{-- Asumsi relasi user memiliki relasi role dengan nama_peran --}}
                                    </dd>
                                    {{-- Tambahkan info akun lain jika perlu --}}
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
