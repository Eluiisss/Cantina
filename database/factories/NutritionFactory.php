<?php

namespace Database\Factories;

use App\Models\Nutrition;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class NutritionFactory extends Factory
{
    protected $model = Nutrition::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $allergy = $this->faker->boolean;
        return [
            'is_veg' => $this->faker->boolean,
            'is_allergy' => $allergy,
            'calories' => $this->faker->randomFloat('2', '0', '300'),
            'sodium' =>   $this->faker->randomFloat('2', '0', '20'),
            'proteins' => $this->faker->randomFloat('2', '0', '100'),
            'ingredients_description' => $this->faker->sentence(rand(0,30)),
            'allergy_description' => $allergy? $this->faker->sentence(rand(0,30)): "",
        ];
    }
}
