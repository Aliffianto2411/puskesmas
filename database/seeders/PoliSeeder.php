<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Poli;

class PoliSeeder extends Seeder
{
    public function run()
    {
        $timestamp = date('Y-m-d H:i:s');
        Poli::insert([
            ['nama_poli' => 'Poli Umum', 'kode_poli' => 'U', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['nama_poli' => 'Poli Gigi', 'kode_poli' => 'G', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['nama_poli' => 'Poli Anak', 'kode_poli' => 'A', 'created_at' => $timestamp, 'updated_at' => $timestamp],
        ]);

    }
}

