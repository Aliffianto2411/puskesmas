@extends('layouts.app')

@section('title','Edit Anggota')

@section('content')
<div class="container py-4">
    <h3 class="mb-3">Edit Anggota</h3>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('anggota.update', $anggota) }}" method="POST" class="row g-3">
        @csrf @method('PUT')

        <div class="col-md-6">
            <label class="form-label">Nama</label>
            <input name="nama" class="form-control" value="{{ old('nama',$anggota->nama) }}" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">NIK</label>
            <input name="nik" class="form-control" value="{{ old('nik',$anggota->nik) }}" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-select" required>
                <option value="Laki-laki" {{ old('jenis_kelamin',$anggota->jenis_kelamin)=='Laki-laki'?'selected':'' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('jenis_kelamin',$anggota->jenis_kelamin)=='Perempuan'?'selected':'' }}>Perempuan</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="form-control"
                   value="{{ old('tanggal_lahir',$anggota->tanggal_lahir) }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Gol. Darah</label>
            <select name="golongan_darah" class="form-select">
                @foreach(['A','B','AB','O'] as $g)
                    <option value="{{ $g }}" {{ old('golongan_darah',$anggota->golongan_darah)==$g?'selected':'' }}>{{ $g }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" rows="2">{{ old('alamat',$anggota->alamat) }}</textarea>
        </div>

        <div class="col-12 d-flex gap-2">
            <button class="btn btn-primary">Update</button>
            <a href="{{ route('keluarga.show') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
