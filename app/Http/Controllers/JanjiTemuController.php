<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use App\Models\JanjiTemu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class JanjiTemuController extends Controller
{
    public function index()
    {
        $poli = Poli::all(); 
        return view('appointment', compact('poli')); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'poli_id' => 'required|exists:poli,id',
            'tanggal' => 'required|date',
            'jam' => 'required',
        ]);

        $existingAntrian = JanjiTemu::where('user_id', Auth::id())
            ->where('tanggal', $request->tanggal)
            ->where('poli_id', $request->poli_id)
            ->first();

        if ($existingAntrian) {
            return redirect()->back()->with('error', 'Anda sudah memiliki nomor antrian untuk poli dan tanggal tersebut.');
        }

        try {
            DB::beginTransaction();

            $prefix = 'A'; 
            $lastAntrian = JanjiTemu::where('poli_id', $request->poli_id)
                ->where('tanggal', $request->tanggal)
                ->orderBy('created_at', 'desc')
                ->lockForUpdate() 
                ->first();

            $nextNumber = ($lastAntrian && preg_match('/\d+$/', $lastAntrian->nomor_antrian, $matches))
                ? (int)$matches[0] + 1
                : 1;

            $nomorAntrian = $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            JanjiTemu::create([
                'user_id' => Auth::id(),
                'poli_id' => $request->poli_id,
                'tanggal' => $request->tanggal,
                'jam' => $request->jam,
                'nomor_antrian' => $nomorAntrian,
                'created_at' => now(),
                'updated_at' => null,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Janji temu berhasil dibuat. Nomor Antrian Anda: ' . $nomorAntrian);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat janji temu. Silakan coba lagi.');
        }

    }

    //make function checkin dan batalkan
    public function checkin(Request $request, $id)
    {
        $janjiTemu = JanjiTemu::findOrFail($id);
        $janjiTemu->update(['updated_at' => now()]);

        return redirect()->back()->with('success', 'Anda telah melakukan check-in.');
    }

    public function batalkan(Request $request, $id)
    {
        $janjiTemu = JanjiTemu::findOrFail($id);
        $janjiTemu->delete();

        return redirect()->back()->with('success', 'Janji temu berhasil dibatalkan.');
    }


}
