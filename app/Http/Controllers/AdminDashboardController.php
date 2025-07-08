<?php

namespace App\Http\Controllers;

use App\Models\JanjiTemu;
use App\Models\Poli;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Hitung total pasien (semua user tanpa filter role)
        $totalPasien = User::count();

        $totalPoli = Poli::count();

        $janjiHariIni = JanjiTemu::where('tanggal', Carbon::today())->count();

        $antrianAktif = JanjiTemu::where('tanggal', Carbon::today())
            ->where('status', 'menunggu')
            ->count();

        // Grafik kunjungan pasien 7 hari terakhir
        $grafikData = [
            'labels' => [],
            'data' => [],
        ];

        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::today()->subDays($i);
            $grafikData['labels'][] = $tanggal->translatedFormat('d M');
            $grafikData['data'][] = JanjiTemu::whereDate('tanggal', $tanggal)->count();
        }

        $antrianHariIni = JanjiTemu::with('poli', 'user')
            ->where('tanggal', Carbon::today())
            ->orderBy('jam')
            ->get();

        $riwayatTerakhir = JanjiTemu::with('poli', 'user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalPasien', 'totalPoli', 'janjiHariIni', 'antrianAktif',
            'grafikData', 'antrianHariIni', 'riwayatTerakhir'
        ));
    }
}
