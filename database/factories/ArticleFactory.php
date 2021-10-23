<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
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
