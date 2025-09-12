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
    HomeController,
    UserManajemenController
};

// ======================
// Public Routes
// ======================
Route::get('/', [HomeController::class, 'index']);
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'auth'])->name('auth');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register-proses', [AuthController::class, 'register_proses'])->name('register-proses');
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/pasiencall', fn() => view('pasiencall'));


// ======================
// USER Routes (USER & ADMIN)
// ======================
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
    Route::get('/keluarga/list', [KeluargaController::class, 'index'])->name('keluarga.index');
    Route::get('/keluarga/{id?}', [KeluargaController::class, 'show'])->name('keluarga.show');
    Route::post('/keluarga', [KeluargaController::class, 'store'])->name('keluarga.store');
    Route::put('/keluarga', [KeluargaController::class, 'update'])->name('keluarga.update');
    Route::delete('/keluarga/{id}', [KeluargaController::class, 'destroy'])->name('keluarga.destroy');

    // API Keluarga
    Route::get('/api/anggota-keluarga/{no_kk}', function ($no_kk) {
        $keluarga = \App\Models\Keluarga::where('no_kk', $no_kk)->first();
        if (!$keluarga) {
            return response()->json([], 404);
        }
        return response()->json($keluarga->detailKeluargas()->get(['id', 'nama']));
    });

    Route::get('/api/jam-terpakai/{tanggal}/{poli_id}', [JanjiTemuOfflineController::class, 'jamTerpakai']);

    // Pendaftaran Offline
    Route::get('/pendaftaran-offline', [PendaftaranOfflineController::class, 'create'])->name('pendaftaran_offline.create');
    Route::post('/pendaftaran-offline', [PendaftaranOfflineController::class, 'store'])->name('pendaftaran_offline.store');

    // Anggota Keluarga
    Route::post('/anggota', [AnggotaController::class, 'store'])->name('anggota.store');
    Route::get('/anggota/{anggota}/edit', [AnggotaController::class, 'edit'])->name('anggota.edit');
    Route::put('/anggota/{anggota}', [AnggotaController::class, 'update'])->name('anggota.update');
    Route::delete('/anggota/{anggota}', [AnggotaController::class, 'destroy'])->name('anggota.destroy');

    // Pengumuman
    Route::resource('pengumuman', PengumumanController::class);

    // Pendaftaran
    Route::get('/pendaftaran', [PendaftaranController::class, 'index'])->name('pendaftaran');

    // Poli
    Route::resource('poli', PoliController::class);
});


// ======================
// ADMIN Routes
// ======================
Route::middleware(['auth', 'role:ADMIN|DOKTER'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/poli', [PoliController::class, 'index'])->name('admin.poli.index');

    // Janji Temu Offline (ADMIN)
    Route::prefix('admin/janji-temu-offline')->name('admin.janji_temu_offline.')->group(function () {
        Route::get('/', [JanjiTemuOfflineController::class, 'index'])->name('index');
        Route::post('/{id}/selesai', [JanjiTemuOfflineController::class, 'selesai'])->name('selesai');
        Route::post('/{id}/batal', [JanjiTemuOfflineController::class, 'batal'])->name('batal');
        Route::post('/{id}/panggil', [JanjiTemuOfflineController::class, 'panggil'])->name('panggil');
    });
});


// ======================
// DOKTER Routes
// ======================
Route::middleware(['auth', 'role:DOKTER|ADMIN'])->group(function () {
    Route::get('/dokter/dashboard', [AdminDashboardController::class, 'index'])->name('dokter.dashboard');
    Route::get('/dokter/janji-temu', [JanjiTemuController::class, 'index'])->name('dokter.janji-temu.index');
    Route::get('/dokter/keluarga', [KeluargaController::class, 'show'])->name('dokter.keluarga.show');
    Route::get('/dokter/poli', [PoliController::class, 'index'])->name('dokter.poli.index');
    Route::get('/dokter/pengumuman', [PengumumanController::class, 'index'])->name('dokter.pengumuman.index');

    // Janji Temu Offline (DOKTER)
    Route::prefix('dokter/janji-temu-offline')->name('dokter.janji_temu_offline.')->group(function () {
        Route::get('/', [JanjiTemuOfflineController::class, 'index'])->name('index');
        Route::post('/{id}/selesai', [JanjiTemuOfflineController::class, 'selesai'])->name('selesai');
        Route::post('/{id}/batal', [JanjiTemuOfflineController::class, 'batal'])->name('batal');
        Route::post('/{id}/panggil', [JanjiTemuOfflineController::class, 'panggil'])->name('panggil');
    });
});


// ======================
// USER MANAJEMEN (ADMIN)
// ======================
Route::middleware(['auth', 'role:ADMIN'])->group(function () {
    Route::get('/admin/user-manajemen', [UserManajemenController::class, 'create'])->name('admin.usermanajemen');
    Route::post('/admin/user-manajemen', [UserManajemenController::class, 'store'])->name('admin.usermanajemen.store');
    // admin.janji.offline.index
    Route::get('/admin/user-manajemen/list', [UserManajemenController::class, 'index'])->name('admin.usermanajemen.index');
});
