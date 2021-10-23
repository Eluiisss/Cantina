<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' =>  Str::ucfirst($this->faker->word(rand(1,3))),
            'description' => $this->faker->sentence(rand(0,5)),
            'image' => $this->faker->imageUrl,
        ];
    }
}
