<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function rules()
    {
        $categoryId = $this->category->id;
        return [
            'category_name' => ['required',
                                Rule::unique('categories', 'name')->where(function ($query) use ($categoryId) {
                                    return $query->where('id', '!=', $categoryId);}),
                                'regex:/^[a-zA-ZáéíóúñÑ\s]+$/',
                                'min:3',
                                'max:20',
                                ],
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

    public function updateCategory(Category $category)
    {
        $category->update([
            'name' => $this->category_name,
            'description' => $this->category_description,
            'image' => "https://via.placeholder.com/640x480.png/000011?text=" . $this->category_name . "",
        ]);


    }
}
