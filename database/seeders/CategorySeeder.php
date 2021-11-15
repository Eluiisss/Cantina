<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::factory()->create([
            'name' => "Snacks",
            'description' => "Patatas y eso",
            'image' => "cat-snacks.jpg",
            'created_at' => now()
        ]);

        Category::factory()->create([
            'name' => "Bebidas",
            'description' => "La coquita y el aguita",
            'image' => "cat-bebidas.jpg",
            'created_at' => now()
        ]);

        foreach (range(0,8) as $i){
            $this->createRandomCategories();
        }
    }

    public function createRandomCategories()
    {
        Category::factory()->create([
            'created_at' => now()->subDays(rand(0,60))
        ]);
    }
}
