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

    public function detailKeluargas()
    {
        return $this->hasMany(DetailKeluarga::class, 'keluarga_id');
    }
    public function keluarga() {
    return $this->belongsTo(Keluarga::class, 'keluarga_id');
}


}