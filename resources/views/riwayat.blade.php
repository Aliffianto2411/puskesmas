@extends('layouts.user')

@section('title', 'Dashboard - Puskesmas Meral')

@section('content')
<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <h2 class="mb-4">Riwayat Antrian</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Riwayat Antrian Anda</h5>

            @if($riwayat->count() > 0)
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Poli</th>
                            <th>Nomor Antrian</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayat as $antrian)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($antrian->tanggal)->format('d M Y') }}</td>
                                <td>{{ $antrian->poli->nama_poli }}</td>
                                <td>{{ $antrian->nomor_antrian }}</td>
                                <td>
                                    @if($antrian->status == 'selesai')
                                        <span class="badge bg-success">Selesai</span>
                                    @elseif($antrian->status == 'batal')
                                        <span class="badge bg-danger">Batal</span>
                                    @else($antrian->status == 'menunggu')
                                        <span class="badge bg-warning text-dark">Menunggu</span>
                                    @endif
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
