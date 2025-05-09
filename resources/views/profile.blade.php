@extends('layouts.user')

@section('title', 'Dashboard - Puskesmas Meral')

@section('content')

<div class="container py-4">
  <h2 class="mb-4">Profil Anda</h2>

  <div class="card shadow-sm">
    <div class="card-body">
      <div class="row">
        <!-- Foto Profil -->
        <div class="col-md-4 text-center">
          <img src="https://via.placeholder.com/150" alt="Foto Profil" class="rounded-circle img-thumbnail mb-3">
          <button class="btn btn-primary btn-sm">Ubah Foto</button>
        </div>

        <!-- Informasi Profil -->
        <div class="col-md-8">
          <h5 class="card-title">Informasi Pribadi</h5>
          <table class="table table-borderless">
            <tr>
              <th>Nama</th>
              <td>{{ auth()->user()->name }}</td>
            </tr>
            <tr>
              <th>Email</th>
              <td>{{ auth()->user()->email }}</td>
            </tr>
            <tr>
              <th>Nomor Telepon</th>
              <td>081234567890</td> <!-- Ganti dengan data dinamis -->
            </tr>
            <tr>
              <th>Alamat</th>
              <td>Jl. Contoh Alamat No. 123</td> <!-- Ganti dengan data dinamis -->
            </tr>
          </table>
          <button class="btn btn-warning btn-sm">Edit Profil</button>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection