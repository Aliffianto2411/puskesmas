<?php

namespace App\Http\Controllers;

use App\Models\JanjiTemu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JanjiTemuController extends Controller
{
    public function index()
    {
        return view('appoitment'); // View sesuai file yang kamu kirim
    }

    public function store(Request $request)
    {
        $request->validate([
            'poli' => 'required',
            'tanggal' => 'required',
            'jam' => 'required',
        ]);

        JanjiTemu::create([
            'user_id' => Auth::id(),
            'poli' => $request->poli,
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
        ]);

        return redirect()->back()->with('success', 'Janji temu berhasil dibuat.');
    }

        public function getTakenSlots($poli, $tanggal)
    {
        // Ambil data janji temu berdasarkan poli dan tanggal dari database
        $takenSlots = JanjiTemu::where('poli', $poli)
                                ->where('tanggal', $tanggal)
                                ->pluck('jam') // ambil kolom jam
                                ->toArray();

        return response()->json($takenSlots);
    }

}
