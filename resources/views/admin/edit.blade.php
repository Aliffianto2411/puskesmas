<div class="modal-header">
    <h5 class="modal-title">Edit Poli</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form method="POST" action="{{ route('poli.update', $poli->id) }}">
    @csrf
    @method('PUT')
    <div class="modal-body">
        <div class="mb-3">
            <label for="nama_poli" class="form-label">Nama Poli</label>
            <input type="text" id="nama_poli" name="nama_poli" class="form-control" value="{{ $poli->nama_poli }}" required>
        </div>
        <div class="mb-3">
            <label for="kode_poli" class="form-label">Kode Poli</label>
            <input type="text" id="kode_poli" name="kode_poli" class="form-control" value="{{ $poli->kode_poli }}" required maxlength="5">
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>
