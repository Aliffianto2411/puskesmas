<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JanjiTemuController;


Route::get('/', function () {
    return view('home'); 
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'auth'])->name('auth');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register-proses', [AuthController::class, 'register_proses'])->name('register-proses');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');



Route::get('/antrian', function () {
    return view('antrian');
});

Route::get('/pendaftaran', function () {
    return view('pendaftaran');
});

Route::get('/riwayat', function () {
    return view('riwayat');
});

route::get('/profile', function () {
    return view('profile');
});

route::get('/pasiencall', function () {
    return view('pasiencall');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/appointment', [JanjiTemuController::class, 'index'])->name('appointment.index');
    Route::post('/appointment', [JanjiTemuController::class, 'store'])->name('appointment.store');

    // API route
    Route::get('/appointments/{poli}/{tanggal}', [JanjiTemuController::class, 'getTakenSlots']);
});



Route::post('/janji-temu', [JanjiTemuController::class, 'store'])->name('janji-temu.store');


