@extends('layouts.user')

@section('title', 'Profil Anda - Puskesmas Meral')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Profil Anda</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $pasien->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $pasien->user->email ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>NIK</th>
                        <td>{{ $pasien->nik ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>No KK</th>
                        <td>{{ $pasien->user->keluarga->no_kk ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Kelamin</th>
                        <td>{{ $pasien->jenis_kelamin ?? '-' }}</td>
                    </tr>
                   <tr>
    <th>Tanggal Lahir</th>
    <td>
        @if($pasien && $pasien->tanggal_lahir)
            {{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->translatedFormat('d M Y') }}
        @else
            -
        @endif
    </td>
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
                </tbody>
            </table>

            @if($pasien)
                <a href="{{ route('profile.edit', $pasien->id) }}" class="btn btn-warning btn-sm mt-2">
                    Edit Profil
                </a>
            @endif
            </a>
        </div>
    </div>
</div>
@endsection
