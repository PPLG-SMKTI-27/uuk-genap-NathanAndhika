<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert Categories
        \DB::table('categories')->insert([
            [
                'nama_kategori' => 'Makanan',
                'description' => 'Segala jenis makanan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Minuman',
                'description' => 'Segala jenis minuman',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Cemilan',
                'description' => 'Makanan ringan',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        $kategoriMakanan = \DB::table('categories')->where('nama_kategori', 'Makanan')->first()->id;
        $kategoriMinuman = \DB::table('categories')->where('nama_kategori', 'Minuman')->first()->id;
        $kategoriCemilan = \DB::table('categories')->where('nama_kategori', 'Cemilan')->first()->id;

        // Insert Products
        \DB::table('products')->insert([
            [
                'category_id' => $kategoriMakanan,
                'product_name' => 'Nasi Goreng',
                'price' => 15000,
                'stock' => 50,
                'unit' => 'Porsi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $kategoriMakanan,
                'product_name' => 'Mie Ayam',
                'price' => 12000,
                'stock' => 40,
                'unit' => 'Mangkuk',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $kategoriMinuman,
                'product_name' => 'Es Teh Manis',
                'price' => 5000,
                'stock' => 100,
                'unit' => 'Gelas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $kategoriMinuman,
                'product_name' => 'Jus Jeruk',
                'price' => 10000,
                'stock' => 30,
                'unit' => 'Gelas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $kategoriCemilan,
                'product_name' => 'Keripik Singkong',
                'price' => 8000,
                'stock' => 75,
                'unit' => 'Bungkus',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
