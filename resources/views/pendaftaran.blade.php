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

              @if($invoice->status == 'Menunggu')
                <form action="{{ route('appointment.checkin', $invoice->id) }}" method="POST" class="d-inline">
                  @csrf
                  <button type="submit" class="btn btn-success btn-sm">Check-In</button>
                </form>
                <form action="{{ route('appointment.cancel', $invoice->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin membatalkan janji temu ini?');">
                  @csrf
                  <button type="submit" class="btn btn-danger btn-sm">Batal</button>
                </form>
              @endif
            </div>
          </div>
        @endforeach
      @else
        <p>Tidak ada invoice janji temu aktif.</p>
      @endif
    </div>
  </div>


  <!-- Jadwal Dokter Hari Ini -->
  <div class="card shadow-sm mb-4">
    <div class="card-body">
      <h5 class="card-title">Jadwal Dokter Hari Ini</h5>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Poli</th>
            <th>Dokter</th>
            <th>Jam Praktek</th>
          </tr>
        </thead>
        <tbody>
          @foreach($jadwalDokter as $jadwal)
          <tr>
            <td>{{ $jadwal['poli'] }}</td>
            <td>{{ $jadwal['dokter'] }}</td>
            <td>{{ $jadwal['jam'] }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
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
        <li class="list-group-item">
          <strong>Libur Nasional</strong><br>
          <small>Puskesmas tutup pada tanggal 10 Mei 2025.</small>
        </li>
        <li class="list-group-item">
          <strong>Perubahan Jadwal Poli Gigi</strong><br>
          <small>Jam praktik berubah menjadi pukul 10.00 - 13.00 mulai minggu depan.</small>
        </li>
      </ul>
    </div>
  </div>
</div>
@endsection
