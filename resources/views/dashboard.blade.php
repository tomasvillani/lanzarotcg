@extends('layouts.layout')

@section('title', 'Panel de Usuario')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">

            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Bienvenido al Panel</h4>
                </div>
                <div class="card-body text-center">
                    <h5 class="card-title">¡Hola, {{ Auth::user()->name }}!</h5>
                    <p class="card-text">Has iniciado sesión correctamente.</p>

                    <div class="d-grid gap-2 d-md-flex justify-content-center mt-4 flex-wrap">
                        <a href="{{ url('/cards') }}" class="btn btn-outline-primary me-md-2 mb-2">Explorar Cartas</a>
                        <a href="{{ url('/mycards') }}" class="btn btn-outline-secondary me-md-2 mb-2">Mis Cartas</a>

                        <!-- Botones separados para intercambios -->
                        <a href="{{ url('/trades/sent') }}" class="btn btn-outline-success me-md-2 mb-2">Intercambios Propuestos</a>
                        <a href="{{ url('/trades/received') }}" class="btn btn-outline-warning me-md-2 mb-2">Intercambios Recibidos</a>

                        <a href="/profile" class="btn btn-outline-info me-md-2 mb-2">Perfil</a>

                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger mb-2">Cerrar Sesión</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <small class="text-muted">¿No ves lo que buscas? Revisa el menú o contacta con el soporte.</small>
            </div>
        </div>
    </div>
</div>
@endsection
