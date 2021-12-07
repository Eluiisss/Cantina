<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Models\Nre;
use App\Models\Role;
use Illuminate\Validation\Rules\RequiredIf;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUSerRequest extends FormRequest
{
    public function rules()
    {
        return [
            'user_name' => ['required','min:2', 'max:20'],
            'user_phone' => ['required','min:9','max:9'],
            'user_email' => ['required','email'],
            'user_class' => ['required'],
            'user_credit' => new RequiredIf(Auth::user()->hasRole('administrator') || Auth::user()->hasRole('employee')),

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
            'updated_at' => now()
        ]);

        if(Auth::user()->hasRole('administrator') || Auth::user()->hasRole('employee')){
            $user->update([
                'credit'=> $this->credit,
            ]);
        }
    }
}
