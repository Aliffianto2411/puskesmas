<?php

namespace App\Http\Controllers;

use App\Models\Keluarga;
use Illuminate\Http\Request;

class KeluargaController extends Controller
{
    
    public function show(Request $request)
    {
        $keluarga = $request->user()
            ->keluarga()           
            ->with('anggota')      
            ->first();

        return view('keluarga.show', compact('keluarga'));
    }

    
    public function store(Request $request)
    {
        $data = $request->validate([
            'no_kk' => 'required|digits:16|unique:keluargas,no_kk',
        ]);

       
        if ($request->user()->keluarga) {
            return back()->withErrors('Anda sudah memiliki KK.');
        }

        $request->user()->keluarga()->create($data);

        return redirect()->route('keluarga.show')
                         ->with('success', 'Kartu Keluarga berhasil dibuat.');
    }

   
    public function update(Request $request)
    {
        $data = $request->validate([
            'no_kk' => 'required|digits:16|unique:keluargas,no_kk,' .
                       $request->user()->keluarga->id,
        ]);

        $request->user()->keluarga->update($data);

        return back()->with('success', 'No KK diperbarui.');
    }
}