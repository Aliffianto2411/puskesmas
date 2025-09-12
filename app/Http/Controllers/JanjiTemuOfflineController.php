<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JanjiTemu;
use App\Models\Poli;
use Carbon\Carbon;

class JanjiTemuOfflineController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal', Carbon::today()->toDateString());
        $nama = $request->input('nama');
        $poliDipilih = $request->input('poli');

        $polis = Poli::all();

        $janjiTemuOffline = collect();
        $janjiTemuOnline  = collect();

        if ($poliDipilih) {
            $baseQuery = JanjiTemu::with(['poli', 'detailKeluarga'])
                ->where('poli_id', $poliDipilih);

            if ($nama) {
                $baseQuery->whereHas('detailKeluarga', function ($q) use ($nama) {
                    $q->where('nama', 'like', '%' . $nama . '%');
                });
            }

            if ($tanggal) {
                $baseQuery->whereDate('tanggal', $tanggal);
            }

            $offlineQuery = (clone $baseQuery)->where('status_pendaftaran', 'Offline');
            $onlineQuery  = (clone $baseQuery)->where('status_pendaftaran', 'Online');

            $janjiTemuOffline = $offlineQuery->orderBy('created_at', 'asc')->get()->groupBy('tanggal');
            $janjiTemuOnline  = $onlineQuery->orderBy('jam', 'asc')->get()->groupBy('tanggal');
        }

        return view('admin.daftarjanjitemuoffline', compact(
            'janjiTemuOffline',
            'janjiTemuOnline',
            'polis',
            'poliDipilih',
            'tanggal',
            'nama'
        ));
    }

    public function panggil($id)
    {
        $janji = JanjiTemu::findOrFail($id);
        $janji->status = 'Diproses';
        $janji->save();

        return back()->with('success', 'Pasien sedang dipanggil.');
    }

    public function selesai($id)
    {
        $janji = JanjiTemu::findOrFail($id);
        $janji->status = 'Selesai';
        $janji->save();

        return back()->with('success', 'Janji temu selesai.');
    }

    public function batal($id)
    {
        $janji = JanjiTemu::findOrFail($id);
        $janji->status = 'Dibatalkan';
        $janji->save();

        return back()->with('success', 'Janji temu dibatalkan.');
    }
}
