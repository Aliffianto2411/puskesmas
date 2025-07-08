<?php

namespace App\Http\Controllers;

use App\Models\Keluarga;
use App\Models\Role;
use Illuminate\Http\Request;

class KeluargaController extends Controller
{
       public function index(Request $request, $id = null)
    {
        // Ambil parameter pencarian dari query string (?q=...)
        $search = $request->query('q');

        $keluargas = Keluarga::with('anggota')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('no_kk', 'like', '%' . $search . '%')
                      ->orWhereHas('anggota', function ($userQuery) use ($search) {
                          $userQuery->where('nama', 'like', '%' . $search . '%');
                      });
                });
            })
            ->get();

        return view('admin.ListKeluarga', compact('keluargas'));
    }
    
public function show(Request $request, $id = null)
{
    if ($request->user()->hasRole('ADMIN')) {
        $daftarKk = Keluarga::with('user')->orderBy('created_at', 'desc')->get();
        $keluarga = null;
        if ($id) {
            $keluarga = Keluarga::with('anggota', 'user')->findOrFail($id);
        }
        return view('keluarga.show', compact('daftarKk', 'keluarga'));
    } else {
        $keluarga = $request->user()->keluarga()->with('anggota')->first();
        return view('keluarga.show', compact('keluarga'));
    }
}

    
   public function store(Request $request)
{
    if ($request->user()->hasRole('ADMIN')) {
        $data = $request->validate([
            'no_kk' => 'required|digits:16|unique:keluargas,no_kk',
            // 'user_id' => 'required|exists:users,id', // tidak perlu validasi user_id dari input
        ]);
        $kk = new Keluarga();
        $kk->no_kk = $data['no_kk'];
        $kk->user_id = $request->user()->id; // selalu admin yang login
        $kk->save();
        return redirect()->route('keluarga.index')->with('success', 'Kartu Keluarga berhasil dibuat.');
    } else {
        // User biasa hanya boleh create sekali
        if ($request->user()->keluarga) {
            return back()->withErrors(['Anda sudah memiliki Kartu Keluarga.']);
        }
        $data = $request->validate([
            'no_kk' => 'required|digits:16|unique:keluargas,no_kk',
        ]);
        $kk = new Keluarga();
        $kk->no_kk = $data['no_kk'];
        $kk->user_id = $request->user()->id;
        $kk->save();
        return redirect()->route('keluarga.show')->with('success', 'Kartu Keluarga berhasil dibuat.');
    }

}
}