<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

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
            'category_image' => ['nullable', 'image','mimes:jpg,png,jpeg']
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
        $picName = null;
        if($this->hasFile('category_image')){
            $picName = substr(time(), 0, -1) ."-". Str::slug($this->category_name) . "." . $this->file('category_image')->extension();

            $categoryDirectory = storage_path() . '/app/public/img/categories/';
            if (!file_exists($categoryDirectory)) {
                mkdir($categoryDirectory, 0755);
            }
            $picPath = $categoryDirectory . $picName;

            Image::make($this->file('category_image'))
                ->resize(1024, null, function ($constraint){
                    $constraint->aspectRatio();
                })
                ->save($picPath);
        }

        $category->update([
            'name' => $this->category_name,
            'description' => $this->category_description,
        ]);

        if($picName!= null){
            $category->update([
                'image' => $picName,
            ]);
        }

    }
}
