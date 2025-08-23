<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Pasien;
use App\Models\Keluarga;
use App\Models\DetailKeluarga;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function auth(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->hasRole('ADMIN')) {
                return redirect()->route('admin.dashboard');
            }
            if ($user->hasRole('DOKTER')) {
                return redirect()->route('dokter.janji-temu.index');
            }
            if ($user->hasRole('USER')) {
                return redirect()->route('pendaftaran');
            }

            Auth::logout();
            return redirect()->route('login')->withErrors(['role' => 'Role tidak dikenali']);
        }

        return back()->withErrors([
            'loginError' => 'Email atau Password salah.'
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Kamu berhasil logout');
    }

    public function register()
    {
        return view('register');
    }

    public function register_proses(Request $request)
    {
        $request->validate([
            'nama'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email',
            'password'        => 'required|min:6|confirmed',
            'no_hp'           => 'required|string|max:15',
            'nik'             => 'required|string|max:16',
            'no_kk'           => 'required|string|max:20',
            'jenis_kelamin'   => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir'   => 'required|date',
            'alamat'          => 'required|string|max:255',
            'golongan_darah'  => 'required|in:A,B,AB,O',
        ]);

        // Cek NIK sudah terdaftar
        if (Pasien::where('nik', $request->nik)->exists()) {
            return back()->with('failed', 'Satu akun menjadi akun untuk satu keluarga, NIK Anda sudah terdaftar.');
        }

        // Cek KK sudah terdaftar
        if (Keluarga::where('no_kk', $request->no_kk)->exists()) {
            return back()->with('failed', 'Satu akun menjadi akun untuk satu keluarga, Nomor KK Anda sudah terdaftar.');
        }

        // Insert ke tabel users
        $user = User::create([
            'name'              => $request->nama,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'email_verified_at' => Carbon::now(),
        ]);
        $user->assignRole('USER');

        // Insert ke tabel keluargas
        $keluarga = Keluarga::create([
            'user_id' => $user->id,
            'no_kk'   => $request->no_kk,
        ]);

        // Insert ke tabel detail_keluargas
        DetailKeluarga::create([
            'keluarga_id'    => $keluarga->id,
            'nama'           => $request->nama,
            'nik'            => $request->nik,
            'jenis_kelamin'  => $request->jenis_kelamin,
            'tanggal_lahir'  => $request->tanggal_lahir,
            'alamat'         => $request->alamat,
            'golongan_darah' => $request->golongan_darah,
        ]);

        // Insert ke tabel pasiens (PERBAIKAN: MENAMBAHKAN user_id)
        Pasien::create([
            'user_id'         => User::latest()->first()->id,
            'nama'            => $request->nama,
            'nik'             => $request->nik,
            'jenis_kelamin'   => $request->jenis_kelamin,
            'tanggal_lahir'   => $request->tanggal_lahir,
            'alamat'          => $request->alamat,
            'no_hp'           => $request->no_hp,
            'golongan_darah'  => $request->golongan_darah,
        ]);

        // Login user setelah register
        Auth::login($user);

        return redirect()->route('pendaftaran')->with('success', 'Registrasi berhasil, Anda telah login.');
    }
}
