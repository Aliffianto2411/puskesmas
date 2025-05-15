<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasien'; 

    const jenis_kelamin = [
        'L' => 'Laki-laki',
        'P' => 'Perempuan',
    ];

    protected $fillable = [
        'nama',
        'nik',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
        'no_hp',
        'golongan_darah',
    ];
}

