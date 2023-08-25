<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < 20; $i++) {
            Product::create([
                'id_kategori' => rand(1,3),
                'id_subkategori' => rand(1,4),
                'nama_barang' => 'Lorem Ipsum Dolor Sit Amet',
                'gambar' => 'shop_image_'.$i.'.jpg',
                'deskripsi' => 'Lorem Ipsum Dolor Sit Amet',
                'harga' => rand(30000, 250000),
                'diskon' => 0,
                'bahan' => 'Lorem Ipsum Dolor',
                'tags' => 'Lorem, Ipsum, Dolor, Sit, Amet',
                'sku' => Str::random(8),
                'ukuran' => 'S, M, L, XL',
                'warna' => 'Hitam, Biru, Kuning, Putih, Hijau',
            ]);
        }
    }
}
