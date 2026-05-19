<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Categories;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'category_name' => 'Sembako',
                'description' => 'Bahan pokok kebutuhan sehari hari',
            ],
            [
                'category_name' => 'Alat Tulis',
                'description' => 'Alat kebutuhan sekolah kerja dan lain lain'
            ],
            [
                'category_name' => 'Alat Rumah Tangga',
                'description' => 'Alat kebutuhan rumah tangga'
            ],
        ];

        foreach ($categories as $category) {
            categories::create($category);
        }
    }
}
