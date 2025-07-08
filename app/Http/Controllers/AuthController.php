<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

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

            // Redirect berdasarkan role
            if ($user->hasRole('ADMIN')) {
                return redirect()->route('admin.dashboard');
            }

            if ($user->hasRole('DOKTER')) {
                return redirect()->route('dokter.janji-temu.index');
            }

            if ($user->hasRole('USER')) {
                return redirect()->route('pendaftaran');
            }

            // Jika role tidak dikenali
            Auth::logout();
            return redirect()->route('login')->withErrors(['role' => 'Role tidak dikenali']);
        }

        // Jika login gagal
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
            'nama'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name'              => $request->nama,
            'email'             => $request->email,
            'password'          => Hash::make($request->password), // Hash password
            'email_verified_at' => Carbon::now(),
        ]);

        $user->assignRole('USER'); // Gunakan huruf kapital agar konsisten

        Auth::login($user);
        return redirect()->route('pendaftaran');
    }
}