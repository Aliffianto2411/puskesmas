<?php

namespace App\Http\Controllers;

use App\Models\JanjiTemu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatAntrianController extends Controller
{
    public function index()
    {
        $riwayat = JanjiTemu::with(['poli', 'detailKeluarga'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('riwayat', compact('riwayat'));
    }
}
