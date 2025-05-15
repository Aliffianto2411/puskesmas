<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    use HasUuids;
    protected $table = 'poli'; // sesuaikan nama tabel

    protected $fillable = [
        'nama_poli',
    ];

    public function janjiTemu()
    {
        return $this->hasMany(JanjiTemu::class, 'poli_id'); // relasi ke tabel janji_temu
    }
}
