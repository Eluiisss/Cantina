<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Models\Nre;
use App\Models\Role;
use Illuminate\Validation\Rules\RequiredIf;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;


class UpdateUSerRequest extends FormRequest
{
    public function rules()
    {
        return [
            'user_name' => ['required','min:2', 'max:20'],
            'user_phone' => ['required','min:9','max:9','regex:/([0-9]{9})/u'],
            'user_email' => ['required','email'],
            'user_class' => ['required'],
            'user_image' => ['nullable', 'image','mimes:jpg,png,jpeg'],
            'user_credit' => new RequiredIf(Auth::user()->hasRole('administrator') || Auth::user()->hasRole('employee'))

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

    public function updateUser(User $user)
    {
        $picName = null;
            if($this->hasFile('user_image')){
                $picName = substr(time(), 0, -1) ."-". Str::slug($this->user_name) . "." . $this->file('user_image')->extension();

                $userDirectory = storage_path() . '/app/public/img/users/';
                if (!file_exists($userDirectory)) {
                    mkdir($userDirectory, 0755);
                }
                $picPath = $userDirectory . $picName;

                Image::make($this->file('user_image'))
                    ->resize(500, null, function ($constraint){
                        $constraint->aspectRatio();
                    })->save($picPath);
            }

        $user->update([
            'name' => $this->user_name,
            'phone' => $this->user_phone,
            'class' => $this->user_class,
            'email' => $this->user_email,
            'updated_at' => now()
        ]);

        if($picName != null){
            $user->update([
                'image' => $picName,
            ]);
        }

        if(Auth::user()->hasRole('administrator') || Auth::user()->hasRole('employee')){
            $user->update([
                'credit'=> $this->user_credit,
            ]);
        }
    }
}
