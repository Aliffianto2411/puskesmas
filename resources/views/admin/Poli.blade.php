@extends('layouts.user')

@section('content')
<div class="container">
    <h2>Manajemen Poli</h2>

    <!-- Tombol Tambah Poli -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahPoli">+ Tambah Poli</button>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Tabel Data Poli -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Poli</th>
                <th>Kode</th>
                <th>Dibuat</th>
                <th>Terakhir Diperbarui</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($poli as $p)
            <tr>
                <td>{{ $p->nama_poli }}</td>
                <td>{{ $p->kode_poli }}</td>
                <td>{{ $p->created_at }}</td>
                <td>{{ $p->updated_at }}</td>
                <td>
                    <!-- Tombol Edit -->
                    <button 
                        class="btn btn-warning btn-sm btn-edit" 
                        data-id="{{ $p->id }}">
                        Edit
                    </button>

                    <!-- Tombol Hapus -->
                    <form action="{{ route('poli.destroy', $p->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Tambah Poli -->
<div class="modal fade" id="modalTambahPoli" tabindex="-1" aria-labelledby="modalTambahPoliLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('poli.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahPoliLabel">Tambah Poli</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="nama_poli" class="form-label">Nama Poli</label>
            <input type="text" name="nama_poli" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="kode_poli" class="form-label">Kode Poli</label>
            <input type="text" name="kode_poli" class="form-control" required maxlength="5">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit Poli (dinamis via AJAX) -->
<div class="modal fade" id="modalEditPoli" tabindex="-1" aria-labelledby="modalEditPoliLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="editPoliContent">
      <!-- Konten form edit akan dimuat di sini -->
    </div>
  </div>
</div>
<script>
    $(document).on('click', '.btn-edit', function () {
        var id = $(this).data('id');
        $.get('/poli/' + id + '/edit')
            .done(function (data) {
                $('#editPoliContent').html(data);
                var modal = new bootstrap.Modal(document.getElementById('modalEditPoli'));
                modal.show();
            })
            .fail(function () {
                alert('Gagal memuat data edit');
            });
    });
</script>
@endsection

