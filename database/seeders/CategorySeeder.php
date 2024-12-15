<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category_seed = [
            ['catid' => 'F', 'catname' => 'Food'],
            ['catid' => 'D', 'catname' => 'Drink'],
            ['catid' => 'DE', 'catname' => 'Dessert'],
        ];

        foreach ($category_seed as $category_seed) {
            Category::firstOrCreate($category_seed);
        }
    }
}
