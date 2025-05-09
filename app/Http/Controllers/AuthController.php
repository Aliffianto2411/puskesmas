<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
    
        if (empty($request->email) || empty($request->password)) {
            return back()->withErrors([
                'kosong' => 'Email dan password harus diisi'
            ]);
        }
    
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember'); // true jika checkbox dicentang
    
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect('pendaftaran');
        }
    
        return back()->withErrors([
            'loginError' => 'Email atau Password salah'
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
            'nama'  => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'remember' => 'nullable'
            
        ]);

        $user =  User::create([
            'name' => $request->nama,
            'password' => $request->password,
            'email' => $request->email,
            'email_verified_at' => Carbon::now(),
            
        ])
        ->assignRole('user');

        $login = [
            'email'     => $request->email,
            'password'  => $request->password
        ];

        if (Auth::attempt($login)) {
            return redirect()->route('login');
        } else {
            return redirect()->route('login')->with('failed', 'Email atau Password Salah');
        }
    }
}
