<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PengumumanSeeder extends Seeder
{
    public function run()
    {
        DB::table('pengumuman')->insert([
            [
                'judul' => 'Libur Nasional',
                'isi' => 'Puskesmas tutup pada tanggal 10 Mei 2025.',
                'tanggal_pengumuman' => Carbon::create(2025, 5, 1),
                'tanggal_berakhir' => Carbon::create(2025, 5, 10),
            ],
            [
                'judul' => 'Perubahan Jadwal Poli Gigi',
                'isi' => 'Jam praktik berubah menjadi pukul 10.00 - 13.00 mulai minggu depan.',
                'tanggal_pengumuman' => Carbon::create(2025, 5, 1),
                'tanggal_berakhir' => Carbon::create(2025, 5, 14),
            ],
            [
                'judul' => 'Pendaftaran Online',
                'isi' => 'Pendaftaran online dibuka setiap hari pukul 08.00 - 16.00.',
                'tanggal_pengumuman' => Carbon::create(2025, 5, 1),
                'tanggal_berakhir' => Carbon::create(2025, 5, 31),
            ],
            [
                'judul' => 'Vaksinasi COVID-19',
                'isi' => 'Vaksinasi COVID-19 tersedia setiap hari Senin dan Kamis.',
                'tanggal_pengumuman' => Carbon::create(2025, 5, 1),
                'tanggal_berakhir' => Carbon::create(2025, 6, 30),
            ],
            [
                'judul' => 'Peningkatan Layanan',
                'isi' => 'Kami meningkatkan layanan dengan penambahan dokter spesialis baru.',
                'tanggal_pengumuman' => Carbon::create(2025, 5, 1),
                'tanggal_berakhir' => Carbon::create(2025, 6, 15),
            ],
            [
                'judul' => 'Pengumuman Penting',
                'isi' => 'Mohon perhatikan protokol kesehatan saat berkunjung ke Puskesmas.',
                'tanggal_pengumuman' => Carbon::create(2025, 5, 1),
                'tanggal_berakhir' => Carbon::create(2025, 5, 31),
            ],
            [
                'judul' => 'Kegiatan Sosialisasi',
                'isi' => 'Akan diadakan sosialisasi kesehatan pada tanggal 15 Mei 2025.',
                'tanggal_pengumuman' => Carbon::create(2025, 5, 1),
                'tanggal_berakhir' => Carbon::create(2025, 5, 15),
            ],
    
            [
                'judul' => 'Pendaftaran Kartu Sehat',
                'isi' => 'Pendaftaran kartu sehat dibuka setiap hari kerja.',
                'tanggal_pengumuman' => Carbon::create(2025, 5, 1),
                'tanggal_berakhir' => Carbon::create(2025, 6, 30),
            ],
            [
                'judul' => 'Perubahan Alamat',
                'isi' => 'Puskesmas pindah ke alamat baru mulai 1 Juni 2025.',
                'tanggal_pengumuman' => Carbon::create(2025, 5, 1),
                'tanggal_berakhir' => Carbon::create(2025, 6, 1),
            ],
            [
                'judul' => 'Peningkatan Fasilitas',
                'isi' => 'Kami telah menambah fasilitas ruang tunggu yang nyaman.',
                'tanggal_pengumuman' => Carbon::create(2025, 5, 1),
                'tanggal_berakhir' => Carbon::create(2025, 6, 30),
            ],
            [
                'judul' => 'Layanan Telemedicine',
                'isi' => 'Kami menyediakan layanan konsultasi online melalui aplikasi.',
                'tanggal_pengumuman' => Carbon::create(2025, 5, 1),
                'tanggal_berakhir' => Carbon::create(2025, 6, 30),
            ],    
        ]);
    }
}  
