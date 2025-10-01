<?php

namespace App\Models;   


use Illuminate\Database\Eloquent\Model;
use App\Models\Keluarga;

class DetailKeluarga extends Model
{
    protected $fillable = [
        'keluarga_id','nama','nik','jenis_kelamin',
        'tanggal_lahir','alamat','golongan_darah'
    ];

    public function keluarga()
    {
        return $this->belongsTo(Keluarga::class);
    }
}
