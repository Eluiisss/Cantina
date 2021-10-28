<?php

namespace Database\Factories;

use App\Models\Nre;
use Illuminate\Database\Eloquent\Factories\Factory;

class NreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Nre::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nre' =>$this->faker->regexify('/^[1-2]{1}[1-9]{7}$'),
        ];
    }
}
