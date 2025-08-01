@extends('layouts.layout')

@section('title', 'Intercambios Recibidos')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">
        Intercambios recibidos
        @if(isset($card))
            para <strong>{{ $card->nombre }}</strong>
        @endif
    </h2>

    @if ($intercambios->count())
        <div class="row">
            @foreach ($intercambios as $intercambio)
                @php
                    $cartaOriginal = $intercambio->cartaOriginal;
                    $cartaOfrecida = $intercambio->cartaOfrecida;
                @endphp
                <div class="col-12 col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="row g-0">
                            <div class="col-6 border-end d-flex flex-column align-items-center justify-content-center p-3">
                                <h5 class="text-center">Carta que tienes</h5>
                                <img src="{{ $cartaOriginal->imagen ? asset($cartaOriginal->imagen) : asset('img/default-card.png') }}" alt="{{ $cartaOriginal->nombre }}" class="img-fluid mb-2" style="max-height: 180px;">
                                <h6>{{ $cartaOriginal->nombre }}</h6>
                                <p class="mb-1"><i class="bi bi-tags"></i> {{ $categoriasAmigables[$cartaOriginal->categoria] ?? ucfirst($cartaOriginal->categoria) }}</p>
                                <p class="mb-0"><i class="bi bi-person-circle"></i> {{ $cartaOriginal->user->name }}</p>
                            </div>
                            <div class="col-6 d-flex flex-column align-items-center justify-content-center p-3">
                                <h5 class="text-center">Carta ofrecida</h5>
                                <img src="{{ $cartaOfrecida->imagen ? asset($cartaOfrecida->imagen) : asset('img/default-card.png') }}" alt="{{ $cartaOfrecida->nombre }}" class="img-fluid mb-2" style="max-height: 180px;">
                                <h6>{{ $cartaOfrecida->nombre }}</h6>
                                <p class="mb-1"><i class="bi bi-tags"></i> {{ $categoriasAmigables[$cartaOfrecida->categoria] ?? ucfirst($cartaOfrecida->categoria) }}</p>
                                <p class="mb-0"><i class="bi bi-person-circle"></i> {{ $cartaOfrecida->user->name }}</p>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-center gap-2">
                            <a href="{{ route('trades.show', $intercambio->id) }}" class="btn btn-outline-primary btn-sm">Ver más</a>

                            @if ($intercambio->estado === 'p')
                                <form action="{{ route('trades.accept', $intercambio->id) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres aceptar este intercambio?');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm">Aceptar</button>
                                </form>

                                <form action="{{ route('trades.reject', $intercambio->id) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres rechazar este intercambio?');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-danger btn-sm">Rechazar</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $intercambios->links() }}
        </div>
    @else
        <p class="text-center fs-5">No tienes intercambios recibidos por ahora.</p>
    @endif
</div>
@endsection
