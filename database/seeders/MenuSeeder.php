<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [
            // Nasi
            ['nama' => 'Nasi Gudeg', 'harga' => 15000, 'kategori' => 'Nasi', 'stok' => 20],
            ['nama' => 'Nasi Pecel', 'harga' => 12000, 'kategori' => 'Nasi', 'stok' => 15],
            ['nama' => 'Nasi Kucing', 'harga' => 3000, 'kategori' => 'Nasi', 'stok' => 30],
            
            // Gorengan
            ['nama' => 'Tempe Mendoan', 'harga' => 2000, 'kategori' => 'Gorengan', 'stok' => 50],
            ['nama' => 'Tahu Isi', 'harga' => 3000, 'kategori' => 'Gorengan', 'stok' => 40],
            ['nama' => 'Bakwan Jagung', 'harga' => 2500, 'kategori' => 'Gorengan', 'stok' => 35],
            ['nama' => 'Pisang Goreng', 'harga' => 3500, 'kategori' => 'Gorengan', 'stok' => 25],
            
            // Minuman
            ['nama' => 'Es Teh Manis', 'harga' => 3000, 'kategori' => 'Minuman', 'stok' => 100],
            ['nama' => 'Es Jeruk', 'harga' => 4000, 'kategori' => 'Minuman', 'stok' => 80],
            ['nama' => 'Kopi Hitam', 'harga' => 5000, 'kategori' => 'Minuman', 'stok' => 60],
            ['nama' => 'Wedang Jahe', 'harga' => 4500, 'kategori' => 'Minuman', 'stok' => 40],
            
            // Cemilan
            ['nama' => 'Kerupuk', 'harga' => 1000, 'kategori' => 'Cemilan', 'stok' => 100],
            ['nama' => 'Rempeyek', 'harga' => 2000, 'kategori' => 'Cemilan', 'stok' => 50],
            ['nama' => 'Kacang Rebus', 'harga' => 3000, 'kategori' => 'Cemilan', 'stok' => 30],
        ];

        foreach ($menus as $menu) {
            Menu::create([
                'nama' => $menu['nama'],
                'harga' => $menu['harga'],
                'kategori' => $menu['kategori'],
                'stok' => $menu['stok'],
                'deskripsi' => 'Menu ' . $menu['nama'] . ' khas angkringan',
                'tersedia' => true
            ]);
        }
    }
}