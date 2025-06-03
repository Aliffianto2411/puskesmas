<?php

namespace App\Http\Controllers;

use App\Models\JanjiTemu;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $activeInvoices = JanjiTemu::with(['poli', 'detailKeluarga'])
            ->where('user_id', $userId)
            ->whereIn('status', ['Menunggu', 'Diterima'])
            ->orderBy('tanggal', 'asc')
            ->orderBy('jam', 'asc')
            ->get();
        $pengumuman = Pengumuman::orderBy('tanggal_pengumuman', 'desc')->get();

        $jadwalDokter = [
            ['poli' => 'Umum', 'dokter' => 'dr. Fitriani', 'jam' => '08:00 - 12:00'],
            ['poli' => 'Gigi', 'dokter' => 'drg. Andika', 'jam' => '09:00 - 13:00'],
        ];

        $riwayatAntrian = [
            ['tanggal' => '07 Mei 2025', 'poli' => 'Umum', 'nomor' => '032', 'status' => 'Selesai'],
            ['tanggal' => '05 Mei 2025', 'poli' => 'Gigi', 'nomor' => '019', 'status' => 'Batal'],
        ];

        return view('pendaftaran', compact('activeInvoices', 'jadwalDokter', 'riwayatAntrian','pengumuman'));
    }
}
