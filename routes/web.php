<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    PoliController,
    PasienController,
    AnggotaController,
    KeluargaController,
    JanjiTemuController,
    PengumumanController,
    PendaftaranController,
    AdminDashboardController,
    DetailKeluargaController,
    RiwayatAntrianController,
    PendaftaranOfflineController
};

// Public Routes
Route::get('/', fn() => view('home'));
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'auth'])->name('auth');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register-proses', [AuthController::class, 'register_proses'])->name('register-proses');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/pasiencall', fn() => view('pasiencall'));

// USER Routes
Route::middleware(['auth', 'role:USER|ADMIN'])->group(function () {
    // Janji Temu
    Route::get('/appointment', [JanjiTemuController::class, 'index'])->name('appointment.index');
    Route::post('/appointment', [JanjiTemuController::class, 'store'])->name('appointment.store');
    Route::post('/janji-temu', [JanjiTemuController::class, 'store'])->name('janji-temu.store');
    Route::post('/appointment/checkin/{id}', [JanjiTemuController::class, 'checkin'])->name('appointment.checkin');
    Route::post('/appointment/cancel/{id}', [JanjiTemuController::class, 'cancel'])->name('appointment.cancel');
    Route::get('/appointment/invoice/{id}', [JanjiTemuController::class, 'invoice'])->name('appointment.invoice');
    Route::get('/appointments/{poli}/{tanggal}', [JanjiTemuController::class, 'getTakenSlots']);

    // Riwayat
    Route::get('/riwayat', [RiwayatAntrianController::class, 'index'])->name('riwayat.index');

    // Profile
    Route::get('/profile', [PasienController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit/{id}', [PasienController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/{pasien}', [PasienController::class, 'update'])->name('profile.update');

    // Keluarga
    //rute search keluarga
    Route::get('/keluarga/list', [KeluargaController::class, 'index'])->name('keluarga.index');

Route::get('/keluarga/{id?}', [KeluargaController::class, 'show'])->name('keluarga.show');    
Route::post('/keluarga', [KeluargaController::class, 'store'])->name('keluarga.store');
    Route::put('/keluarga', [KeluargaController::class, 'update'])->name('keluarga.update');
    Route::delete('/keluarga/{id}', [KeluargaController::class, 'destroy'])->name('keluarga.destroy');

    // Anggota Keluarga
    Route::post('/anggota', [AnggotaController::class, 'store'])->name('anggota.store');
    Route::get('/anggota/{anggota}/edit', [AnggotaController::class, 'edit'])->name('anggota.edit');
    Route::put('/anggota/{anggota}', [AnggotaController::class, 'update'])->name('anggota.update');
    Route::delete('/anggota/{anggota}', [AnggotaController::class, 'destroy'])->name('anggota.destroy');

    // Pengumuman
    Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
    Route::get('/pengumuman/{id}', [PengumumanController::class, 'show'])->name('pengumuman.show');
    Route::get('/pengumuman/create', [PengumumanController::class, 'create'])->name('pengumuman.create');
    Route::post('/pengumuman', [PengumumanController::class, 'store'])->name('pengumuman.store');
    Route::get('/pengumuman/{id}/edit', [PengumumanController::class, 'edit'])->name('pengumuman.edit');
    Route::put('/pengumuman/{id}', [PengumumanController::class, 'update'])->name('pengumuman.update');
    Route::delete('/pengumuman/{id}', [PengumumanController::class, 'destroy'])->name('pengumuman.destroy');

    // Pendaftaran
    Route::get('/pendaftaran', [PendaftaranController::class, 'index'])->name('pendaftaran');
    Route::get('/pendaftaran-offline', [PendaftaranOfflineController::class, 'create'])->name('pendaftaran_offline.create');
    Route::post('/pendaftaran-offline', [PendaftaranOfflineController::class, 'store'])->name('pendaftaran_offline.store');

    // Poli
    Route::resource('poli', PoliController::class);
});

// ADMIN Routes
Route::middleware(['auth', 'role:ADMIN'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    
    Route::resource('poli', PoliController::class);
    Route::resource('pengumuman', PengumumanController::class);
});

// DOKTER Routes
Route::middleware(['auth', 'role:DOKTER'])->group(function () {
    Route::get('/dokter/janji-temu', [JanjiTemuController::class, 'index'])->name('dokter.janji-temu.index');
    Route::get('/dokter/keluarga', [KeluargaController::class, 'show'])->name('dokter.keluarga.show');
    Route::get('/dokter/poli', [PoliController::class, 'index'])->name('dokter.poli.index');
    Route::get('/dokter/pengumuman', [PengumumanController::class, 'index'])->name('dokter.pengumuman.index');
});
