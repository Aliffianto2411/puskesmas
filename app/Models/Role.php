<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRole;


class Role extends SpatieRole

{
    const ROLE = [
        'ADMIN' => 'ADMIN',
        'USER' => 'USER',
        'DOKTER' => 'DOKTER',
    ];

    use HasFactory;
}
