<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Sementara agar tidak error
        $pasien = Pasien::first();

        return view('profile.index', compact('pasien'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('profile.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:16|unique:pasiens,nik',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'golongan_darah' => 'required|in:A,B,AB,O',
        ]);

        Pasien::create($validated);

        return redirect()->route('profile.index')->with('success', 'Profil berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pasien $pasien)
    {
        return view('profile.edit', compact('pasien'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pasien $pasien)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => [
                'required',
                'string',
                'max:16',
                Rule::unique('pasiens', 'nik')->ignore($pasien->id),
            ],
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'golongan_darah' => 'required|in:A,B,AB,O',
        ]);

        $pasien->update($validated);

        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage (optional).
     */
    public function destroy(Pasien $pasien)
    {
        $pasien->delete();

        return redirect()->route('profile.index')->with('success', 'Profil berhasil dihapus.');
    }
}
