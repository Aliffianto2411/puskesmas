@extends('layouts.user')

@section('title', 'Dashboard - Puskesmas Meral')

@section('content')
<div class="container py-4">
  <h2 class="mb-4">Selamat Datang, {{ auth()->user()->name }}</h2>

  <!-- Status Antrian Hari Ini -->
  <div class="card shadow-sm mb-4">
    <div class="card-body position-relative">
        <h5 class="card-title">Status Antrian Hari Ini</h5>
        <p class="mb-1">Poli: <strong>Umum</strong></p>
        <p class="mb-1">Nomor Antrian: <strong>045</strong></p>
        <p class="mb-1">Status: <span class="badge bg-info">Menunggu 5 pasien</span></p>
        <p class="mb-0">Estimasi Waktu: <strong>15 menit</strong></p>
        
        <!-- Tombol Cek In -->
        <button class="btn btn-primary position-absolute" style="bottom: 10px; right: 10px;">Cek In</button>
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
          <tr>
            <td>Umum</td>
            <td>dr. Fitriani</td>
            <td>08:00 - 12:00</td>
          </tr>
          <tr>
            <td>Gigi</td>
            <td>drg. Andika</td>
            <td>09:00 - 13:00</td>
          </tr>
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
          <tr>
            <td>07 Mei 2025</td>
            <td>Umum</td>
            <td>032</td>
            <td><span class="badge bg-success">Selesai</span></td>
          </tr>
          <tr>
            <td>05 Mei 2025</td>
            <td>Gigi</td>
            <td>019</td>
            <td><span class="badge bg-danger">Batal</span></td>
          </tr>
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
