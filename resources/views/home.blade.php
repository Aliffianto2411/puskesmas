@extends('layouts.app')   

@section('title', 'Beranda Puskesmas Meral')

@section('content')
<section class="hero-section text-white d-flex align-items-center" style="background: linear-gradient(to right,rgb(28, 248, 102),rgb(5, 238, 180)); height: 100vh;">
  <div class="container-fluid">
    <div class="row align-items-center">
      <!-- Kiri: Teks -->
      <div class="col-md-6 px-5">
        <h1 class="display-4 fw-bold">Selamat Datang di Puskesmas Meral</h1>
        <p class="lead">Menjadi  Puskemas yang unggul untuk Mewujudkan Masyarakat sehat  yang Mandiri dan Berkeadilan</p>
        <a href="{{ url('/login') }}" class="btn btn-light btn-lg text-success">
         Buat Janji Temu
        </a>
      </div>
      <!-- Kanan: Gambar -->
      <div class="col-md-6 text-center px-5 mt-5">
        <img src="{{ asset('asset/nurse.png') }}" alt="Foto Puskesmas" style="margin-top: 90px; ">
      </div>
    </div>
  </div>
</section>


{{-- Seksi ringkas “Keunggulan Kami” --}}
<section class="py-5" style="background-color: rgb(241, 241, 241);">
  <div class="container">
    <div class="row text-center justify-content-center">
      <div class="col-md-4 mb-4">
        <div class="p-4 bg-white rounded shadow-lg position-relative">
          <div class="icon-circle bg-primary text-white position-absolute top-0 start-50 translate-middle rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
            <i class="bi bi-heart-pulse fs-4"></i>
          </div>
          <h5 class="mt-5">Pelayanan Prima</h5>
          <p>Dokter dan perawat berpengalaman siap membantu kebutuhan medis Anda.</p>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="p-4 bg-white rounded shadow-lg position-relative">
          <div class="icon-circle bg-primary text-white position-absolute top-0 start-50 translate-middle rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
            <i class="bi bi-people-fill fs-4"></i>
          </div>
          <h5 class="mt-5">Fasilitas Lengkap</h5>
          <p>Laboratorium, farmasi, dan ruang observasi berperalatan modern.</p>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="p-4 bg-white rounded shadow-lg position-relative">
          <div class="icon-circle bg-primary text-white position-absolute top-0 start-50 translate-middle rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
            <i class="bi bi-clock-fill fs-4"></i>
          </div>
          <h5 class="mt-5">Jam Layanan</h5>
          <p>Sen–Jum 08.00–14.00 WIB &amp; Sab 08.00–12.00 WIB.</p>
        </div>
      </div>
    </div>
  </div>
</section>

  <section class="py-5 bg-light" id="tentang-kami" style="padding-top: 100px;">
  <div class="container">
    <div class="container">
    <div class="text-center mb-5">
      <h2 class="fw-bold text-success">Tentang Kami</h2>
      <p class="text-muted">Mengenal lebih dekat Puskesmas Meral</p>
    </div>

    <!-- Deskripsi Singkat -->
    <div class="row mb-4">
      <div class="col">
        <p class="lead text-center">
          Puskesmas Meral adalah pusat pelayanan kesehatan masyarakat yang berkomitmen untuk memberikan pelayanan terbaik, cepat, dan ramah kepada seluruh lapisan masyarakat. Dengan tenaga medis profesional dan fasilitas yang memadai, kami hadir sebagai mitra kesehatan Anda.
        </p>
      </div>
    </div>

    <!-- Visi & Misi -->
    <div class="row">
  <div class="col-md-6 mb-4">
    <div class="p-4 text-white shadow rounded h-100" style="background: linear-gradient(135deg, #4caf50, #00bcd4);">
      <h4 class="fw-semibold">Visi</h4>
      <p>
        Menjadi Puskesmas unggulan dalam pelayanan kesehatan yang profesional, humanis, dan berorientasi pada kebutuhan masyarakat.
      </p>
    </div>
  </div>
  <div class="col-md-6 mb-4">
    <div class="p-4 text-white shadow rounded h-100" style="background: linear-gradient(135deg, #4caf50, #00bcd4);">
      <h4 class="fw-semibold">Misi</h4>
      <ul>
        <li>Menyediakan pelayanan kesehatan yang terjangkau dan berkualitas.</li>
        <li>Meningkatkan kesadaran masyarakat terhadap hidup sehat.</li>
        <li>Memberdayakan masyarakat dalam menjaga kesehatan secara mandiri.</li>
        <li>Meningkatkan mutu pelayanan melalui pengembangan SDM dan teknologi.</li>
      </ul>
    </div>
  </div>
</div>
  </div>
</section>

<section id="layanan" class="py-5">
<div class="container text-center">
    <h2 class="fw-bold mb-3">Layanan Kesehatan</h2>
    <p class="text-muted mb-5">Berbagai layanan kesehatan yang tersedia di Puskesmas Meral</p>
    <div class="row g-8">
      <!-- Layanan 1 -->
      <div class="col-md-4">
        <div class="service-box p-4 border rounded-3 h-100">
          <div class="icon mb-3">
            <i class="bi bi-heart-pulse-fill fs-1 text-primary"></i>
          </div>
          <h5 class="fw-semibold">Pemeriksaan Umum</h5>
          <p>Pelayanan medis dasar oleh dokter umum untuk semua usia dan kondisi.</p>
        </div>
      </div>
      <!-- Layanan 2 -->
      <div class="col-md-4">
        <div class="service-box p-4 border rounded-3 h-100">
          <div class="icon mb-3">
            <i class="bi bi-eyedropper fs-1 text-primary"></i>
          </div>
          <h5 class="fw-semibold">Laboratorium</h5>
          <p>Pemeriksaan darah, urin, dan sampel lainnya untuk diagnosis lebih akurat.</p>
        </div>
      </div>
      <!-- Layanan 3 -->
      <div class="col-md-4">
        <div class="service-box p-4 border rounded-3 h-100">
          <div class="icon mb-3">
            <i class="bi bi-capsule-pill fs-1 text-primary"></i>
          </div>
          <h5 class="fw-semibold">Apotek</h5>
          <p>Penyediaan obat-obatan yang aman dan berkualitas sesuai resep dokter.</p>
        </div>
      </div>
      <!-- Layanan 4 -->
      <div class="col-md-4">
        <div class="service-box p-4 border rounded-3 h-100">
          <div class="icon mb-3">
            <i class="bi bi-hospital fs-1 text-primary"></i>
          </div>
          <h5 class="fw-semibold">Kesehatan Ibu & Anak</h5>
          <p>Layanan antenatal, imunisasi bayi, tumbuh kembang, dan KB.</p>
        </div>
      </div>
      <!-- Layanan 5 -->
      <div class="col-md-4">
        <div class="service-box p-4 border rounded-3 h-100">
          <div class="icon mb-3">
            <i class="bi bi-thermometer-sun fs-1 text-primary"></i>
          </div>
          <h5 class="fw-semibold">Pemeriksaan Gizi</h5>
          <p>Konsultasi gizi dan pemantauan status nutrisi untuk semua usia.</p>
        </div>
      </div>
      <!-- Layanan 6 -->
      <div class="col-md-4">
        <div class="service-box p-4 border rounded-3 h-100">
          <div class="icon mb-3">
            <i class="bi bi-shield-check fs-1 text-primary"></i>
          </div>
          <h5 class="fw-semibold">Pencegahan Penyakit</h5>
          <p>Program edukasi, skrining, dan imunisasi untuk menjaga kesehatan masyarakat.</p>
        </div>
      </div>
            <!-- Layanan 7: Kesehatan Gigi dan Mulut -->
      <div class="col-md-4 mb-4">
        <div class="service-box p-4 border rounded-3 h-100">
          <div class="icon mb-3">
            <i class="bi bi-emoji-smile fs-1 text-primary"></i>
          </div>
          <h5 class="fw-semibold">Kesehatan Gigi dan Mulut</h5>
          <p>Pelayanan pemeriksaan, pembersihan, dan edukasi kesehatan gigi dan mulut.</p>
        </div>
      </div>

      <!-- Layanan 9: Tindakan & Gawat Darurat -->
      <div class="col-md-4 mb-4">
        <div class="service-box p-4 border rounded-3 h-100">
          <div class="icon mb-3">
            <i class="bi bi-hospital fs-1 text-primary"></i>
          </div>
          <h5 class="fw-semibold">Tindakan & Gawat Darurat</h5>
          <p>Pelayanan cepat untuk penanganan kasus darurat medis dan tindakan penyelamatan jiwa.</p>
        </div>
      </div>
      
    </div>
  </div>
  <section class="py-5" id="pengumuman">
  <div class="container">
    <div class="text-center mb-4">
      <h2 class="fw-bold text-success">Pengumuman</h2>
      <p class="text-muted">Informasi terbaru dari Puskesmas Meral</p>
    </div>

    @if ($pengumuman->count() > 0)
      <div class="row justify-content-center">
        @foreach ($pengumuman as $item)
          <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
              <div class="card-body">
                <h5 class="card-title">{{ $item->judul }}</h5>
                <p class="card-text">{{ Str::limit(strip_tags($item->isi), 100, '...') }}</p>
                <p class="text-muted small mb-0">
                  {{ \Carbon\Carbon::parse($item->tanggal_pengumuman)->translatedFormat('d F Y') }}
                </p>
              </div>
            </div>
          </div>
          
        @endforeach
      </div>
    @else
      <p class="text-center">Belum ada pengumuman terbaru.</p>
    @endif
  </div>

  <footer class="bg-dark text-white py-4 mt-5">
  <div class="container text-center">
    <p class="mb-1">&copy; {{ date('Y') }} Puskesmas Meral. All rights reserved.</p>
    <p class="small mb-0">
      Jl. Pelabuhan Parit Rempak , Sei Raya, Meral, Kabupaten Karimun, Kepulauan Riau<br>
    </p>
  </div>
</footer>

</section>



<style>

.service-box {
  background-color: #ffffff;
  transition: background-color 0.3s ease, color 0.3s ease;
}
.service-box:hover {
  background: linear-gradient(to right, #28a745, #17a2b8);
  color: #ffffff;
}
.service-box:hover i,
.service-box:hover h5,
.service-box:hover p {
  color: #ffffff;
}
</style>
@endsection