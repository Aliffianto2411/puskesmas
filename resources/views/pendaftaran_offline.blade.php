@extends('layouts.user')

@section('content')
<div class="container py-4">
    <h2>Form Pendaftaran Poli Offline</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('pendaftaran_offline.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama_pasien" class="form-label">Nama Pasien</label>
            <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" required>
        </div>

        <div class="mb-3">
            <label for="poli_id" class="form-label">Pilih Poli</label>
            <select class="form-select" id="poli_id" name="poli_id" required>
                <option value="">-- Pilih Poli --</option>
                @foreach($poli as $poli)
                <option value="{{ $poli->id }}">{{ $poli->nama_poli }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal Janji Temu</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ date('Y-m-d') }}" required>
        </div>
        <div class="mb-3">
    <label for="jam" class="form-label">Jam Janji Temu</label>
    <input type="time" class="form-control" id="jam" name="jam" required>
</div>

        <button type="submit" class="btn btn-primary">Daftar</button>
    </form>
</div>
@endsection
