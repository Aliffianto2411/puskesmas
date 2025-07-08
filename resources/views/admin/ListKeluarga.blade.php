@extends('layouts.user')

@section('content')
<div class="container py-4">
    <h2 class="mb-4"><i class="bi bi-people-fill"></i> Daftar Keluarga</h2>

    @if(auth()->user()->hasRole('ADMIN'))
    {{-- Form tambah KK --}}
    <form action="{{ route('keluarga.store') }}" method="POST" class="row g-2 mb-3">
        @csrf
        <div class="col-auto">
            <input type="text" name="no_kk" class="form-control" placeholder="Masukkan No KK (16 digit)" required>
        </div>
        <div class="col-auto">
            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
            <span class="form-control-plaintext">
                Kepala Keluarga: <strong>{{ auth()->user()->name }}</strong>
            </span>
        </div>
        <div class="col-auto">
            <button class="btn btn-success">Tambah KK</button>
        </div>
    </form>
@endif
    <!-- Search Bar -->
    <form method="GET" action="{{ route('keluarga.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Cari No KK atau Nama Kepala Keluarga..." value="{{ request('q') }}">
            <button class="btn btn-success" type="submit"><i class="bi bi-search"></i> Cari</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle shadow-sm">
            <thead class="table-success">
                <tr>
                    <th>No KK</th>
                    <th>Nama Kepala Keluarga</th>
                    <th>Anggota Keluarga</th>
                    <th style="width: 150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($keluargas as $keluarga)
                <tr>
                    <td class="fw-semibold">{{ $keluarga->no_kk }}</td>
                    <td>
                        <span class="badge bg-primary fs-6">
                            <i class="bi bi-person-badge me-1"></i>
                            {{ $keluarga->user->name ?? '-' }}
                        </span>
                    </td>
                    <td>
                        @if($keluarga->anggota->count())
                        <div class="row row-cols-1 row-cols-md-2 g-2">
                            @foreach($keluarga->anggota as $anggota)
                            <div class="col">
                                <div class="card border-0 shadow-sm mb-2">
                                    <div class="card-body py-2 px-3">
                                        <h6 class="mb-1 text-success">
                                            <i class="bi bi-person-circle me-1"></i>
                                            {{ $anggota->nama }}
                                        </h6>
                                        <ul class="list-unstyled mb-0 small">
                                            <li><i class="bi bi-credit-card-2-front me-1"></i> NIK: <span class="text-dark">{{ $anggota->nik }}</span></li>
                                            <li><i class="bi bi-gender-ambiguous me-1"></i> Jenis Kelamin: <span class="text-dark">{{ $anggota->jenis_kelamin }}</span></li>
                                            <li><i class="bi bi-calendar-event me-1"></i> Tanggal Lahir: <span class="text-dark">{{ \Carbon\Carbon::parse($anggota->tanggal_lahir)->translatedFormat('d F Y') }}</span></li>
                                            <li><i class="bi bi-geo-alt me-1"></i> Alamat: <span class="text-dark">{{ $anggota->alamat }}</span></li>
                                            <li><i class="bi bi-droplet-half me-1"></i> Golongan Darah: <span class="text-dark">{{ $anggota->golongan_darah }}</span></li>
                                        </ul>
                                        <button type="button" class="btn btn-outline-primary btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#modalAnggota{{ $anggota->id }}">
                                            <i class="bi bi-eye"></i> Detail
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Detail Anggota -->
                            <div class="modal fade" id="modalAnggota{{ $anggota->id }}" tabindex="-1" aria-labelledby="modalAnggotaLabel{{ $anggota->id }}" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="modalAnggotaLabel{{ $anggota->id }}">Detail Anggota: {{ $anggota->nama }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    <ul class="list-group list-group-flush">
                                      <li class="list-group-item"><strong>NIK:</strong> {{ $anggota->nik }}</li>
                                      <li class="list-group-item"><strong>Jenis Kelamin:</strong> {{ $anggota->jenis_kelamin }}</li>
                                      <li class="list-group-item"><strong>Tanggal Lahir:</strong> {{ \Carbon\Carbon::parse($anggota->tanggal_lahir)->translatedFormat('d F Y') }}</li>
                                      <li class="list-group-item"><strong>Alamat:</strong> {{ $anggota->alamat }}</li>
                                      <li class="list-group-item"><strong>Golongan Darah:</strong> {{ $anggota->golongan_darah }}</li>
                                    </ul>
                                  </div>
                                </div>
                              </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <span class="text-muted fst-italic">Tidak ada anggota.</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('keluarga.show', $keluarga->id) }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-info-circle"></i> Info
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">Data keluarga belum tersedia.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection