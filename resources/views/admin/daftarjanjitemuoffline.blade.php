@extends('layouts.user')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Daftar Janji Temu</h2>

    {{-- STEP 1: Pilihan Poli --}}
    @if(!$poliDipilih)
        <div class="row">
            @foreach($polis as $poli)
                <div class="col-md-4 mb-4">
                    <a href="{{ route('admin.janji_temu_offline.index', ['poli' => $poli->id]) }}" class="text-decoration-none">
                        <div class="card shadow h-100">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $poli->nama_poli }}</h5>
                                <i class="bi bi-hospital fs-1 text-primary"></i>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @else
        {{-- STEP 2: Filter dan Data Janji Temu --}}
        <form method="GET" class="row g-2 mb-4">
            <input type="hidden" name="poli" value="{{ $poliDipilih }}">
            <div class="col-md-3">
                <input type="date" name="tanggal" class="form-control" value="{{ $tanggal }}">
            </div>
            <div class="col-md-4">
                <input type="text" name="nama" class="form-control" placeholder="Cari Nama Pasien" value="{{ $nama }}">
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100" type="submit">Filter</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('admin.janji_temu_offline.index') }}" class="btn btn-secondary w-100">Pilih Poli Lain</a>
            </div>
        </form>

        <div class="row">
            {{-- ONLINE --}}
            <div class="col-md-6">
                <h4>Janji Temu Online</h4>
                @if($janjiTemuOnline->count())
                    @foreach($janjiTemuOnline as $tanggalJanji => $items)
                        <h5 class="mt-3">{{ \Carbon\Carbon::parse($tanggalJanji)->translatedFormat('l, d F Y') }}</h5>
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pasien</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $i => $item)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $item->detailKeluarga->nama ?? '-' }}</td>
                                    <td><span class="badge bg-{{ $item->status == 'Menunggu' ? 'warning' : ($item->status == 'Diproses' ? 'info' : 'success') }}">{{ $item->status }}</span></td>
                                    <td>
                                        @if($item->status == 'Menunggu')
                                            <form action="{{ route('janji_temu_offline.panggil', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button class="btn btn-sm btn-primary">Panggil</button>
                                            </form>
                                            <form action="{{ route('janji_temu_offline.batal', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin membatalkan?')">
                                                @csrf
                                                <button class="btn btn-sm btn-danger">Batal</button>
                                            </form>
                                        @elseif($item->status == 'Diproses')
                                            <form action="{{ route('janji_temu_offline.selesai', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button class="btn btn-sm btn-success">Selesai</button>
                                            </form>
                                            <form action="{{ route('janji_temu_offline.batal', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin membatalkan?')">
                                                @csrf
                                                <button class="btn btn-sm btn-danger">Batal</button>
                                            </form>
                                        @else
                                            <em>Selesai / Batal</em>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endforeach
                @else
                    <p class="text-muted">Tidak ada janji temu online.</p>
                @endif
            </div>

            {{-- OFFLINE --}}
            <div class="col-md-6">
                <h4>Janji Temu Offline</h4>
                @if($janjiTemuOffline->count())
                    @foreach($janjiTemuOffline as $tanggalJanji => $items)
                        <h5 class="mt-3">{{ \Carbon\Carbon::parse($tanggalJanji)->translatedFormat('l, d F Y') }}</h5>
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pasien</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $i => $item)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $item->detailKeluarga->nama ?? '-' }}</td>
                                    <td><span class="badge bg-{{ $item->status == 'Menunggu' ? 'warning' : ($item->status == 'Diproses' ? 'info' : 'success') }}">{{ $item->status }}</span></td>
                                    <td>
                                        @if($item->status == 'Menunggu')
                                            <form action="{{ route('janji_temu_offline.panggil', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button class="btn btn-sm btn-primary">Panggil</button>
                                            </form>
                                            <form action="{{ route('janji_temu_offline.batal', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin membatalkan?')">
                                                @csrf
                                                <button class="btn btn-sm btn-danger">Batal</button>
                                            </form>
                                        @elseif($item->status == 'Diproses')
                                            <form action="{{ route('janji_temu_offline.selesai', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button class="btn btn-sm btn-success">Selesai</button>
                                            </form>
                                            <form action="{{ route('janji_temu_offline.batal', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin membatalkan?')">
                                                @csrf
                                                <button class="btn btn-sm btn-danger">Batal</button>
                                            </form>
                                        @else
                                            <em>Selesai / Batal</em>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endforeach
                @else
                    <p class="text-muted">Tidak ada janji temu offline.</p>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection
