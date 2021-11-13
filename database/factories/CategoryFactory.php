<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
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
        $picName = Arr::random($this->getRandomCategoryPicture()).'.jpg';
        \File::isDirectory('storage/app/public/img/categories/') or \File::makeDirectory('storage/app/public/img/categories/', 0755, true, true);
        \File::copy('public/img/categories/'.$picName ,'storage/app/public/img/categories/'.$picName);


        return [
            'name' =>  Str::ucfirst($this->faker->unique()->word(rand(1,3))),
            'description' => $this->faker->sentence(rand(0,5)),
            'image' =>  $picName,
        ];
    }

    public function getRandomCategoryPicture()
    {
        return ['cat-bebidas', 'cat-dulces','cat-snacks', 'cat_bocadillos-salados'];
    }
}
