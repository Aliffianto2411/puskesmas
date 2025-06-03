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
        'tanggal'            => 'required|date',
        'jam'                => 'required',
    ]);

    // 1) Slot bentrok?
    if (JanjiTemu::where('poli_id', $request->poli_id)
           ->where('tanggal', $request->tanggal)
           ->where('jam', $request->jam)
           ->exists()
    ) {
        return back()->with('error', 'Slot jam ini sudah diambil.');
    }

    // 2) Duplikat per anggota keluarga?
    if (JanjiTemu::where('detail_keluarga_id', $request->detail_keluarga_id)
           ->where('tanggal', $request->tanggal)
           ->exists()
    ) {
        return back()->with('error', 'Anggota keluarga ini sudah mengambil antrian hari ini.');
    }

    try {
        DB::beginTransaction();

        // generate nomor antrian seperti biasa...
        $prefix      = Poli::find($request->poli_id)->kode_poli;
        $last        = JanjiTemu::where('poli_id', $request->poli_id)
                          ->where('tanggal', $request->tanggal)
                          ->lockForUpdate()
                          ->orderByDesc('created_at')
                          ->first();
        $nextNumber  = $last
            ? intval(preg_replace('/\D/', '', $last->nomor_antrian)) + 1
            : 1;
        $nomorAntrian = $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        JanjiTemu::create([
            'user_id'             => Auth::id(),
            'detail_keluarga_id'  => $request->detail_keluarga_id,
            'poli_id'             => $request->poli_id,
            'tanggal'             => $request->tanggal,
            'jam'                 => $request->jam,
            'nomor_antrian'       => $nomorAntrian,
            'status'              => JanjiTemu::STATUS['Menunggu'],
        ]);
        $janji = JanjiTemu::where('user_id', Auth::id())
    ->orderByDesc('created_at')
    ->first();
        session(['last_appointment_id' => $janji->id]);
        DB::commit();

        return back()->with('success', 'Antrian berhasil dibuat. Nomor: '.$nomorAntrian);
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Terjadi kesalahan, silakan coba lagi.');
    }
}

    public function checkin($id)
    {
        $janji = JanjiTemu::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($janji->status === 'Menunggu') {
            $janji->status = 'Diterima';
            $janji->save();
            return back()->with('success', 'Pasien berhasil check-in.');
        }

        return back()->with('error', 'Janji temu ini tidak bisa di-check-in.');
    }

    public function cancel($id)
    {
        $janji = JanjiTemu::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($janji->status === 'Menunggu') {
            $janji->status = 'Dibatalkan';
            $janji->save();
            return back()->with('success', 'Janji temu berhasil dibatalkan.');
        }

        return back()->with('error', 'Janji temu ini tidak bisa dibatalkan.');
    }


}
