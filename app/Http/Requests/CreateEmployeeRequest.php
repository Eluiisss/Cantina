<?php

namespace App\Http\Requests;

use App\Models\{Nre, Role,User};
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;



class CreateEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'nre' => ['required',],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];

    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe de ser una cadena de caracteres válido.',
            'name.max' => 'El nombre no debe sobrepasar los 255 caracteres.',

            'nre.required' => 'El numero de empleado es obligatorio.',

            'email.required' => 'El email es obligatorio.',
            'email.string' => 'El email debe ser de caracter alfanumérico.',
            'email.email' => 'El email introducido no es válido.',
            'email.max' => 'El email no debe sobrepasar los 255 caracteres.',
            'email.unique' => 'El email introducido ya existe en nuestra Base de Datos.',

            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ];
    }

    public function createEmp()
    {
        DB::transaction(function () {
            $nre = Nre::factory()->create([
                'nre' => $this->nre,
            ]);
            $user = User::factory()->create([
                'name' => $this->name,
                'nre_id' => $nre->id,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);
            $nre->update([
                'user_id' => $user->id,
                'updated_at' => now(),
            ]);
            $user->attachRole('employee');
            

        });

       
    }
}