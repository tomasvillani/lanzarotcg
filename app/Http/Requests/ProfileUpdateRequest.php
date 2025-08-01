<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Permitir que el usuario autorizado haga la petición
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:25',
                'regex:/^[a-z0-9_]+$/', // solo minúsculas, números y guion bajo, sin espacios
                Rule::unique('users')->ignore($this->user()->id),
            ],
            'email' => [
                'required',
                'string',
                'regex:/^[^@]+@[^@]+\.[^@]+$/',
                'max:255',
                Rule::unique('users')->ignore($this->user()->id),
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.min' => 'El nombre debe tener al menos 3 caracteres.',
            'name.max' => 'El nombre no puede exceder los 25 caracteres.',
            'name.regex' => 'El nombre solo puede contener letras minúsculas, números y guion bajo, sin espacios ni mayúsculas.',
            'name.unique' => 'Este nombre ya está en uso.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.regex' => 'Debe ingresar un correo electrónico válido.',
            'email.unique' => 'Este correo electrónico ya está en uso.',
        ];
    }
}
