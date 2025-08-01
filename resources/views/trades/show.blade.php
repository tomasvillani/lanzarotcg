@extends('layouts.layout')

@section('title', 'Detalles del Intercambio')

@section('content')
<div class="container my-5">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h2>Intercambio propuesto</h2>

    <div class="row mb-4">
        <div class="col-md-6">
            <h4>Carta solicitada</h4>
            <div class="card">
                <img src="{{ $intercambio->cartaOriginal->imagen ? asset($intercambio->cartaOriginal->imagen) : asset('img/default-card.png') }}" class="card-img-top" alt="{{ $intercambio->cartaOriginal->nombre }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $intercambio->cartaOriginal->nombre }}</h5>
                    <p><strong>Categoría:</strong> {{ $categoriasAmigables[$intercambio->cartaOriginal->categoria] ?? ucfirst($intercambio->cartaOriginal->categoria) }}</p>
                    <p><strong>Dueño:</strong> {{ $intercambio->cartaOriginal->user->name }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <h4>Carta ofrecida</h4>
            <div class="card">
                <img src="{{ $intercambio->cartaOfrecida->imagen ? asset($intercambio->cartaOfrecida->imagen) : asset('img/default-card.png') }}" class="card-img-top" alt="{{ $intercambio->cartaOfrecida->nombre }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $intercambio->cartaOfrecida->nombre }}</h5>
                    <p><strong>Categoría:</strong> {{ $categoriasAmigables[$intercambio->cartaOfrecida->categoria] ?? ucfirst($intercambio->cartaOfrecida->categoria) }}</p>
                    <p><strong>Dueño:</strong> {{ $intercambio->cartaOfrecida->user->name }}</p>
                </div>
            </div>
        </div>
    </div>

    <p><strong>Fecha del intercambio:</strong> {{ \Carbon\Carbon::parse($intercambio->fecha)->format('d/m/Y') }}</p>
    <p><strong>Lugar:</strong> {{ $intercambio->lugar }}</p>
    <p><strong>Estado:</strong> 
        @if($intercambio->estado == 'p') Pendiente
        @elseif($intercambio->estado == 'a') Aceptado
        @else Rechazado
        @endif
    </p>

    @if($intercambio->estado === 'p' && $intercambio->cartaOriginal->user_id === auth()->id())
        <div class="mt-4 d-flex gap-3">
            <form action="{{ route('trades.accept', $intercambio->id) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres aceptar este intercambio?');">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-success">Aceptar</button>
            </form>

            <form action="{{ route('trades.reject', $intercambio->id) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres rechazar este intercambio?');">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-danger">Rechazar</button>
            </form>
        </div>
    @endif

</div>
@endsection
