<?php

namespace Database\Seeders;

use App\Models\Peralatan;
use Illuminate\Database\Seeder;

class PeralatanSeeder extends Seeder
{
    public function run(): void
    {
        $peralatans = [
            ['nama_peralatan' => 'Laptop Asus', 'kategori' => 'Laptop', 'jumlah_stok' => 10],
            ['nama_peralatan' => 'Mouse Logitech', 'kategori' => 'Aksesoris', 'jumlah_stok' => 15],
            ['nama_peralatan' => 'Keyboard Mechanical', 'kategori' => 'Aksesoris', 'jumlah_stok' => 8],
        ];

        foreach ($peralatans as $item) {
            Peralatan::create($item);
        }
    }
}