@extends('layouts.user')

@section('title', 'Dashboard - Puskesmas Meral')

@section('content')
<div class="container py-4">

    {{-- =========== FLASH MESSAGE =========== --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- =========== VALIDATION ERROR =========== --}}
    @if($errors->any())
        <div class="alert alert-danger mb-3">
            <ul class="mb-0">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    @endif


    {{-- =========== INFORMASI / FORM KK =========== --}}
    <div class="card mb-4">
        <div class="card-body">

            {{-- S-udah punya KK? --}}
            @if($keluarga)
                <h5>No KK: <strong>{{ $keluarga->no_kk }}</strong></h5>
            @else
                {{-- BELUM punya KK → tampilkan form pembuatan --}}
                <form action="{{ route('keluarga.store') }}" method="POST" class="row g-2">
                    @csrf
                    <div class="col-auto">
                        <input type="text" name="no_kk" class="form-control"
                               placeholder="Masukkan No KK (16 digit)" required>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary">Buat KK</button>
                    </div>
                </form>
            @endif
        </div>
    </div>



    {{-- =========== DAFTAR ANGGOTA & FORM TAMBAH =========== --}}
    @if($keluarga)
        {{-- ======= TABEL ANGGOTA ======= --}}
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
                                <a href="{{ route('anggota.edit', $a) }}"
                                   class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('anggota.destroy', $a) }}" method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Hapus anggota?')">
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


        {{-- ======= FORM TAMBAH ANGGOTA ======= --}}
        <div class="card">
            <div class="card-header">Tambah Anggota</div>

            <div class="card-body">
                <form action="{{ route('anggota.store') }}" method="POST" class="row g-3">
                    @csrf

                    <div class="col-md-6">
                        <label class="form-label">Nama</label>
                        <input name="nama" class="form-control"
                               value="{{ old('nama') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">NIK</label>
                        <input name="nik" class="form-control"
                               value="{{ old('nik') }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            <option value="Laki-laki"
                                {{ old('jenis_kelamin')=='Laki-laki'?'selected':'' }}>
                                Laki-laki
                            </option>
                            <option value="Perempuan"
                                {{ old('jenis_kelamin')=='Perempuan'?'selected':'' }}>
                                Perempuan
                            </option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control"
                               value="{{ old('tanggal_lahir') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Gol. Darah</label>
                        <select name="golongan_darah" class="form-select">
                            <option value="">--</option>
                            @foreach(['A','B','AB','O'] as $g)
                                <option value="{{ $g }}"
                                    {{ old('golongan_darah')==$g?'selected':'' }}>
                                    {{ $g }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control"
                                  rows="2">{{ old('alamat') }}</textarea>
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
