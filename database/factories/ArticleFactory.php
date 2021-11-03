<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Nutrition;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Article::class;

    public function configure(){
        return $this->afterCreating(function ($article) {
            $article->nutrition()->save(Nutrition::factory()->make());
        });
    }

    public function definition()
    {
        return [
            'name' =>  Str::ucfirst($this->faker->word()),
            'stock' => $this->faker->numberBetween(0,50),
            'price' => $this->faker->randomFloat('2', '1', '15'),
            'discount' => rand(0,3)?ceil(rand(1,4))*10: 0,
            'image' => $this->faker->imageUrl,
        ];
    }
}
