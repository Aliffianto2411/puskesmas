@extends('layouts.user')

@section('content')
<div class="container py-4">
    <h2 class="mb-4"><i class=""></i> Daftar Pengumuman</h2>

    {{-- Flash message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Tombol Tambah --}}
    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahPengumuman">
            <i class="bi bi-plus-circle"></i> Tambah Pengumuman
        </button>
    </div>

    {{-- Tabel --}}
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Judul</th>
                    <th>Isi</th>
                    <th>Tanggal Pengumuman</th>
                    <th>Tanggal Berakhir</th>
                    <th style="width: 140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengumuman as $p)
                <tr>
                    <td>{{ $p->judul }}</td>
                    <td>{{ Str::limit($p->isi, 100) }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal_pengumuman)->translatedFormat('d F Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal_berakhir)->translatedFormat('d F Y') }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            {{-- Edit --}}
                            <button type="button" class="btn btn-warning btn-sm btn-edit" data-id="{{ $p->id }}">
                                <i class="bi bi-pencil-square"></i>
                            </button>

                            {{-- Hapus --}}
                            <form action="{{ route('pengumuman.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Belum ada pengumuman.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Tambah --}}
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

{{-- Modal Edit --}}
<div class="modal fade" id="modalEditPengumuman" tabindex="-1" aria-labelledby="modalEditPengumumanLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="editPengumumanContent">
      <!-- AJAX content will be injected here -->
      <div class="d-flex justify-content-center align-items-center py-5" id="loadingEdit" style="display:none;">
        <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Script untuk AJAX Edit --}}
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).on('click', '.btn-edit', function () {
        var id = $(this).data('id');
        $('#loadingEdit').show();
        $('#editPengumumanContent').html($('#loadingEdit')); // tampilkan loading

        $.get("{{ url('/pengumuman') }}/" + id + "/edit")
            .done(function (data) {
                $('#editPengumumanContent').html(data);
                var modal = new bootstrap.Modal(document.getElementById('modalEditPengumuman'));
                modal.show();
            })
            .fail(function () {
                alert('Gagal memuat data untuk diedit.');
            });
    });
</script>
@endpush

@endsection
