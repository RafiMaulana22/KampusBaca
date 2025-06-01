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
        @if ($errors->any())
            <div class="alert alert-danger dark alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>
                            <strong>Ups !</strong>
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
        @endif
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5>Data {{ $title }}</h5>
                    <small>Berikut adalah data {{ $title }} yang ada di KampusBaca</small>
                </div>
                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#tambahFakultas">
                    Tambah {{ $title }}
                </button>
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
                                <th>Nama Fakultas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($fakultas as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item->nama_fakultas }}</td>
                                    <td>
                                        <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                            data-bs-target="#editFakultas{{ $item->id }}">
                                            Edit
                                        </button>
                                        <button class="btn btn-danger" type="button" data-bs-toggle="modal"
                                            data-bs-target="#hapusFakultas{{ $item->id }}">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                                @include('admin.fakultas.modal')
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Pilih semua tombol dengan kelas 'tombol-hapus-fakultas'
            const tombolHapus = document.querySelectorAll('.tombol-hapus-fakultas');

            tombolHapus.forEach(tombol => {
                tombol.addEventListener('click', function(event) {
                    event.preventDefault(); // Mencegah aksi default tombol

                    const fakultasId = this.dataset.id;
                    const fakultasNama = this.dataset.nama;
                    const formId = 'formHapusFakultas' +
                        fakultasId; // Sesuaikan dengan ID form Anda
                    const formHapus = document.getElementById(formId);

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        html: `Anda akan menghapus fakultas "<strong>${fakultasNama}</strong>".<br>Tindakan ini tidak dapat dibatalkan!`, // Menggunakan html agar bisa bold
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33', // Warna tombol konfirmasi (merah)
                        cancelButtonColor: '#3085d6', // Warna tombol batal (biru)
                        confirmButtonText: 'Ya, hapus saja!',
                        cancelButtonText: 'Batalkan'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Jika pengguna mengkonfirmasi
                            if (formHapus) {
                                formHapus.submit(); // Kirim form penghapusan
                            } else {
                                // Jika form tidak ditemukan, tampilkan error (seharusnya tidak terjadi jika ID sudah benar)
                                Swal.fire(
                                    'Error!',
                                    'Formulir untuk penghapusan tidak ditemukan. Hubungi administrator.',
                                    'error'
                                );
                            }
                        }
                    });
                });
            });
        });
    </script>
@endsection
