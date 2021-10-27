<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Nre;
use App\Models\UserType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */

    
    public function definition()
    {
        $cursos = ["1º" , "2º"];
        $ciclos = [ "DAW" , "DAM"];
        return [
            'name' => $this->faker->Name(),
            'email' => $this->faker->unique()->safeEmail(),
            //'NRE' =>$this->faker->regexify('[1-9]{10}[A-Z]{1}'),
            'phone' =>$this->faker->phoneNumber(),
            //'usertype'=>rand(0, 1),
            'banned' =>rand(0, 1),
            'password' => 'changeme', // password
            'class' => $cursos[rand(0,sizeof($cursos)-1)] . $ciclos[rand(0,sizeof($ciclos)-1)] ,
            'remember_token' => Str::random(10),
            'nre_id' => Nre::factory()->create()->id,
            'user_type_id' =>UserType::all()->random()->id,
           
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}

