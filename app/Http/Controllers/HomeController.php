<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil pengumuman terbaru, misal hanya 3 terakhir
        $pengumuman = Pengumuman::orderBy('tanggal_pengumuman', 'desc')->take(3)->get();

        return view('home', compact('pengumuman'));
    }
}
