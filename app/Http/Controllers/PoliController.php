<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use App\Http\Requests\PoliRequest;
use Illuminate\Http\Request;

class PoliController extends Controller
{
    /**
     * Menampilkan semua data poli
     */
    public function index()
    {
        $poli = Poli::all();
        return view('admin.Poli', compact('poli'));
    }

    /**
     * Form tambah (tidak dipakai kalau modal digunakan)
     */
    public function create()
    {
        return view('poli.create');
    }

    /**
     * Simpan data baru ke database
     */
    public function store(PoliRequest $request)
    {
        // Pastikan hanya field yang diizinkan yang disimpan
        Poli::create([
            'nama_poli' => $request->nama_poli,
            'kode_poli' => $request->kode_poli,
        ]);

        return redirect()->route('poli.index')->with('success', 'Poli berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit (biasanya dipanggil via AJAX)
     */
   public function edit($id)
{
    $poli = Poli::findOrFail($id);
    return view('admin.edit', compact('poli')); // Pastikan ini hanya return isi modal-content
}
    /**
     * Update data poli
     */
    public function update(PoliRequest $request, Poli $poli)
    {
        $poli->update([
            'nama_poli' => $request->nama_poli,
            'kode_poli' => $request->kode_poli,
        ]);

        return redirect()->route('poli.index')->with('success', 'Poli berhasil diperbarui.');
    }

    /**
     * Hapus data poli
     */
    public function destroy(Poli $poli)
    {
        $poli->delete();
        return redirect()->route('poli.index')->with('success', 'Poli berhasil dihapus.');
    }
}
