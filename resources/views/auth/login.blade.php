@extends('layouts.layout')

@section('title', 'Iniciar sesión')

@section('content')
    <div class="container my-5 d-flex justify-content-center">
        <div class="card p-4 shadow" style="max-width: 400px; width: 100%; background-color: #e6f0ff;">

            <h2 class="text-center text-primary mb-4">Iniciar sesión</h2>

            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="form-control @error('email') is-invalid @enderror" />
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label fw-bold">Contraseña</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password" class="form-control @error('password') is-invalid @enderror" />
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="form-check mb-3">
                    <input type="checkbox" id="remember_me" name="remember" class="form-check-input" />
                    <label for="remember_me" class="form-check-label">Recordarme</label>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-decoration-underline small">¿Olvidaste la contraseña?</a>
                    @endif

                    <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                </div>
            </form>

            <div class="mt-3 text-center">
                <span>¿No tienes cuenta? </span><a href="{{ route('register') }}" class="text-decoration-underline fw-bold">Regístrate</a>
            </div>
        </div>
    </div>
@endsection
