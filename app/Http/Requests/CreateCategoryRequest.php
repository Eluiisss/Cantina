<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
{
    public function rules()
    {
        return [
            'category_name' => ['required', 'unique:categories,name', 'regex:/^[a-zA-ZáéíóúñÑ\s]+$/', 'min:3', 'max:20'],
            'category_description' => ['nullable', 'min:10', 'max:2000'],
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

    public function createNewCategory()
    {
        Category::create([
            'name' => $this->category_name,
            'description' => $this->category_description,
            'image' => "https://via.placeholder.com/640x480.png/000011?text=" . $this->category_name . "",
        ]);


    }
}
