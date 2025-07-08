<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
           $user1 = User::create([
            'name' => 'Test User',
            'password' => Hash::make('password'),
            'email' => 'test@example.com',
        ])->assignRole(Role::ROLE['ADMIN']);

        $user2 = User::create([
            'name' => 'Test User 2',
            'password' => Hash::make('password'),
            'email' => 'alif@gmail.com',
        ])->assignRole(Role::ROLE['USER']);

        $user3 = User::create([
            'name' => 'Dokter',
            'password' => Hash::make('password'),
            'email' => 'dokter@gmail.com',
        ])->assignRole(Role::ROLE['DOKTER']);
    }
}
