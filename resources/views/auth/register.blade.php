@extends('layouts.layout')

@section('title', 'Registrarse')

@section('content')
    <div class="d-flex justify-content-center align-items-center vh-100 bg-light">
        <div class="card shadow-sm p-4" style="max-width: 500px; width: 100%; background-color: #e9f2fb;">
            <h2 class="text-center text-primary mb-4">Crear una cuenta</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Nombre -->
                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Nombre</label>
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Correo electrónico</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Contraseña -->
                <div class="mb-3">
                    <label for="password" class="form-label fw-bold">Contraseña</label>
                    <input id="password" type="password" class="form-control" name="password" required>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirmar contraseña -->
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label fw-bold">Confirmar contraseña</label>
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                    @error('password_confirmation')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('login') }}" class="text-decoration-none small text-primary">¿Ya tienes cuenta? Inicia sesión</a>
                    <button type="submit" class="btn btn-primary">Registrarse</button>
                </div>
            </form>
        </div>
    </div>
@endsection
