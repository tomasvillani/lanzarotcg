@extends('layouts.layout')

@section('title', 'Error del servidor')

@section('content')
<div class="d-flex flex-column justify-content-center align-items-center vh-100 bg-light">
    <h1 class="display-1 text-danger">500</h1>
    <h2 class="mb-3">Error interno del servidor</h2>
    <p class="mb-4">Algo salió mal. Por favor, intenta de nuevo más tarde.</p>
    <a href="{{ url('/') }}" class="btn btn-primary">Volver al inicio</a>
</div>
@endsection
