<div class="d-flex flex-column flex-shrink-0 p-3 text-white" style="width: 250px;background-color: rgb(4, 103, 184); height: 100vh; position: fixed; top: 0; left: 0; z-index: 1030;">
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

<style>
  /* Sidebar styling */
  .nav-link {
    padding: 10px 15px;
    border-radius: 5px;
    transition: background-color 0.3s ease, color 0.3s ease;
  }

  .nav-link:hover {
    color: #ffffff; /* Warna teks tetap putih */
    background: linear-gradient(45deg, rgb(4, 103, 184), rgb(2, 222, 230))
  }

  .nav-link i {
    transition: color 0.3s ease;
  }

  .nav-link:hover i {
    color: #ffffff; /* Warna ikon tetap putih saat hover */
  }

  .dropdown-menu {
    background-color: #0d6efd;
  }

  .dropdown-menu .dropdown-item:hover {
    background: linear-gradient(45deg, rgb(4, 103, 184), rgb(2, 222, 230));
    color: #ffffff; /* Warna teks tetap putih */
  }

  /* Konten utama agar tidak tertimpa sidebar */
  .content {
    margin-left: 250px; /* Sesuaikan dengan lebar sidebar */
    padding: 20px; /* Opsional: Tambahkan padding untuk estetika */
  }

  /* Responsiveness */
  @media (max-width: 768px) {
    .d-flex.flex-column {
      position: absolute;
      transform: translateX(-100%);
      transition: transform 0.3s ease;
    }

    .d-flex.flex-column.show {
      transform: translateX(0);
    }

    .hamburger-menu {
      display: block;
      position: fixed;
      top: 10px;
      left: 10px;
      z-index: 1041;
      background-color: rgb(4, 103, 184);
      border: none;
      padding: 10px;
      border-radius: 5px;
      cursor: pointer;
    }

    .hamburger-menu span {
      display: block;
      width: 25px;
      height: 3px;
      margin: 5px auto;
      background-color: #fff;
    }

    .content {
      margin-left: 0;
    }
  }

  @media (min-width: 769px) {
    .hamburger-menu {
      display: none;
    }
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.querySelector('.d-flex.flex-column');
    const hamburgerMenu = document.querySelector('.hamburger-menu');

    hamburgerMenu.addEventListener('click', function () {
      sidebar.classList.toggle('show');
    });
  });
</script>

<button class="hamburger-menu">
  <span></span>
  <span></span>
  <span></span>
</button>