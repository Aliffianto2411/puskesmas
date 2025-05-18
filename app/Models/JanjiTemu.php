<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JanjiTemu extends Model
{
    protected $table = 'janji_temu'; // sesuaikan nama tabel

    protected $fillable = [
        'user_id',
        'poli_id',   // pakai poli_id supaya relasi ke tabel polis
        'tanggal',
        'jam',
        'nomor_antrian',
        'created_at',
        'updated_at',
    ];

    public function poli()
    {
        return $this->belongsTo(Poli::class, 'poli_id'); // relasi ke tabel poli
    }
}