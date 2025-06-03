@extends('layouts.user')

@section('title', 'Dashboard - Puskesmas Meral')

@section('content')
<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <h2 class="mb-4">Riwayat Pendaftaran Poli</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Riwayat Pendaftaran Anda</h5>

            @if($riwayat->count() > 0)
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Anggota Keluarga</th>
                            <th>Poli</th>
                            <th>Nomor Antrian</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayat as $antrian)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($antrian->tanggal)->format('d M Y') }}</td>
                                <td>{{ $antrian->detailKeluarga->nama ?? '-' }}</td>
                                <td>{{ $antrian->poli->nama_poli ?? '-' }}</td>
                                <td>{{ $antrian->nomor_antrian }}</td>
                                <td>
                                    @php
                                        $status = strtolower($antrian->status);
                                    @endphp

                                    @switch($status)
                                        @case('selesai')
                                            <span class="badge bg-success">Selesai</span>
                                            @break
                                        @case('batal')
                                            <span class="badge bg-danger">Batal</span>
                                            @break
                                        @case('diterima')
                                            <span class="badge bg-primary">Diterima</span>
                                            @break
                                        @case('menunggu')
                                            <span class="badge bg-warning text-dark">Menunggu</span>
                                            @break
                                        @default
                                            <span class="badge bg-danger">Dibatalkan</span>
                                    @endswitch
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted">Belum ada riwayat antrian.</p>
            @endif
        </div>
    </div>
</div>
@endsection