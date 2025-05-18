@extends('layouts.user')

@section('title', 'Edit Profil - Puskesmas Meral')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Edit Profil</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            {{-- tampilkan error validasi --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- form --}}
            <form action="{{ route('profile.update', $pasien->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Nama --}}
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                        value="{{ old('nama', $pasien->nama) }}" required>
                </div>


                {{-- NIK --}}
                <div class="mb-3">
                    <label class="form-label">NIK</label>
                    <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror"
                        value="{{ old('nik', $pasien->nik) }}">
                </div>

                {{-- Jenis Kelamin --}}
                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror">
                        <option value="jenis_kelamin">-- Pilih --</option>
                        <option value="Laki-laki"  {{ old('jenis_kelamin',$pasien->jenis_kelamin)=='Laki-laki'?'selected':'' }}>Laki-laki</option>
                        <option value="Perempuan"  {{ old('jenis_kelamin',$pasien->jenis_kelamin)=='Perempuan'?'selected':'' }}>Perempuan</option>
                    </select>
                </div>

                {{-- Tanggal Lahir --}}
                <div class="mb-3">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                        value="{{ old('tanggal_lahir', $pasien->tanggal_lahir) }}">
                </div>

                {{-- Alamat --}}
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" rows="2" class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $pasien->alamat) }}</textarea>
                </div>

                {{-- No HP --}}
                <div class="mb-3">
                    <label class="form-label">No. HP</label>
                    <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror"
                        value="{{ old('no_hp', $pasien->no_hp) }}">
                </div>

                {{-- Golongan Darah --}}
                <div class="mb-3">
                    <label class="form-label">Golongan Darah</label>
                    <select name="golongan_darah" class="form-select @error('golongan_darah') is-invalid @enderror">
                        <option value="">-- Pilih --</option>
                        @foreach (['A','B','AB','O'] as $gol)
                            <option value="{{ $gol }}" {{ old('golongan_darah',$pasien->golongan_darah)==$gol?'selected':'' }}>{{ $gol }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('profile.edit', $pasien->id) }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
