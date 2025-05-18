<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JanjiTemu extends Model
{
    protected $table = 'janji_temu'; // sesuaikan nama tabel

    const STATUS = [
        'Menunggu' => 'Menunggu',
        'Diterima' => 'Diterima',
        'Selesai' => 'Selesai',
        'Dibatalkan' => 'Dibatalkan',
    ];

    protected $fillable = [
        'user_id',
        'poli_id',   // pakai poli_id supaya relasi ke tabel polis
        'tanggal',
        'jam',
        'nomor_antrian',
        'status', 
        'created_at',
        'updated_at',
    ];

    public function poli()
    {
        return $this->belongsTo(Poli::class, 'poli_id'); 
    }
}