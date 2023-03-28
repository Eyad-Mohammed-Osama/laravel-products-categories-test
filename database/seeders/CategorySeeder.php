<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            "name:en" => "Shoes"
        ]);

        Category::create([
            "name:en" => "Adidas"
        ]);

        Category::create([
            "name:en" => "Nike"
        ]);

        Category::create([
            "name:en" => "Sport"
        ]);

        Category::create([
            "name:en" => "Home"
        ]);

        Category::find(1)->children()->sync([2, 3]);
        Category::find(3)->children()->sync([4, 5]);

        Category::create([
            "name:en" => "Jackets"
        ]);

        Category::create([
            "name:en" => "Shirts"
        ]);
    }
}
