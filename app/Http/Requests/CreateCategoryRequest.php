<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CreateCategoryRequest extends FormRequest
{
    public function rules()
    {
        return [

            'category_name' => ['required', 'unique:categories,name', 'regex:/^[a-zA-ZáéíóúñÑ\s]+$/', 'min:3', 'max:20'],
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

    public function createNewCategory()
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

        Category::create([
            'name' => $this->category_name,
            'description' => $this->category_description,
            'image' => $picName,
        ]);

    }
}
