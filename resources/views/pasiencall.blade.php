@extends('layouts.user')

@section('title', 'Dashboard Dokter - Puskesmas Meral')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Dashboard Dokter</h2>

    {{-- Pasien yang sedang dilayani --}}
    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            Pasien Sedang Dilayani
        </div>
        <div class="card-body">
            @if(isset($currentPatient))
                <h5 class="card-title">{{ $currentPatient->nama }}</h5>
                <p><strong>NIK:</strong> {{ $currentPatient->nik }}</p>
                <p><strong>Keluhan:</strong> {{ $currentPatient->keluhan }}</p>
                <form action="{{ route('dokter.selesai', $currentPatient->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">Tandai Selesai</button>
                </form>
            @else
                <p class="text-muted">Belum ada pasien yang sedang dilayani.</p>
            @endif
        </div>
    </div>

    {{-- Antrean berikutnya --}}
    <div class="card">
        <div class="card-header bg-secondary text-white">
            Daftar Antrean Pasien Hari Ini
        </div>
        <div class="card-body">
            @if(isset($nextPatients) && count($nextPatients) > 0)
                <ul class="list-group">
                    @foreach($nextPatients as $patient)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $patient->nama }}</strong> - {{ $patient->keluhan }}
                            </div>
                            <form action="{{ route('dokter.panggil', $patient->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">Panggil</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted">Tidak ada pasien dalam antrean saat ini.</p>
            @endif
        </div>
    </div>
</div>
@endsection
S