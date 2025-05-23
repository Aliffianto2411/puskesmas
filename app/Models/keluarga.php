<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keluarga extends Model
{
    protected $fillable = ['user_id','no_kk'];


    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
      public function anggota()   // <-- inilah yang nanti dipakai di Blade
    {
        return $this->hasMany(DetailKeluarga::class);
    }

}