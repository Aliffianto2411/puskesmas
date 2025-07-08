<?php

namespace App\Http\Controllers;

use App\Models\JanjiTemu;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PendaftaranOfflineController extends Controller
{
    public function create()
    {
        $poli= Poli::all();
        return view('pendaftaran_offline', compact('poli'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pasien' => 'required|string|max:255',
            'poli_id' => 'required|exists:poli,id',
            'tanggal' => 'required|date',
            'jam' => 'required',
        ]);

        // Buat nomor antrian otomatis berdasarkan tanggal dan poli
        $lastJanji = JanjiTemu::where('tanggal', $request->tanggal)
            ->where('poli_id', $request->poli_id)
            ->orderBy('nomor_antrian', 'desc')
            ->first();

        if ($lastJanji) {
            $lastNumber = intval($lastJanji->nomor_antrian);
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '001';
        }

        JanjiTemu::create([
            'user_id' => null, // Karena offline, belum punya user login
            'poli_id' => $request->poli_id,
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
            'detail_keluarga_id' => null,
            'status' => 'menunggu',
            'nomor_antrian' => $newNumber,
        ]);

        return redirect()->back()->with('success', "Pendaftaran berhasil. Nomor antrian Anda: $newNumber");
    }
}
