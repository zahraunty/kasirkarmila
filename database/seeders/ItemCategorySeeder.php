<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ItemCategory; // Perbaikan di sini

class ItemCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categories = [
            ['name' => 'Makanan'],
            ['name' => 'Minuman'],
            ['name' => 'Alat Tulis'],
            ['name' => 'Alat Dapur'],
            ['name' => 'Pembersih']
        ];

        foreach ($categories as $category){
            ItemCategory::create($category);
        }
    }
}
