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
        // tanggal tidak perlu diambil dari input, otomatis hari ini
        $tanggal = now()->toDateString();

        return view('pendaftaran_offline', compact('poli', 'poli_id', 'tanggal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_kk' => 'required',
            'detail_keluarga_id' => 'required|exists:detail_keluargas,id',
            'poli_id' => 'required|exists:poli,id',
            // 'tanggal' dihapus karena tidak lagi diinput user
        ]);

        $tanggalHariIni = now()->toDateString();

        // Cegah pasien daftar lebih dari 1x di tanggal dan poli yang sama
        $existingJanji = JanjiTemu::where('tanggal', $tanggalHariIni)
            ->where('poli_id', $request->poli_id)
            ->where('detail_keluarga_id', $request->detail_keluarga_id)
            ->exists();

        if ($existingJanji) {
            return back()
                ->withErrors(['detail_keluarga_id' => 'Pasien ini sudah memiliki janji pada tanggal dan poli yang sama.'])
                ->withInput();
        }

        // Simpan janji temu dengan tanggal = hari ini
        JanjiTemu::create([
            'user_id' => null,
            'poli_id' => $request->poli_id,
            'tanggal' => $tanggalHariIni,
            'jam' => null,
            'detail_keluarga_id' => $request->detail_keluarga_id,
            'status' => JanjiTemu::STATUS['Menunggu'],
            'status_pendaftaran' => JanjiTemu::STATUS_PENDAFTARAN['Offline'],
        ]);

        return redirect()->back()->with('success', 'Pendaftaran berhasil.');
    }
}
