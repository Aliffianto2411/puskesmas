@extends('layouts.user')

@section('content')
<div class="container py-4">
    <h2><i class="bi bi-speedometer2"></i> Dashboard - Puskesmas Meral
    </h2>

    {{-- Statistik --}}
    <div class="row mb-4">
        @php
    $cards = [
        [
            'title' => 'Total Pasien',
            'value' => $totalPasien,
            'class' => 'primary',
            'route' => null // tidak ada link
        ],
        [
            'title' => 'Total Poli',
            'value' => $totalPoli,
            'class' => 'success',
            'route' => route('admin.poli.index')
        ],
        [
            'title' => 'Janji Hari Ini',
            'value' => $janjiHariIni,
            'class' => 'info',
            // 'route' => route('admin.janji.offline.index')
        ],
        [
            'title' => 'Antrian Aktif',
            'value' => $antrianAktif,
            'class' => 'danger',
            // 'route' => route('admin.janji.offline.index')
        ],
    ];
@endphp

@foreach ($cards as $card)
    <div class="col-md-3">
      
        <div class="card text-white bg-{{ $card['class'] }} mb-3 h-100">
            <div class="card-body text-center">
                <h5 class="card-title">{{ $card['title'] }}</h5>
                <p class="fs-4">{{ $card['value'] }}</p>
            </div>
        </div>
        
    </div>
@endforeach
    </div>

    {{-- Grafik --}}
    <div class="card mb-4">
        <div class="card-header">Grafik Kunjungan (7 Hari Terakhir)</div>
        <div class="card-body">
            <canvas id="grafikPasien" height="100"></canvas>
        </div>
    </div>

    {{-- Antrian Hari Ini --}}
    <div class="card mb-4">
        <div class="card-header">Antrian Hari Ini</div>
        <div class="card-body table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No Antrian</th>
                        <th>Nama Pasien</th>
                        <th>Poli</th>
                        <th>Jam</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($antrianHariIni as $antrian)
                    <tr>
                        <td>{{ $antrian->nomor_antrian }}</td>
                        <td>{{ $antrian->user->name ?? '-' }}</td>
                        <td>{{ $antrian->poli->nama_poli ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($antrian->jam)->format('H:i') }}</td>
                        <td>
                            @if ($antrian->status === 'menunggu')
                                <span class="badge bg-warning text-dark">Menunggu</span>
                            @elseif ($antrian->status === 'dipanggil')
                                <span class="badge bg-info">Dipanggil</span>
                            @else
                                <span class="badge bg-success">Selesai</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5">Tidak ada antrian hari ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Riwayat Pendaftaran --}}
   {{-- Riwayat Pendaftaran --}}
<div class="card">
    <div class="card-header">Riwayat Pendaftaran Terakhir</div>
    <div class="card-body table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Pasien</th>
                    <th>Poli</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($riwayatTerakhir as $r)
                <tr>
                    <td>{{ $r->detailKeluarga->nama ?? '-' }}</td>
                    <td>{{ $r->poli->nama_poli ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($r->tanggal)->format('d M Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($r->jam)->format('H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Assign PHP data to JS variables first
    const grafikLabels = {!! json_encode($grafikData['labels'] ?? []) !!};
    const grafikData = {!! json_encode($grafikData['data'] ?? []) !!};

    const ctx = document.getElementById('grafikPasien').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: grafikLabels,
            datasets: [{
                label: 'Jumlah Pasien',
                data: grafikData,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderRadius: 6,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0
                    }
                }
            }
        }
    });
});
</script>

@endsection