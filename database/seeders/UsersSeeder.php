<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
           $user1 = User::factory()->create([
            'name' => 'Test User',
            'password' => bcrypt('password'),
            'email' => 'test@example.com',
        ]);

        $user2 = User::factory()->create([
            'name' => 'Test User 2',
            'password' => bcrypt('password'),
            'email' => 'alif@gmail.com',
        ]);
    }
}
