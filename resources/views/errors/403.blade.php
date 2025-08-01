@extends('layouts.layout')

@section('title', 'Acceso denegado')

@section('content')
<div class="d-flex flex-column justify-content-center align-items-center vh-100 bg-light">
    <h1 class="display-1 text-warning">403</h1>
    <h2 class="mb-3">Acceso denegado</h2>
    <p class="mb-4">No tienes permiso para acceder a esta página.</p>
    <a href="{{ url('/') }}" class="btn btn-primary">Volver al inicio</a>
</div>
@endsection
