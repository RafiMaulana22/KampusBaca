{{--  Modal Tambah  --}}
<div class="modal fade" id="tambahFakultas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('fakultas.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Form {{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('fakultas.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Nama Fakultas:</label>
                            <input type="text" class="form-control" Value="{{ old('nama_fakultas') }}"
                                name="nama_fakultas" id="recipient-name" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{--  Modal Edit  --}}
<div class="modal fade" id="editFakultas{{ $item->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('fakultas.update', ['fakultas' => $item->slug]) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Form {{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('fakultas.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Nama Fakultas:</label>
                            <input type="text" class="form-control" Value="{{ $item->nama_fakultas }}"
                                name="nama_fakultas" id="recipient-name" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{--  Modal Hapus  --}}
<div class="modal fade" id="hapusFakultas{{ $item->id }}" tabindex="-1"
    aria-labelledby="hapusFakultasLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hapusFakultasLabel{{ $item->id }}">Konfirmasi Hapus Fakultas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus
                <strong>{{ $item->nama_fakultas }}</strong>
                ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="{{ route('fakultas.destroy', ['fakultas' => $item->slug]) }}" class="btn btn-danger">Ya, Hapus</a>
            </div>
        </div>
    </div>
</div>
