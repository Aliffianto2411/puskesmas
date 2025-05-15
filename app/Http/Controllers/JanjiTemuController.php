<?php

namespace App\Http\Controllers;

use App\Models\JanjiTemu;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class JanjiTemuController extends Controller
{
    public function index()
    {
        $poli = Poli::all(); // ambil semua poli dari DB
        return view('appointment', compact('poli')); // kirim ke view
    }

    public function store(Request $request)
    {
        $request->validate([
            'poli_id' => 'required|exists:poli,id',
            'tanggal' => 'required|date',
            'jam' => 'required',
        ]);

        JanjiTemu::create([
            'user_id' => Auth::id(),
            'poli_id' => $request->poli_id,
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
        ]);

        return redirect()->back()->with('success', 'Janji temu berhasil dibuat.');
    }
}
