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
    PendaftaranOfflineController,
    JanjiTemuOfflineController,
    HomeController 
};

// Public Routes
Route::get('/', fn() => view('home'));
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'auth'])->name('auth');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register-proses', [AuthController::class, 'register_proses'])->name('register-proses');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/pasiencall', fn() => view('pasiencall'));
Route::get('/', [HomeController::class, 'index']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


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
 Route::resource('profile', PasienController::class);

    // Keluarga
    //rute search keluarga
    Route::get('/keluarga/list', [KeluargaController::class, 'index'])->name('keluarga.index');

    Route::get('/keluarga/{id?}', [KeluargaController::class, 'show'])->name('keluarga.show');    
    Route::post('/keluarga', [KeluargaController::class, 'store'])->name('keluarga.store');
    Route::put('/keluarga', [KeluargaController::class, 'update'])->name('keluarga.update');
    Route::delete('/keluarga/{id}', [KeluargaController::class, 'destroy'])->name('keluarga.destroy');
    //Pendaftaran Offline
    Route::get('/pendaftaran-offline', [PendaftaranOfflineController::class, 'create'])->name('pendaftaran_offline.create');
    Route::post('/pendaftaran-offline', [PendaftaranOfflineController::class, 'store'])->name('pendaftaran_offline.store');
    Route::get('/api/anggota-keluarga/{no_kk}', function ($no_kk) {
    $keluarga = \App\Models\Keluarga::where('no_kk', $no_kk)->first();
    Route::get('/api/jam-terpakai/{tanggal}/{poli_id}', [App\Http\Controllers\JanjiTemuOfflineController::class, 'jamTerpakai']);
        

    if (!$keluarga) {
        return response()->json([], 404);
    }

    return response()->json($keluarga->detailKeluargas()->get(['id', 'nama']));
});
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
    
    //daftar janji temu offline
    Route::get('/admin/janji-temu-offline', [JanjiTemuOfflineController::class, 'index'])->name('admin.janji_temu_offline.index');
    Route::post('/admin/janji-temu-offline/{id}/selesai', [JanjiTemuOfflineController::class, 'markAsSelesai'])->name('janji_temu_offline.selesai');
    Route::post('/admin/janji-temu-offline/{id}/batal', [JanjiTemuOfflineController::class, 'batal'])->name('janji_temu_offline.batal');
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
    Route::get('/admin/poli', [PoliController::class, 'index'])->name('admin.poli.index');
Route::get('/admin/daftar-janji-temu-offline', [JanjiTemuOfflineController::class, 'index'])->name('admin.janji.offline.index');

});

// DOKTER Routes
Route::middleware(['auth', 'role:DOKTER'])->group(function () {
    Route::get('/dokter/janji-temu', [JanjiTemuController::class, 'index'])->name('dokter.janji-temu.index');
    Route::get('/dokter/keluarga', [KeluargaController::class, 'show'])->name('dokter.keluarga.show');
    Route::get('/dokter/poli', [PoliController::class, 'index'])->name('dokter.poli.index');
    Route::get('/dokter/pengumuman', [PengumumanController::class, 'index'])->name('dokter.pengumuman.index');
});

//USER MANAJEMEN
    Route::middleware(['auth', 'role:ADMIN'])->group(function () {
    Route::get('/admin/user-manajemen', [\App\Http\Controllers\UserManajemenController::class, 'create'])->name('admin.usermanajemen');
    Route::post('/admin/user-manajemen', [\App\Http\Controllers\UserManajemenController::class, 'store'])->name('admin.usermanajemen.store');
    });


//route janjitemuoffline controller
route::get('/janji-temu-offline', [JanjiTemuOfflineController::class, 'index'])->name('janji_temu_offline.index');
Route::post('/janji-temu-offline/{id}/panggil', [JanjiTemuOfflineController::class, 'panggil'])->name('janji_temu_offline.panggil');
Route::post('/janji-temu-offline/{id}/selesai', [JanjiTemuOfflineController::class, 'selesai'])->name('janji_temu_offline.selesai');
Route::post('/janji-temu-offline/{id}/batal', [JanjiTemuOfflineController::class, 'batal'])->name('janji_temu_offline.batal');
