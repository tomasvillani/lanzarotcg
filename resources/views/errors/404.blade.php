@extends('layouts.layout')

@section('title', 'Página no encontrada')

@section('content')
<div class="d-flex flex-column justify-content-center align-items-center vh-100 bg-light">
    <h1 class="display-1 text-danger">404</h1>
    <h2 class="mb-3">Página no encontrada</h2>
    <p class="mb-4">La página que buscas no existe o fue movida.</p>
    <a href="{{ url('/') }}" class="btn btn-primary">Volver al inicio</a>
</div>
@endsection
