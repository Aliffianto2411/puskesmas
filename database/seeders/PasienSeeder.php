<?php

namespace Database\Seeders;

use App\Models\Pasien;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PasienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pasien::insert([
            'nama' => 'Ahmad Fauzi',
            'nik' => '1234567890123456',
            'jenis_kelamin' => 'laki-laki',
            'tanggal_lahir' => '2000-01-01',
            'alamat' => 'Jl. Merdeka No.1',
            'no_hp' => '08123456789',
            'golongan_darah' => 'O'
        ]);
    }
}
