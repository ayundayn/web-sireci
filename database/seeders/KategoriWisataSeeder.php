<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KategoriWisata;

class KategoriWisataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KategoriWisata::insert([
            ['nama_kategori' => 'Wisata Alam'],
            ['nama_kategori' => 'Wisata Belanja'],
            ['nama_kategori' => 'Wisata Budaya'],
            ['nama_kategori' => 'Wisata Edukasi'],
            ['nama_kategori' => 'Wisata Religi']
        ]);
    }
}
