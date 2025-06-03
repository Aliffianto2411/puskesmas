<div class="modal-header">
    <h5 class="modal-title">Edit Pengumuman</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form method="POST" action="{{ route('pengumuman.update', $pengumuman->id) }}">
    @csrf
    @method('PUT')
    <div class="modal-body">
        <div class="mb-3">
            <label for="judul" class="form-label">Judul</label>
            <input type="text" id="judul" name="judul" class="form-control" value="{{ $pengumuman->judul }}" required>
        </div>
        <div class="mb-3">
            <label for="isi" class="form-label">Isi</label>
            <textarea id="isi" name="isi" class="form-control" required>{{ $pengumuman->isi }}</textarea>
        </div>
        <div class="mb-3">
            <label for="tanggal_pengumuman" class="form-label">Tanggal Pengumuman</label>
            <input type="date" id="tanggal_pengumuman" name="tanggal_pengumuman" class="form-control" value="{{ \Carbon\Carbon::parse($pengumuman->tanggal_pengumuman)->format('Y-m-d') }}"
 required>
        </div>
        <div class="mb-3">
            <label for="tanggal_berakhir" class="form-label">Tanggal Berakhir</label>
            <input type="date" id="tanggal_berakhir" name="tanggal_berakhir" class="form-control" value="{{ \Carbon\Carbon::parse($pengumuman->tanggal_berakhir)->format('Y-m-d') }}"
 required>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>
