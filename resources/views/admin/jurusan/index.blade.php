@extends('layouts.template-admin')

@section('breadcrumb')
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-home"></i>
            </a>
        </li>
        {{--  <li class="breadcrumb-item">Dashboard</li>  --}}
        <li class="breadcrumb-item active">{{ $title }} {{ $fakultas->nama_fakultas }}</li>
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
        <div class="row g-3">
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Form {{ $title }} {{ $fakultas->nama_fakultas }}</h5>
                        <small>
                            Silahkan isi form berikut untuk menambahkan {{ $title }} baru pada
                            {{ $fakultas->nama_fakultas }}
                        </small>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('jurusan.store', ['fakultas' => $fakultas->id]) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="nama_jurusan" class="col-form-label">Nama Jurusan:</label>
                                <input type="text" class="form-control" Value="{{ old('nama_jurusan') }}"
                                    name="nama_jurusan" id="nama_jurusan" required>
                            </div>
                            <div class="form-group mt-3">
                                <button class="btn btn-primary" type="submit">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5>Data {{ $title }} {{ $fakultas->nama_fakultas }}</h5>
                            <small>
                                Berikut adalah data {{ $title }} {{ $fakultas->nama_fakultas }} yang ada di
                                KampusBaca
                            </small>
                        </div>
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
                                        <th>Nama jurusan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($jurusan as $item)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $item->nama_jurusan }}</td>
                                            <td>
                                                <a class="btn btn-primary sm-0"
                                                    href="{{ route('jurusan.edit', ['jurusan' => $item->id, 'fakultas' => $fakultas->id]) }}">
                                                    Edit
                                                </a>
                                                <button class="btn btn-danger sm-0" type="button" data-bs-toggle="modal"
                                                    data-bs-target="#hapusJurusan{{ $item->id }}">
                                                    Hapus
                                                </button>
                                            </td>
                                        </tr>

                                        {{--  Modal Hapus  --}}
                                        <div class="modal fade" id="hapusJurusan{{ $item->id }}" tabindex="-1"
                                            aria-labelledby="hapusjurusanLabel{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="hapusjurusanLabel{{ $item->id }}">
                                                            Konfirmasi Hapus jurusan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah Anda yakin ingin menghapus
                                                        <strong>{{ $item->nama_jurusan }}</strong>
                                                        pada {{ $fakultas->nama_fakultas }}?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <a href="{{ route('jurusan.destroy', ['fakultas' => $fakultas->id, 'jurusan' => $item->id]) }}"
                                                            class="btn btn-danger">Ya, Hapus</a>
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
