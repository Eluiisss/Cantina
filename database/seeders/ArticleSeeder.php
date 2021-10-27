<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Nutrition;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected $categories;

    public function run()
    {
        $this->categories = Category::inRandomOrder()->pluck('id');

        $categorySnack = Category::query()->where('name', "Snacks")->first();

        $nutritionPizza = Nutrition::factory()->create([
            'is_veg' => false,
            'is_allergy' =>false,
            'calories' => 300.27,
            'sodium' =>  2.5,
            'proteins' => 126.6,
            'ingredients_description' => "Harina de trigo, Proteina animal, Edulcorante E346, Uranio empobrecido, Agua del Mar Menor",
            'allergy_description' => "",
            'created_at' => now()
        ]);

        Article::factory()->create([
            'id' => 1,
            'nutrition_id' => $nutritionPizza->id,
            'category_id' => $categorySnack->id,
            'name' => "Pizza",
            'stock' => 12,
            'price' => 1.75,
            'discount' => 0,
            'created_at' => now()
        ]);

        $nutritionPizza->update([
            'article_id' => 1,
        ]);

        foreach (range(0,30) as $i){
            $this->createRandomArticles();
        }
    }

    public function createRandomArticles()
    {
      $date = now()->subDays(rand(0,60));

      $nutrition = Nutrition::factory()->create([
            'created_at' => $date
        ]);
       $article = Article::factory()->create([
            'nutrition_id' => $nutrition->id,
            'category_id' => $this->categories->random(),
            'created_at' => $date
        ]);

        $nutrition->update([
            'article_id' => $article->id,
        ]);
    }
}
