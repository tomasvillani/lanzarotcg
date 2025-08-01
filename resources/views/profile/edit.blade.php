@extends('layouts.layout')

@section('title', 'Perfil de Usuario')

@section('content')
<div class="container my-5">
    <h2 class="mb-4 text-center">Perfil</h2>

    @if ($errors->has('password'))
        <div class="alert alert-danger">
            La contraseña ingresada es incorrecta. No se eliminó la cuenta.
        </div>
    @endif

    <div class="row justify-content-center gy-4">
        <div class="col-md-8">

            {{-- Información de perfil --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Información del Perfil</h5>
                    <p class="small text-muted mb-0">Actualiza la información de tu perfil y correo electrónico.</p>
                </div>
                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Actualizar contraseña --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Actualizar Contraseña</h5>
                    <p class="small text-muted mb-0">Asegúrate de usar una contraseña larga y segura.</p>
                </div>
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Eliminar cuenta --}}
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0 text-danger">Eliminar Cuenta</h5>
                    <p class="small text-muted mb-0">Una vez eliminada, no podrás recuperar tu cuenta ni datos.</p>
                </div>
                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
