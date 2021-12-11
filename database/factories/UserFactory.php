<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
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

        $courses = ["1º" , "2º"];
        $cycles = [ "DAW" , "DAM"];

        $picName = Arr::random($this->getRandomUserPicture()).'.jpg';
        \File::isDirectory('storage/app/public/img/users/') or \File::makeDirectory('storage/app/public/img/users/', 0755, true, true);
        \File::copy('public/img/users/'.$picName ,'storage/app/public/img/users/'.$picName);

        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'phone' => $this->faker->regexify('[0-9]{9}'), //no uso el faker de telefonos porque mete formatos que no son de españa
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'class' => $courses[rand(0,sizeof($courses)-1)] . $cycles[rand(0,sizeof($cycles)-1)],
            'banned' => 0,
            'credit' => 0,
            'ban_strikes' => 0,
            'remember_token' => Str::random(10),
            'image' => rand(0,3)? null:$picName,
            ];
    }

    public function getRandomUserPicture()
    {
        return [
            'fake_user_00',
            'fake_user_01',
            'fake_user_02',
            'fake_user_03',
            'fake_user_04',
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
