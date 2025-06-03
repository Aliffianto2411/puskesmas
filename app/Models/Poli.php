<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    use HasFactory;
    protected $table = 'poli';

    protected $fillable = [
        'nama_poli','kode_poli',
    ];

    public function janjiTemu()
    {
        return $this->hasMany(JanjiTemu::class, 'poli_id'); 
    }
}
