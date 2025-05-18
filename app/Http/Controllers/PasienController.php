<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function index()
    {
        $pasien = Pasien::all();
        
        return view('profile.index', compact('pasien'));
    }
    public function create()
    {
        return view('profile.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:16|unique:pasiens',
            'jenis_kelamin' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'golongan_darah' => 'required|string',
        ]);

        Pasien::create([
            'nama' => $request->nama,
            'nik' => $request->nik,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'golongan_darah' => $request->golongan_darah,
        ]);

        return redirect()->route('profile.index')->with('success', 'Profile created successfully');
    }

    public function edit($id)
    {
        $pasien = Pasien::findOrFail($id);
        
        return view('profile.edit', compact('pasien'));
    }

    public function update(Request $request, $id)
    {
        $pasien = Pasien::findOrFail($id);
        $pasien->update([
            'nama' => $request->nama,
            'nik' => $request->nik,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'golongan_darah' => $request->golongan_darah,
            'updated_at' => now(),
        ]);
        
       $pasien->save();
        return redirect()->route('profile.index')->with('success', 'Profile updated successfully');
    }
}
