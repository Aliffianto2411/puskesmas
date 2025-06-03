<?php

namespace Database\Seeders;

use App\Models\Pengumuman;
use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\PasienSeeder;
use Database\Seeders\PoliSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([UsersSeeder::class]);
        $this->call([PoliSeeder::class]);
        $this->call([PasienSeeder::class]);
        $this->call([PengumumanSeeder::class]);
    }
    

}
