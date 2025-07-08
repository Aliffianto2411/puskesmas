<?php

namespace App\Http\Controllers;

use App\Models\DetailKeluarga;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{

    public function store(Request $request)
    {
        $data = $request->validate([
            'keluarga_id' => 'required|exists:keluargas,id',
            'nama'           => 'required|string|max:100',
            'nik'            => 'required|digits:16|unique:detail_keluargas,nik',
            'jenis_kelamin'  => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir'  => 'nullable|date',
            'alamat'         => 'nullable|string',
            'golongan_darah' => 'nullable|in:A,B,AB,O',
        ]);

        $anggota = new DetailKeluarga($data);
        $anggota->save();

        return redirect()->route('keluarga.show', $data['keluarga_id'])
            ->with('success', 'Anggota berhasil ditambahkan.');
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

