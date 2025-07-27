@extends('layouts.app')

@section('title', 'Login - Puskesmas Meral')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh; padding-top: 70px;">
  <div class="card shadow p-4" style="width: 100%; max-width: 450px;">
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('failed'))
      <div class="alert alert-danger">{{ session('failed') }}</div>
    @endif

    @if($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <ul class="nav nav-pills nav-justified mb-3" id="authTabs" role="tablist">
      <li class="nav-item" role="presentation">
        <a class="nav-link active" id="login-tab" data-bs-toggle="pill" href="#login" role="tab">Masuk</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" id="register-tab" data-bs-toggle="pill" href="#register" role="tab">Daftar</a>
      </li>
    </ul>

    <div class="tab-content" id="authTabsContent">
      <!-- Login Form -->
      <div class="tab-pane fade show active" id="login" role="tabpanel">
        <form method="POST" action="{{ route('auth') }}">
          @csrf
          <div class="mb-4">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email" required />
          </div>

          <div class="mb-4">
            <label for="password" class="form-label">Kata Sandi</label>
            <input type="password" name="password" class="form-control" id="password" required />
          </div>

          <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember" />
              <label class="form-check-label" for="remember">Ingat Saya</label>
            </div>
            <a href="#">Lupa Sandi?</a>
          </div>

          <button type="submit" class="btn btn-primary w-100 mb-3">Masuk</button>
        </form>
      </div>

      <!-- Register Form -->
      <div class="tab-pane fade" id="register" role="tabpanel">
        <form method="POST" action="{{ route('register-proses') }}">
          @csrf
          <div class="mb-3">
        <label class="form-label" for="name">Nama Lengkap</label>
        <input type="text" name="nama" class="form-control" required />
          </div>

          <div class="mb-3">
              <label class="form-label" for="email">Email</label>
              <input type="email" name="email" class="form-control" required />
          </div>

          <div class="mb-3">
              <label class="form-label" for="no_kk">Nomor KK</label>
              <input type="text" name="no_kk" class="form-control" required />
          </div>

          <div class="mb-3">
              <label class="form-label" for="nik">NIK</label>
              <input type="text" name="nik" class="form-control" required />
          </div>

          <div class="mb-3">
              <label class="form-label" for="jenis_kelamin">Jenis Kelamin</label>
              <select name="jenis_kelamin" class="form-control" required>
                  <option value="">-- Pilih --</option>
                  <option value="Laki-laki">Laki-laki</option>
                  <option value="Perempuan">Perempuan</option>
              </select>
          </div>

          <div class="mb-3">
              <label class="form-label" for="tanggal_lahir">Tanggal Lahir</label>
              <input type="date" name="tanggal_lahir" class="form-control" required />
          </div>

          <div class="mb-3">
              <label class="form-label" for="alamat">Alamat</label>
              <input type="text" name="alamat" class="form-control" required />
          </div>

          <div class="mb-3">
              <label class="form-label" for="no_hp">No HP</label>
              <input type="text" name="no_hp" class="form-control" required />
          </div>

          <div class="mb-3">
              <label class="form-label" for="golongan_darah">Golongan Darah</label>
              <select name="golongan_darah" class="form-control">
                  <option value="">-- Pilih --</option>
                  <option value="A">A</option>
                  <option value="B">B</option>
                  <option value="AB">AB</option>
                  <option value="O">O</option>
              </select>
          </div>

          <div class="mb-3">
              <label class="form-label" for="password">Kata Sandi</label>
              <input type="password" name="password" class="form-control" required />
          </div>

          <div class="mb-3">
              <label class="form-label" for="password_confirmation">Konfirmasi Sandi</label>
              <input type="password" name="password_confirmation" class="form-control" required />
          </div>
          <button type="submit" class="btn btn-primary w-100 mb-3">Daftar</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
