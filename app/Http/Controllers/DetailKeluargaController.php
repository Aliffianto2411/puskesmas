<?php

namespace App\Http\Controllers;

use App\Models\DetailKeluarga;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AnggotaController extends Controller
{
    use AuthorizesRequests;
    // Tambah anggota
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

        $keluarga->anggota()->create($data);

        return back()->with('success', 'Anggota ditambahkan.');
    }

    // Form edit (opsional)
    public function edit(DetailKeluarga $anggota)
    {
        $this->authorize('update', $anggota); // pakai policy bila perlu
        return view('anggota.edit', compact('anggota'));
    }

    // Update anggota
    public function update(Request $request, DetailKeluarga $anggota)
    {
        $this->authorize('update', $anggota);

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

    // Hapus anggota
    public function destroy(DetailKeluarga $anggota)
    {
        $this->authorize('delete', $anggota);
        $anggota->delete();

        return back()->with('success', 'Anggota dihapus.');
    }
}
