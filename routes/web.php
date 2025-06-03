<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PoliController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\KeluargaController;
// Ensure the controller exists at app/Http/Controllers/DetailKeluargaController.php
use App\Http\Controllers\JanjiTemuController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\DetailKeluargaController;
use App\Http\Controllers\RiwayatAntrianController;
use App\Models\Pengumuman;

Route::get('/', function () {
    return view('home'); 
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'auth'])->name('auth');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register-proses', [AuthController::class, 'register_proses'])->name('register-proses');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');



route::get('/pasiencall', function () {
    return view('pasiencall');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/appointment', [JanjiTemuController::class, 'index'])->name('appointment.index');
    Route::post('/appointment', [JanjiTemuController::class, 'store'])->name('appointment.store');

    // API route
    Route::get('/appointments/{poli}/{tanggal}', [JanjiTemuController::class, 'getTakenSlots']);
    Route::get('/pendaftaran', function () { return view('pendaftaran');});


    //profile
    Route::get('/profile', [PasienController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit/{id}', [PasienController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/{pasien}',[PasienController::class, 'update'])->name('profile.update');

    // Keluarga

    /* ---- KARTU KELUARGA (1 user : 1 KK) ---- */

    Route::get('/keluarga',[KeluargaController::class, 'show'])->name('keluarga.show');

    Route::post('/keluarga',[KeluargaController::class, 'store'])->name('keluarga.store');

    Route::put('/keluarga',[KeluargaController::class, 'update'])->name('keluarga.update');


    //amggota keluarga
    Route::post('/anggota',[AnggotaController::class, 'store'])->name('anggota.store');

    Route::get('/anggota/{anggota}/edit',[AnggotaController::class, 'edit'])->name('anggota.edit');

    Route::put('/anggota/{anggota}',[AnggotaController::class, 'update'])->name('anggota.update');

    Route::delete('/anggota/{anggota}',  [AnggotaController::class, 'destroy'])->name('anggota.destroy');

     Route::post('/janji-temu', [JanjiTemuController::class, 'store'])->name('janji-temu.store');

     // riwayat
    Route::get('/riwayat', [RiwayatAntrianController::class, 'index'])->name('riwayat.index');
    
    Route::post('/appointment/checkin/{id}', [JanjiTemuController::class, 'checkin'])->name('appointment.checkin');
    Route::post('/appointment/cancel/{id}', [JanjiTemuController::class, 'cancel'])->name('appointment.cancel');

    Route::get('/appointment/invoice/{id}', [JanjiTemuController::class, 'invoice'])->name('appointment.invoice');

    
    Route::get('/pendaftaran', [PendaftaranController::class, 'index'])->name('pendaftaran');

    Route::resource('poli', PoliController::class);

    Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
    Route::get('/pengumuman/{id}', [PengumumanController::class, 'show'])->name('pengumuman.show');
    Route::post('/pengumuman', [PengumumanController::class, 'store'])->name('pengumuman.store');
    Route::get('/pengumuman/create', [PengumumanController::class, 'create'])->name('pengumuman.create');
    Route::get('/pengumuman/{id}/edit', [PengumumanController::class, 'edit'])->name('pengumuman.edit');
    Route::put('/pengumuman/{id}', [PengumumanController::class, 'update'])->name('pengumuman.update');
    Route::delete('/pengumuman/{id}', [PengumumanController::class, 'destroy'])->name('pengumuman.destroy');

});

