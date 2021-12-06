<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Models\Nre;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUSerRequest extends FormRequest
{
    public function rules()
    {
        return [
            'user_name' => ['required','min:2', 'max:20'],
            'user_phone' => ['required','min:9','max:9'],
            'user_email' => ['required','email'],
            'user_class' => ['required'],
            'user_credit' => ['required','min:0','max:100'],

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
        $user->update([
            'name' => $this->user_name,
            'phone' => $this->user_phone,
            'class' => $this->user_class,
            'email' => $this->user_email,
            'credit' => $this->user_credit,
            'updated_at' => now()
        ]);
    }
}
