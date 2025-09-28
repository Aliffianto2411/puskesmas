@extends('layouts.user')

@section('content')
<div class="container py-4">
    <h2>Form Pendaftaran Poli Offline</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pendaftaran_offline.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="no_kk" class="form-label">Nomor KK</label>
            <input type="text" class="form-control" id="no_kk" name="no_kk" value="{{ old('no_kk') }}" required>
        </div>

        <div class="mb-3">
            <label for="detail_keluarga_id" class="form-label">Nama Pasien</label>
            <select class="form-select" id="detail_keluarga_id" name="detail_keluarga_id" required>
                <option value="">-- Pilih Anggota Keluarga --</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="poli_id" class="form-label">Pilih Poli</label>
            <select class="form-select" id="poli_id" name="poli_id" required>
                <option value="">-- Pilih Poli --</option>
                @foreach($poli as $p)
                    <option value="{{ $p->id }}" {{ (isset($poli_id) && $poli_id == $p->id) ? 'selected' : '' }}>
                        {{ $p->nama_poli }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal Janji Temu</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal"
                   value="{{ $tanggal ?? date('Y-m-d') }}" required>
        </div> -->

        <button type="submit" class="btn btn-primary">Daftar</button>
    </form>
</div>

<script>
// Load anggota keluarga otomatis saat KK diisi
document.getElementById('no_kk').addEventListener('blur', function () {
    const noKK = this.value;
    const pasienSelect = document.getElementById('detail_keluarga_id');
    pasienSelect.innerHTML = '<option>Loading...</option>';

    fetch(`/api/anggota-keluarga/${noKK}`)
        .then(res => {
            if (!res.ok) throw new Error("Nomor KK tidak ditemukan");
            return res.json();
        })
        .then(data => {
            pasienSelect.innerHTML = '<option value="">-- Pilih Anggota Keluarga --</option>';
            data.forEach(anggota => {
                pasienSelect.innerHTML += `<option value="${anggota.id}">${anggota.nama}</option>`;
            });
        })
        .catch(err => {
            pasienSelect.innerHTML = '<option value="">Gagal memuat data</option>';
            alert(err.message);
        });
});
</script>

@endsection
