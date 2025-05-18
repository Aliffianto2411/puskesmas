@extends('layouts.user')

@section('title', 'Dashboard - Puskesmas Meral')

@section('content')

   <div class="container py-4">
  <h2 class="mb-4">Profil Anda</h2>

  <div class="card shadow-sm">
    <div class="card-body">
      <div class="row">

        <!-- Informasi Profil -->
      <div class="col-md-8">
        <h5 class="card-title">Informasi Pribadi</h5>
      <table class="table table-borderless">
    <tbody>
        @foreach ($pasien as $pasien)
            <tr>
                <th>Nama</th>
                <td>{{ $pasien->nama ?? '-' }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $pasien->user->email ?? auth()->user()->email ?? '-' }}</td>
            </tr>
            <tr>
                <th>NIK</th>
                <td>{{ $pasien->nik ?? '-' }}</td>
            </tr>
            <tr>
                <th>Jenis Kelamin</th>
                <td>{{ $pasien->jenis_kelamin ?? '-' }}</td>
            </tr>
            <tr>
                <th>Tanggal Lahir</th>
                <td>{{ $pasien->tanggal_lahir ?? '-' }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>{{ $pasien->alamat ?? '-' }}</td>
            </tr>
            <tr>
                <th>No. HP</th>
                <td>{{ $pasien->no_hp ?? '-' }}</td>
            </tr>
            <tr>
                <th>Golongan Darah</th>
                <td>{{ $pasien->golongan_darah ?? '-' }}</td>
            </tr>
            @break   {{-- tampilkan hanya 1 pasien; hapus baris ini jika ingin menampilkan semua --}}
        @endforeach
    </tbody>
</table>

        <a href="{{ route('profile.edit', $pasien->id) }}" class="btn btn-warning btn-sm">Edit Profil</a>
      </div>
      </div>
    </div>
  </div>
</div>

@endsection