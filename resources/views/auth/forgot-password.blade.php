@extends('layouts.layout')

@section('content')
    <div class="container my-5 d-flex justify-content-center">
        <div class="card p-4 shadow" style="max-width: 400px; width: 100%; background-color: #e6f0ff;">

            <p class="mb-4 text-secondary">
            {{ __('¿Olvidaste tu contraseña? No hay problema. Solo dinos tu dirección de correo electrónico y te enviaremos un enlace para restablecer la contraseña que te permitirá elegir una nueva.') }}
            </p>

            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-3">
                <label for="email" class="form-label fw-bold">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                class="form-control @error('email') is-invalid @enderror" />
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-primary">
                {{ __('Enviar enlace para restablecer contraseña') }}
                </button>
            </div>
            </form>
        </div>
    </div>
@endsection
