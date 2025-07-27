<?php

namespace App\Http\Controllers;

use App\Models\DetailKeluarga;
use App\Models\JanjiTemu;
use App\Models\Poli;
use Illuminate\Http\Request;

class PendaftaranOfflineController extends Controller
{
    public function create(Request $request)
    {
        $poli = Poli::all();

        $poli_id = $request->query('poli_id') ?? old('poli_id');
        $tanggal = $request->query('tanggal') ?? old('tanggal');

        // Tidak perlu lagi generate jam karena janji temu offline tidak pakai jam
        return view('pendaftaran_offline', compact('poli', 'poli_id', 'tanggal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_kk' => 'required',
            'detail_keluarga_id' => 'required|exists:detail_keluargas,id',
            'poli_id' => 'required|exists:poli,id',
            'tanggal' => 'required|date',
        ]);

        // Cegah pasien daftar lebih dari 1x di tanggal dan poli yang sama (tanpa jam)
        $existingJanji = JanjiTemu::where('tanggal', $request->tanggal)
            ->where('poli_id', $request->poli_id)
            ->where('detail_keluarga_id', $request->detail_keluarga_id)
            ->exists();

        if ($existingJanji) {
            return back()
                ->withErrors(['detail_keluarga_id' => 'Pasien ini sudah memiliki janji pada tanggal dan poli yang sama.'])
                ->withInput();
        }

        // Simpan janji temu tanpa jam
        JanjiTemu::create([
            'user_id' => null,
            'poli_id' => $request->poli_id,
            'tanggal' => $request->tanggal,
            'jam' => null, // tetap diset null jika kolom jam masih ada di database
            'detail_keluarga_id' => $request->detail_keluarga_id,
            'status' => JanjiTemu::STATUS['Menunggu'],
            'status_pendaftaran' => JanjiTemu::STATUS_PENDAFTARAN['Offline'],
        ]);

        return redirect()->back()->with('success', 'Pendaftaran berhasil.');
    }
}
