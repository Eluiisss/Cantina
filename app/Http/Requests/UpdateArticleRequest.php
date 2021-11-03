<?php

namespace App\Http\Requests;

use App\Models\Article;
use App\Models\Nutrition;
use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
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

    public function updateArticle(Article $article)
    {
        $article->update([
            'category_id' => $this->article_category,
            'name' => $this->article_name,
            'stock' => $this->article_stock,
            'price' => $this->article_price,
            'discount' => $this->article_discount,
            'image' => "https://via.placeholder.com/640x480.png/000011?text=" . $this->article_name . "",
            'updated_at' => now()
        ]);

        $article->nutrition()->update([
            'is_veg' => $this->article_veg,
            'is_allergy' => $this->article_allergy,
            'calories' => $this->article_calories,
            'sodium' =>  $this->article_sodium,
            'proteins' => $this->article_proteins,
            'ingredients_description' => $this->article_ingredients_description,
            'allergy_description' => $this->article_allergy_description,
            'updated_at' => now()
        ]);
    }
}
