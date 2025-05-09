@extends('layouts.user')

@section('title', 'Dashboard - Puskesmas Meral')

@section('content')

<div class="container py-4">
  <h2 class="mb-4">Riwayat Antrian</h2>

  <div class="card shadow-sm">
    <div class="card-body">
      <h5 class="card-title">Riwayat Antrian Anda</h5>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Poli</th>
            <th>Nomor Antrian</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>07 Mei 2025</td>
            <td>Umum</td>
            <td>045</td>
            <td><span class="badge bg-success">Selesai</span></td>
          </tr>
          <tr>
            <td>05 Mei 2025</td>
            <td>Gigi</td>
            <td>019</td>
            <td><span class="badge bg-danger">Batal</span></td>
          </tr>
          <tr>
            <td>03 Mei 2025</td>
            <td>Anak</td>
            <td>012</td>
            <td><span class="badge bg-warning text-dark">Menunggu</span></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection