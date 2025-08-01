@extends('layouts.layout')

@section('title', 'Mis Cartas')

@section('content')
<div class="container my-5">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Mis Cartas</h2>
        <a href="{{ route('mycards.create') }}" class="btn btn-success">Subir Nueva Carta</a>
    </div>

    @if ($cartas->count() > 0)
        <div class="row">
            @foreach ($cartas as $carta)
                <div class="col-12 col-md-3 mb-4">
                    <div class="card h-100">

                        @if ($carta->imagen)
                            <img src="{{ asset($carta->imagen) }}" class="card-img-top" alt="{{ $carta->nombre }}" style="object-fit: cover; height: 250px;">
                        @else
                            <img src="{{ asset('img/default-card.png') }}" class="card-img-top" alt="Sin imagen" style="object-fit: cover; height: 250px;">
                        @endif

                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="card-title text-center">{{ $carta->nombre }}</h5>

                                <p class="mb-1">
                                    <i class="bi bi-tags"></i>
                                    <span class="ms-1">{{ $categoriasAmigables[$carta->categoria] ?? ucfirst($carta->categoria) }}</span>
                                </p>
                            </div>

                            <div class="d-flex justify-content-between mt-3">
                                <a href="{{ route('mycards.edit', $carta) }}" class="btn btn-outline-warning btn-sm">Editar</a>
                                <a href="{{ route('cards.show', $carta) }}" class="btn btn-outline-primary btn-sm">Ver más</a>

                                <form action="{{ route('mycards.destroy', $carta) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar esta carta?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Eliminar</button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center">
            {{ $cartas->links() }}
        </div>

    @else
        <p class="text-center fs-5 mt-5">No has subido cartas todavía.</p>
        <div class="text-center">
            <a href="{{ route('mycards.create') }}" class="btn btn-success">Subir tu primera carta</a>
        </div>
    @endif

</div>
@endsection
