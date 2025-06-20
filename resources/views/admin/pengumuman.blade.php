@extends('layouts.user')

@section('content')
<div class="container">
    <h2><i class="bi bi-megaphone-fill"></i> Daftar Pengumuman</h2>

    <!-- Tombol Tambah Pengumuman -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahPengumuman">
        <i class="bi bi-plus-circle"></i> Tambah Pengumuman
    </button>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Tabel Data Pengumuman -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Isi</th>
                <th>Tanggal Pengumuman</th>
                <th>Tanggal Berakhir</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengumuman as $p)
            <tr>
                <td>{{ $p->judul }}</td>
                <td>{{ Str::limit($p->isi, 100) }}</td>
                <td>{{ \Carbon\Carbon::parse($p->tanggal_pengumuman)->translatedFormat('d F Y') }}</td>
              <td>{{ \Carbon\Carbon::parse($p->tanggal_berakhir)->translatedFormat('d F Y') }}</td>

                <td>
                    <!-- Tombol Edit -->
                    <button class="btn btn-warning btn-sm btn-edit" data-id="{{ $p->id }}">
                        <i class="bi bi-pencil-square"></i> Edit
                    </button>

                    <!-- Tombol Hapus -->
                    <form action="{{ route('pengumuman.destroy', $p->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Tambah Pengumuman -->
<div class="modal fade" id="modalTambahPengumuman" tabindex="-1" aria-labelledby="modalTambahPengumumanLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('pengumuman.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahPengumumanLabel">Tambah Pengumuman</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="judul" class="form-label">Judul</label>
            <input type="text" name="judul" id="judul" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="isi" class="form-label">Isi</label>
            <textarea name="isi" id="isi" class="form-control" rows="4" required></textarea>
          </div>
          <div class="mb-3">
            <label for="tanggal_pengumuman" class="form-label">Tanggal Pengumuman</label>
            <input type="date" name="tanggal_pengumuman" id="tanggal_pengumuman" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="tanggal_berakhir" class="form-label">Tanggal Berakhir</label>
            <input type="date" name="tanggal_berakhir" id="tanggal_berakhir" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit Pengumuman -->
<div class="modal fade" id="modalEditPengumuman" tabindex="-1" aria-labelledby="modalEditPengumumanLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="editPengumumanContent">
      <!-- Isi modal akan dimuat oleh AJAX -->
    </div>
  </div>
</div>

<script>
    $(document).on('click', '.btn-edit', function () {
        var id = $(this).data('id');
        $.get('/pengumuman/' + id + '/edit')
            .done(function (data) {
                $('#editPengumumanContent').html(data);
                var modal = new bootstrap.Modal(document.getElementById('modalEditPengumuman'));
                modal.show();
            })
            .fail(function () {
                alert('Gagal memuat data edit');
            });
    });
</script>

@endsection

