@extends('layouts.user')

@section('title', 'Dashboard - Puskesmas Meral')

@section('content')
<div class="container py-4">

    {{-- FLASH MESSAGE --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- VALIDATION ERROR --}}
    @if($errors->any())
        <div class="alert alert-danger mb-3">
            <ul class="mb-0">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">

            @if(auth()->user()->hasRole('ADMIN'))
                {{-- Form tambah KK --}}
                <form action="{{ route('keluarga.store') }}" method="POST" class="row g-2 mb-3">
                    @csrf
                    <div class="col-auto">
                        <input type="text" name="no_kk" class="form-control" placeholder="Masukkan No KK (16 digit)" required>
                    </div>
                    <div class="col-auto">
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                        <span class="form-control-plaintext">
                            Kepala Keluarga: <strong>{{ auth()->user()->name }}</strong>
                        </span>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-success">Tambah KK</button>
                    </div>
                </form>

                {{-- Daftar KK --}}
                <h5 class="mb-3">Daftar KK:</h5>
                <ul class="list-group">
                    @foreach($daftarKk as $kk)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>No KK: <strong>{{ $kk->no_kk }}</strong> - Kepala: {{ $kk->user->name ?? '-' }}</span>
                            <a href="{{ route('keluarga.show', $kk->id) }}" class="btn btn-outline-primary btn-sm">
                                Detail & Tambah Anggota
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                {{-- User: hanya bisa create sekali --}}
                @if($keluarga)
                    <h5>No KK: <strong>{{ $keluarga->no_kk }}</strong></h5>
                @else
                    <form action="{{ route('keluarga.store') }}" method="POST" class="row g-2">
                        @csrf
                        <div class="col-auto">
                            <input type="text" name="no_kk" class="form-control" placeholder="Masukkan No KK (16 digit)" required>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary">Buat KK</button>
                        </div>
                    </form>
                @endif
            @endif
        </div>
    </div>

    {{-- Bagian detail anggota & tambah anggota (untuk user & admin saat buka detail KK) --}}
    @if($keluarga)
        <div class="card mb-4">
            <div class="card-header">Anggota Keluarga</div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead class="table-light">
                    <tr>
                        <th>No</th><th>Nama</th><th>NIK</th><th>Jenis Kelamin</th>
                        <th>Tgl Lahir</th><th>Gol. Darah</th><th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse(optional($keluarga)->anggota ?? [] as $i => $a)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ $a->nama }}</td>
                            <td>{{ $a->nik }}</td>
                            <td>{{ $a->jenis_kelamin }}</td>
                            <td>{{ $a->tanggal_lahir }}</td>
                            <td>{{ $a->golongan_darah }}</td>
                            <td class="text-end">
                                <a href="{{ route('anggota.edit', $a) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('anggota.destroy', $a) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus anggota?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada anggota.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Form tambah anggota --}}
        <div class="card">
            <div class="card-header">Tambah Anggota</div>
            <div class="card-body">
                <form action="{{ route('anggota.store') }}" method="POST" class="row g-3">
                    @csrf
                    <input type="hidden" name="keluarga_id" value="{{ $keluarga->id }}">
                    <div class="col-md-6">
                        <label class="form-label">Nama</label>
                        <input name="nama" class="form-control" value="{{ old('nama') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">NIK</label>
                        <input name="nik" class="form-control" value="{{ old('nik') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin')=='Laki-laki'?'selected':'' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin')=='Perempuan'?'selected':'' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Gol. Darah</label>
                        <select name="golongan_darah" class="form-select">
                            <option value="">--</option>
                            @foreach(['A','B','AB','O'] as $g)
                                <option value="{{ $g }}" {{ old('golongan_darah')==$g?'selected':'' }}>{{ $g }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="2">{{ old('alamat') }}</textarea>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>
@endsection