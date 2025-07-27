<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JanjiTemu;
use App\Models\Poli;

class JanjiTemuOfflineController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $nama = $request->input('nama');
        $poliDipilih = $request->input('poli');

        // Ambil semua data poli untuk dropdown
        $polis = Poli::all();

        // Siapkan variabel kosong untuk hasil filter
        $janjiTemuOffline = collect();
        $janjiTemuOnline = collect();

        if ($poliDipilih) {
            // Query dasar dengan relasi poli dan detail keluarga
            $baseQuery = JanjiTemu::with(['poli', 'detailKeluarga'])
                ->where('poli_id', $poliDipilih);

            // Filter berdasarkan nama pasien
            if ($nama) {
                $baseQuery->whereHas('detailKeluarga', function ($q) use ($nama) {
                    $q->where('nama', 'like', '%' . $nama . '%');
                });
            }

            // Filter berdasarkan tanggal
            if ($tanggal) {
                $baseQuery->whereDate('tanggal', $tanggal);
            }

            // Clone query untuk memisahkan offline dan online
            $offlineQuery = (clone $baseQuery)->where('status_pendaftaran', JanjiTemu::STATUS_PENDAFTARAN['Offline']);
            $onlineQuery  = (clone $baseQuery)->where('status_pendaftaran', JanjiTemu::STATUS_PENDAFTARAN['Online']);

            // Ambil data dan group by tanggal
            $janjiTemuOffline = $offlineQuery->get()->groupBy('tanggal');
            $janjiTemuOnline  = $onlineQuery->get()->groupBy('tanggal');
        }

        return view('admin.daftarjanjitemuoffline', [
            'polis' => $polis,
            'poliDipilih' => $poliDipilih,
            'tanggal' => $tanggal,
            'nama' => $nama,
            'janjiTemuOffline' => $janjiTemuOffline,
            'janjiTemuOnline' => $janjiTemuOnline,
        ]);
    }

    public function panggil($id)
    {
        $janji = JanjiTemu::findOrFail($id);
        $janji->status = 'Diproses';
        $janji->save();

        return back()->with('success', 'Pasien dipanggil dan status diubah menjadi Diproses.');
    }

    public function selesai($id)
    {
        $janji = JanjiTemu::findOrFail($id);
        $janji->status = 'Selesai';
        $janji->save();

        return back()->with('success', 'Janji temu ditandai selesai.');
    }

    public function batal($id)
    {
        $janji = JanjiTemu::findOrFail($id);
        $janji->status = 'Batal';
        $janji->save();

        return back()->with('success', 'Janji temu dibatalkan.');
    }
}
