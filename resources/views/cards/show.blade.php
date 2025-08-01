@extends('layouts.layout')

@section('title', $card->nombre)

@section('content')
<div class="container my-5">
    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-5">
            <img src="{{ $card->imagen ? asset($card->imagen) : asset('img/default-card.png') }}" 
                 alt="{{ $card->nombre }}" class="img-fluid rounded">
        </div>
        <div class="col-md-7 d-flex flex-column justify-content-between">
            <div>
                <h2>{{ $card->nombre }}</h2>

                <p>
                    <i class="bi bi-tags"></i>
                    <strong>Categoría:</strong> {{ $categoriasAmigables[$card->categoria] ?? ucfirst($card->categoria) }}
                </p>

                <p>
                    <i class="bi bi-person-circle"></i>
                    <strong>Usuario:</strong> {{ $card->user->name }}
                </p>

                <p>
                    <strong>Descripción:</strong><br>
                    {{ $card->descripcion ?? 'Sin descripción disponible.' }}
                </p>
            </div>

            <div class="mt-4">
                @auth
                    @if (auth()->id() !== $card->user_id)
                        @if ($fuePropuestaAmi && $intercambioRecibido)
                            <div class="alert alert-success text-center">
                                Te han propuesto un intercambio con esta carta
                            </div>
                            <a href="{{ route('trades.show', $intercambioRecibido->id) }}" class="btn btn-success btn-lg w-100">
                                Ver propuesta recibida
                            </a>
                        @elseif ($yaPropuesto && $intercambio)
                            <a href="{{ route('trades.show', $intercambio->id) }}" class="btn btn-secondary btn-lg w-100">
                                Ya has propuesto un intercambio - Ver detalle
                            </a>
                        @else
                            <a href="{{ route('trades.create', $card) }}" class="btn btn-primary btn-lg w-100">¡Me interesa!</a>
                        @endif
                    @else
                        <a href="{{ route('trades.received', $card) }}" class="btn btn-secondary btn-lg w-100">Ver interesados</a>
                    @endif
                @else
                    <a href="{{ route('trades.create', $card) }}" class="btn btn-primary btn-lg w-100">¡Me interesa!</a>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection
