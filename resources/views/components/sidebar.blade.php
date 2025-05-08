<div class="d-flex flex-column flex-shrink-0 p-3  text-white" style="width: 250px; background-color: #0d6efd; height: 100vh;">
  <a href="{{ url('/') }}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
    <i class="bi bi-heart-pulse-fill me-2" style="font-size: 1.5rem;"></i>
    <span class="fs-4">Puskesmas</span>
  </a>
  <hr>
  <ul class="nav nav-pills flex-column mb-auto">
    <li><a href="{{ url('/pendaftaran') }}" class="nav-link text-white"><i class="bi bi-house me-2"></i> Beranda</a></li>
    <li><a href="{{ route('appoitment') }}" class="nav-link text-white"><i class="bi bi-calendar-check me-2"></i> Janji Temu</a></li>
    <li><a href="{{ url('/riwayat') }}" class="nav-link text-white"><i class="bi bi-clock-history me-2"></i> Riwayat</a></li>
    <li><a href="{{ url('/profile') }}" class="nav-link text-white"><i class="bi bi-person me-2"></i> Profil</a></li>
  </ul>
  <hr>
  <div class="dropdown">
    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
      <strong>User</strong>
    </a>
    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser">
      <li><a class="dropdown-item" href="{{ url('/user/profile') }}">Profil</a></li>
      <li><hr class="dropdown-divider"></li>
      <li><a class="dropdown-item" href="{{ url('/logout') }}">Logout</a></li>
    </ul>
  </div>
</div>
