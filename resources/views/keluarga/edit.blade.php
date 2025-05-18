@extends('layouts.user')

@section('title', 'Edit Anggota Keluarga')

@section('content')
<div class="container py-4">

    {{-- ======= BREADCRUMB / JUDUL ======= --}}
    <h4 class="mb-3">Edit Anggota – {{ $anggota->nama }}</h4>

    {{-- ======= FLASH MESSAGE ======= --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- ======= VALIDATION ERROR ======= --}}
    @if($errors->any())
        <div class="alert alert-danger mb-3">
            <ul class="mb-0">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            {{--  ======= FORM UPDATE =======  --}}
            <form action="{{ route('anggota.update', $anggota) }}" method="POST" class="row g-3">
                @csrf
                @method('PUT')

                <div class="col-md-6">
                    <label class="form-label">Nama</label>
                    <input name="nama" class="form-control @error('nama') is-invalid @enderror"
                           value="{{ old('nama', $anggota->nama) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">NIK</label>
                    <input name="nik" class="form-control @error('nik') is-invalid @enderror"
                           value="{{ old('nik', $anggota->nik) }}" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                        <option value="Laki-laki"  {{ old('jenis_kelamin', $anggota->jenis_kelamin)=='Laki-laki'?'selected':'' }}>Laki-laki</option>
                        <option value="Perempuan"  {{ old('jenis_kelamin', $anggota->jenis_kelamin)=='Perempuan'?'selected':'' }}>Perempuan</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir"
                           class="form-control @error('tanggal_lahir') is-invalid @enderror"
                           value="{{ old('tanggal_lahir', $anggota->tanggal_lahir) }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Gol. Darah</label>
                    <select name="golongan_darah" class="form-select @error('golongan_darah') is-invalid @enderror">
                        <option value="">--</option>
                        @foreach(['A','B','AB','O'] as $g)
                            <option value="{{ $g }}"
                                {{ old('golongan_darah', $anggota->golongan_darah)==$g ? 'selected':'' }}>
                                {{ $g }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" rows="2"
                              class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $anggota->alamat) }}</textarea>
                </div>

                <div class="col-12 d-flex gap-2">
                    <button class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('keluarga.show') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
