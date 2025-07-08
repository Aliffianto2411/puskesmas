<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use App\Models\JanjiTemu;
use Illuminate\Http\Request;
use App\Models\DetailKeluarga;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class JanjiTemuController extends Controller
{
    public function index()
    {
        $poli = Poli::all();
        $anggota = DetailKeluarga::whereHas('keluarga', function ($query) {
            $query->where('user_id', Auth::id());
        })->get();

        $janjiHariIni = JanjiTemu::with(['poli', 'detailKeluarga'])
            ->where('user_id', Auth::id())
            ->whereDate('tanggal', now()->toDateString())
            ->orderBy('jam', 'asc')
            ->get();

        $invoice = null;
        if (session()->has('last_appointment_id')) {
            $invoice = JanjiTemu::with(['poli', 'detailKeluarga'])
                ->where('user_id', Auth::id())
                ->find(session('last_appointment_id'));
        }

        return view('appointment', compact('poli', 'anggota', 'janjiHariIni', 'invoice'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'detail_keluarga_id' => 'required|exists:detail_keluargas,id',
            'poli_id'            => 'required|exists:poli,id',
            'tanggal'            => 'required|date|after_or_equal:' . now()->toDateString(),
            'jam'                => 'required',
        ]);

        // Tidak boleh ambil slot yang sudah dipakai
        if (JanjiTemu::where('poli_id', $request->poli_id)
            ->where('tanggal', $request->tanggal)
            ->where('jam', $request->jam)
            ->exists()
        ) {
            return back()->with('error', 'Slot jam ini sudah diambil.');
        }

        // Satu anggota keluarga hanya boleh satu janji per hari
        if (JanjiTemu::where('detail_keluarga_id', $request->detail_keluarga_id)
            ->where('tanggal', $request->tanggal)
            ->exists()
        ) {
            return back()->with('error', 'Anggota keluarga ini sudah memiliki janji hari ini.');
        }

        try {
            DB::beginTransaction();

            JanjiTemu::create([
                'user_id'             => Auth::id(),
                'detail_keluarga_id'  => $request->detail_keluarga_id,
                'poli_id'             => $request->poli_id,
                'tanggal'             => $request->tanggal,
                'jam'                 => $request->jam,
                'status'              => JanjiTemu::STATUS['Menunggu'],
                'status_pendaftaran'  => JanjiTemu::STATUS_PENDAFTARAN['Online'],
                'created_at'          => now(),
            ]);

            $janji = JanjiTemu::where('user_id', Auth::id())
                ->orderByDesc('created_at')
                ->first();

            session(['last_appointment_id' => $janji->id]);
            DB::commit();

            return back()->with('success', 'Janji temu berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan, silakan coba lagi.');
        }
    }

    public function checkin($id)
    {
        $janji = JanjiTemu::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $waktuJanji = now()->setTimeFromTimeString($janji->jam);
        $sekarang = now();

        // Check-in boleh dilakukan hanya dalam 5 menit sebelum jam janji
        if ($sekarang->greaterThanOrEqualTo($waktuJanji->subMinutes(5)) && $sekarang->lessThanOrEqualTo($waktuJanji)) {
            if ($janji->status === 'Menunggu') {
                $janji->status = 'Diterima';
                $janji->save();
                return back()->with('success', 'Berhasil check-in.');
            } else {
                return back()->with('error', 'Status janji temu tidak bisa di-check-in.');
            }
        }

        return back()->with('error', 'Check-in hanya bisa dilakukan 5 menit sebelum jam janji.');
    }

    public function cancel($id)
    {
        $janji = JanjiTemu::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($janji->status === 'Menunggu') {
            $janji->status = 'Dibatalkan';
            $janji->save();
            return back()->with('success', 'Janji temu dibatalkan.');
        }

        return back()->with('error', 'Janji temu ini tidak bisa dibatalkan.');
    }

    public function daftarJanjiTemu()
    {
        $daftarJanji = JanjiTemu::with(['poli', 'detailKeluarga', 'user'])
            ->orderBy('tanggal', 'asc')
            ->orderBy('jam', 'asc')
            ->get();

        return view('admin.daftar_janji', compact('daftarJanji'));
    }
}
