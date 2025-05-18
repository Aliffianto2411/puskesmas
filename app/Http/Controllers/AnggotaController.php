<?php

namespace App\Http\Controllers;

use App\Models\DetailKeluarga;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'           => 'required|string|max:100',
            'nik'            => 'required|digits:16|unique:detail_keluargas,nik',
            'jenis_kelamin'  => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir'  => 'nullable|date',
            'alamat'         => 'nullable|string',
            'golongan_darah' => 'nullable|in:A,B,AB,O',
        ]);

        $keluarga = $request->user()->keluarga;

        if (!$keluarga) {
            return back()->withErrors('Buat KK terlebih dahulu.');
        }

        $keluarga->anggota()->create([
            'nama'           => $data['nama'],
            'nik'            => $data['nik'],
            'jenis_kelamin'  => $data['jenis_kelamin'],
            'tanggal_lahir'  => $data['tanggal_lahir'],
            'alamat'         => $data['alamat'],
            'golongan_darah' => $data['golongan_darah'],
            'created_at'   => now(),
        ])->save();

        return back()->with('success', 'Anggota ditambahkan.');
    }

    // Form edit (opsional)
    public function edit(DetailKeluarga $anggota)
    {
        return view('keluarga.edit', compact('anggota'));
    }

    public function update(Request $request, DetailKeluarga $anggota)
    {

        $data = $request->validate([
            'nama'           => 'required|string|max:100',
            'nik'            => 'required|digits:16|unique:detail_keluargas,nik,' . $anggota->id,
            'jenis_kelamin'  => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir'  => 'nullable|date',
            'alamat'         => 'nullable|string',
            'golongan_darah' => 'nullable|in:A,B,AB,O',
        ]);

        $anggota->update($data);

        return back()->with('success', 'Data anggota diperbarui.');
    }

    public function destroy(DetailKeluarga $anggota)
    {
        $anggota->delete();

        return back()->with('success', 'Anggota dihapus.');
    }

}
