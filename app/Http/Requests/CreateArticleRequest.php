<?php

namespace App\Http\Requests;

use App\Models\Article;
use App\Models\Nutrition;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CreateArticleRequest extends FormRequest
{
    public function rules()
    {
        return [
            'article_name' => ['required', 'regex:/^[a-zA-ZáéíóúñÑ\s]+$/', 'min:3', 'max:20'],
            'article_category' => ['required','exists:categories,id'],
            'article_price' => ['required','numeric', 'min:0', 'max:10000'],
            'article_stock' => ['required','numeric', 'min:0', 'max:1000'],
            'article_discount' => ['required','numeric', 'min:0', 'max:100'],
            'article_calories' => ['required','numeric', 'min:0', 'max:5000'],
            'article_sodium' => ['required','numeric', 'min:0', 'max:500'],
            'article_proteins' => ['required','numeric', 'min:0', 'max:200'],
            'article_veg' => ['required','boolean'],
            'article_allergy' => ['required','boolean'],
            'article_ingredients_description' => 'required|string|max:3000',
            'article_allergy_description' => ['required_if:article_allergy,1','string','max:3000', 'nullable'],
            'article_image' => ['nullable', 'image','mimes:jpg,png,jpeg']
        ];
    }

    public function messages()
    {
        return [
            //
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function createNewArticle()
    {
        DB::transaction(function (){

            $picName = null;
            if($this->hasFile('article_image')){
                $picName = substr(time(), 0, -1) ."-". Str::slug($this->article_name) . "." . $this->file('article_image')->extension();

                $articleDirectory = storage_path() . '/app/public/img/articles/';
                if (!file_exists($articleDirectory)) {
                    mkdir($articleDirectory, 0755);
                }
                $picPath = $articleDirectory . $picName;

                Image::make($this->file('article_image'))
                    ->resize(1024, null, function ($constraint){
                        $constraint->aspectRatio();
                    })
                    ->save($picPath);
            }

           $article =  Article::create([
                'category_id' => $this->article_category,
                'name' => $this->article_name,
                'stock' => $this->article_stock,
                'price' => $this->article_price,
                'discounted_price' => round(($this->article_price)-(($this->article_price * $this->article_discount)/100), 2),
                'discount' => $this->article_discount,
                'image' => $picName,
                'created_at' => now()
            ]);

             Nutrition::create([
                'article_id' => $article->id,
                'is_veg' => $this->article_veg,
                'is_allergy' => $this->article_allergy,
                'calories' => $this->article_calories,
                'sodium' =>  $this->article_sodium,
                'proteins' => $this->article_proteins,
                'ingredients_description' => $this->article_ingredients_description,
                'allergy_description' => $this->article_allergy_description,
                'created_at' => now()
            ]);
        });
    }
}
