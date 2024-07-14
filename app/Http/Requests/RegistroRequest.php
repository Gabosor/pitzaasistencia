<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password as PasswordRules;

class RegistroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        
        return [
            //
            'ci' => ['required', 'string', 'unique:clients,ci'],
            
            'nombres' => ['required', 'string'],
            'apellidos' => ['required', 'string'],
            'telefono' => ['required'],
            'email' => ['required', 'email'],
            
        ];
    }
    public function messages()
    {
        return [
            'ci' => 'El ci es obligatorio',
            'ci.unique' => 'El cliente ya esta registrado',
            'nombres' => 'El nombre es obligatorio',
            'apellidos' => 'El nombre es obligatorio',
            'telefono' => 'El telefono es obligatorio',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El email no es valido',
        ]   ;
    }
}
