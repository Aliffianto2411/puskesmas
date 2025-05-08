<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JanjiTemu extends Model
{
    use HasFactory;

    protected $table = 'janji_temu'; // Nama tabel di database

    protected $fillable = [
        'user_id',
        'poli',
        'tanggal',
        'jam',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
