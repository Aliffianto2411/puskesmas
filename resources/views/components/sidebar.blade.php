@auth
<div class="d-flex flex-column flex-shrink-0 p-3 text-white"
     style="width: 250px; background-color: rgb(4, 103, 184); height: 100vh; position: fixed; top: 0; left: 0; z-index: 1030;">
  <a href="#" class="d-flex align-items-center mb-3 text-white text-decoration-none">
    <i class="bi bi-heart-pulse-fill me-2" style="font-size: 1.5rem;"></i>
    <span class="fs-4">Puskesmas</span>
  </a>

  <hr>
  <ul class="nav nav-pills flex-column mb-auto">

    {{-- USER dan ADMIN dapat menu umum --}}
    @hasanyrole('USER')
    <li><a href="{{ route('pendaftaran') }}" class="nav-link text-white"><i class="bi bi-house me-2"></i> Beranda</a></li>
    <li><a href="{{ route('appointment.index') }}" class="nav-link text-white"><i class="bi bi-calendar-check me-2"></i> Janji Temu</a></li>
    <li><a href="{{ route('riwayat.index') }}" class="nav-link text-white"><i class="bi bi-clock-history me-2"></i> Riwayat</a></li>
    <li><a href="{{ route('profile.index') }}" class="nav-link text-white"><i class="bi bi-person me-2"></i> Profil</a></li>
    <li><a href="{{ route('keluarga.show') }}" class="nav-link text-white"><i class="bi bi-people-fill me-2"></i> Keluarga</a></li>
    <li><a href="{{ url('/antrian-poli') }}" class="nav-link text-white"><i class="bi bi-list-ol me-2"></i> Antrian Pendaftaran</a></li>
    @endhasanyrole

    {{-- ADMIN MENU --}}
    @role('ADMIN')
    <li class="mt-2 text-white fw-bold px-2">ADMIN PANEL</li>
    <li><a href="{{ route('admin.dashboard') }}" class="nav-link text-white"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
    <li><a href="{{ route('pengumuman.index') }}" class="nav-link text-white"><i class="bi bi-megaphone-fill me-2"></i> Pengumuman</a></li>
    <li><a href="{{ route('poli.index') }}" class="nav-link text-white"><i class="bi bi-hospital me-2"></i> Poli</a></li>
     <li><a href="{{ route('keluarga.index') }}" class="nav-link text-white"><i class="bi bi-people-fill me-2"></i> Keluarga</a></li>
    <li><a href="{{ route('pendaftaran_offline.create') }}" class="nav-link text-white"><i class="bi bi-person-plus-fill me-2"></i> Pendaftaran Offline</a></li>
    <li><a href="{{ route('poli.index') }}" class="nav-link text-white"><i class="bi bi-calendar-event me-2"></i> Jadwal</a></li>
    @endrole

    {{-- DOKTER MENU --}}
    @role('DOKTER')
    <li class="mt-2 text-white fw-bold px-2">DOKTER PANEL</li>
    <li><a href="{{ route('dokter.janji-temu.index') }}" class="nav-link text-white"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
    <li><a href="{{ route('dokter.keluarga.show') }}" class="nav-link text-white"><i class="bi bi-people-fill me-2"></i> Daftar Antrian</a></li>
    <li><a href="{{ route('dokter.poli.index') }}" class="nav-link text-white"><i class="bi bi-hospital me-2"></i> Riwayat Pasien</a></li>
    @endrole

  </ul>

  <hr>
  <div class="dropdown">
    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
       id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
      <strong>{{ auth()->user()->name }}</strong>
    </a>
    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser">
      <li><a class="dropdown-item" href="{{ route('profile.index') }}">Profil</a></li>
      <li><hr class="dropdown-divider"></li>
      <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
    </ul>
  </div>
</div>

<!-- Toggle Button (Hamburger) -->
<button class="hamburger-menu">
  <span></span>
  <span></span>
  <span></span>
</button>
@endauth
