@extends('layouts.layout')

@section('title', $card->nombre)

@section('content')
<div class="container my-5">

    @if($errors->any())
        <div class="alert alert-danger text-center">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

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
                @if ($card->isUnavailable())
                    <div class="alert alert-warning text-center">
                        Esta carta ya fue intercambiada.
                    </div>
                    <button class="btn btn-secondary btn-lg w-100" disabled>Intercambio no disponible</button>
                @else
                    @auth
                        @if (auth()->id() !== $card->user_id)
                            @if ($isUnavailable)
                                <div class="alert alert-secondary text-center">
                                    Esta carta ya está en un intercambio aceptado.
                                </div>
                            @elseif ($fuePropuestaAmi && $intercambioRecibido)
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
                            @if ($isUnavailable)
                                <div class="alert alert-secondary text-center">
                                    Esta carta ya está en un intercambio aceptado.
                                </div>
                            @else
                                <a href="{{ route('trades.received', $card) }}" class="btn btn-secondary btn-lg w-100">Ver interesados</a>
                            @endif
                        @endif
                    @else
                        @if ($isUnavailable)
                            <div class="alert alert-secondary text-center">
                                Esta carta ya está en un intercambio aceptado.
                            </div>
                        @else
                            <a href="{{ route('trades.create', $card) }}" class="btn btn-primary btn-lg w-100">¡Me interesa!</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
