@extends('layouts.template-admin')

@section('breadcrumb')
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-home"></i>
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('jurusan.index', ['fakultas' => $fakultas->id]) }}">Jurusan {{ $fakultas->nama_fakultas }}</a>
        </li>
        <li class="breadcrumb-item active">{{ $title }} {{ $fakultas->nama_fakultas }}</li>
    </ol>
@endsection

@section('content')
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
                    <form action="{{ route('jurusan.update', ['fakultas' => $fakultas->id, 'jurusan' => $jurusan->id]) }}"
                        method="POST" novalidate>
                        @csrf
                        <div class="form-group">
                            <label for="nama_jurusan" class="col-form-label">Nama Jurusan:</label>
                            <input type="text" class="form-control @error('nama_jurusan') is-invalid @enderror"
                                Value="{{ $jurusan->nama_jurusan }}" name="nama_jurusan" id="nama_jurusan" required>
                            @error('nama_jurusan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <button class="btn btn-primary" type="submit">Update</button>
                            <a href="{{ route('jurusan.index', ['fakultas' => $fakultas->id]) }}"
                                class="btn btn-danger">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
