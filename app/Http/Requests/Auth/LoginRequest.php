<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function authenticate()
    {
        // Primero validamos que el email exista
        $user = User::where('email', $this->input('email'))->first();

        if (! $user) {
            throw ValidationException::withMessages([
                'email' => __('El correo electrónico no está registrado.'),
            ]);
        }

        // Si el usuario existe, intentamos el login
        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            throw ValidationException::withMessages([
                'password' => __('La contraseña es incorrecta.'),
            ]);
        }

        $this->session()->regenerate();
    }
}
