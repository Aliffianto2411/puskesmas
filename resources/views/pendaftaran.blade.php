@extends('layouts.user')

@section('title', 'Dashboard - Puskesmas Meral')

@section('content')
<div class="container py-4">

  <h2 class="mb-4">Selamat Datang, {{ auth()->user()->name }}</h2>

  <!-- Invoice Janji Temu Aktif -->
  <div class="card shadow-sm mb-4">
    <div class="card-body">
      <h5 class="card-title">Invoice Janji Temu Aktif</h5>

      @if($activeInvoices->count() > 0)
        @foreach($activeInvoices as $invoice)
          <div class="card mb-3 border-success shadow-sm">
            <div class="card-header bg-success text-white">
              Nomor Antrian: {{ $invoice->nomor_antrian }} ({{ $invoice->status }})
            </div>
            <div class="card-body">
              <p><strong>Pasien:</strong> {{ $invoice->detailKeluarga->nama ?? '-' }}</p>
              <p><strong>Poli:</strong> {{ $invoice->poli->nama_poli ?? '-' }}</p>
              <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($invoice->tanggal)->format('d-m-Y') }}</p>
              <p><strong>Jam:</strong> {{ $invoice->jam }}</p>
                @switch($invoice->status)
                  @case('Menunggu')
                    @php $badgeClass = 'bg-warning text-dark'; @endphp
                    @break
                  @case('Batal')
                    @php $badgeClass = 'bg-danger'; @endphp
                    @break
                  @case('Diterima')
                    @php $badgeClass = 'bg-success'; @endphp
                    @break
                  @default
                    @php $badgeClass = 'bg-secondary'; @endphp
                @endswitch
                <p>
                  <strong>Status:</strong>
                  <span class="badge {{ $badgeClass }}">
                    {{ $invoice->status ?? 'Menunggu' }}
                  </span>
                </p>
                </p>
            </div>
          </div>
        @endforeach
      @else
        <p>Tidak ada invoice janji temu aktif.</p>
      @endif
    </div>
  </div>


  

  <!-- Riwayat Antrian -->
  <div class="card shadow-sm mb-4">
    <div class="card-body">
      <h5 class="card-title">Riwayat Antrian Terakhir</h5>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Poli</th>
            <th>Nomor</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach($riwayatAntrian as $riwayat)
          <tr>
            <td>{{ $riwayat['tanggal'] }}</td>
            <td>{{ $riwayat['poli'] }}</td>
            <td>{{ $riwayat['nomor'] }}</td>
            <td>
              @php
                $statusClass = match($riwayat['status']) {
                  'Selesai' => 'bg-success',
                  'Batal' => 'bg-danger',
                  default => 'bg-secondary'
                };
              @endphp
              <span class="badge {{ $statusClass }}">{{ $riwayat['status'] }}</span>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <!-- Pengumuman -->
 <div class="card shadow-sm">
  <div class="card-body">
    <h5 class="card-title">Pengumuman</h5>
    <ul class="list-group">
      @if($pengumuman->isNotEmpty())
        @foreach($pengumuman as $p)
          <li class="list-group-item">
            <h6>{{ $p->judul }}</h6>
            <p>{{ Str::limit($p->isi, 100) }}</p>
            <small class="text-muted">
              {{ \Carbon\Carbon::parse($p->tanggal_pengumuman)->translatedFormat('d F Y') }} - 
              {{ \Carbon\Carbon::parse($p->tanggal_berakhir)->translatedFormat('d F Y') }}
            </small>
          </li>
        @endforeach
      @else
        <li class="list-group-item">Tidak ada pengumuman saat ini.</li>
      @endif
    </ul>
  </div>
</div>

@endsection
