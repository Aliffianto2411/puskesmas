<?php

namespace App\Http\Controllers;

use App\Models\DetailKeluarga;
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
        ]);

 
        JanjiTemu::create([
            'user_id' => null, // Karena offline, belum punya user login
            'poli_id' => $request->poli_id,
            'tanggal' => $request->tanggal,
            'jam' => null,
            'detail_keluarga_id' => null,
            'status' => JanjiTemu::STATUS['Menunggu'],
            'status_pendaftaran' => JanjiTemu::STATUS_PENDAFTARAN['Offline'],
            'created_at' => now(),
        ]);

        DetailKeluarga::create([
            'nama' => $request->nama_pasien,
            'nik' => Str::random(16), // Generate NIK acak untuk offline
            'jenis_kelamin' => $request->jenis_kelamin ?? 'L', // Default ke Laki-laki jika tidak ada
            'tanggal_lahir' => $request->tanggal_lahir ?? now()->subYears(30), // Default 30 tahun lalu
            'alamat' => $request->alamat ?? 'Alamat tidak diketahui',
            'golongan_darah' => $request->golongan_darah ?? 'O', // Default Golongan Darah O
        ]);



        return redirect()->back()->with('success', "Pendaftaran berhasil. Nomor antrian Anda: $newNumber");
    }
}
