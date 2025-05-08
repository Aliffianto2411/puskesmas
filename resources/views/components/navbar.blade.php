<nav class="navbar navbar-expand-lg navbar-light fixed-top custom-navbar" style="background-color: rgba(245, 245, 245, 0.8); backdrop-filter: blur(6px); z-index: 1030;">
  <div class="container-fluid">
    <a class="navbar-brand text-success fw-bold" href="#">
      <img src="{{ asset('asset/logopuskesmas.png') }}" alt="Logo" height="40">
      PUSKESMAS MERAL
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
    <ul class="navbar-nav">
    {{-- Beranda --}}
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/') }}">Beranda</a>
    </li>

    {{-- Tentang Kami (section di homepage) --}}
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/#tentang-kami') }}">Tentang Kami</a>
    </li>

    {{-- Pelayanan (section di homepage) --}}
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/#layanan') }}">Pelayanan</a>
    </li>

    {{-- Antrian (halaman terpisah) --}}
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/antrian') }}">Antrian</a>
    </li>
</ul>

    </div>

    <div class="d-flex">
      <a href="/login" class="btn btn-success">Registrasi Janji Temu</a>
    </div>
  </div>
</nav>
