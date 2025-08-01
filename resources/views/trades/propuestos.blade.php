@extends('layouts.layout')

@section('title', 'Intercambios Propuestos')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Intercambios Propuestos</h2>

    @if ($intercambios->count())
        <div class="row">
            @foreach ($intercambios as $intercambio)
                @php
                    $card = $intercambio->cartaOriginal;
                @endphp
                <div class="col-12 col-md-3 mb-4">
                    <div class="card h-100">
                        <img src="{{ $card->imagen ? asset($card->imagen) : asset('img/default-card.png') }}" class="card-img-top" alt="{{ $card->nombre }}">
                        <div class="card-body">
                            <h5 class="card-title text-center">{{ $card->nombre }}</h5>
                            <p><i class="bi bi-tags"></i> {{ $categoriasAmigables[$card->categoria] ?? ucfirst($card->categoria) }}</p>
                            <p><i class="bi bi-person-circle"></i> {{ $card->user->name }}</p>

                            <div class="text-center mt-3">
                                <a href="{{ route('trades.show', $intercambio->id) }}" class="btn btn-outline-primary btn-sm">Ver más</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $intercambios->links() }}
        </div>
    @else
        <p class="text-center fs-5">No has propuesto ningún intercambio aún.</p>
    @endif
</div>
@endsection
