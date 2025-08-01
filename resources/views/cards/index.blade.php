@extends('layouts.layout')

@section('title', 'Cartas')

@section('content')
  <div class="container mt-4 mb-5">
    <form id="searchForm" action="{{ url('/cards') }}" method="GET" class="d-flex justify-content-center">
      <input id="searchInput" class="form-control me-2" type="search" name="q" placeholder="Buscar por nombre, categoría o usuario" aria-label="Buscar" style="max-width: 500px;" value="{{ old('q', $query) }}">
      <button class="btn btn-primary" type="submit">Buscar</button>
    </form>
  </div>

  @if ($cards->count() > 0)
        <!-- Mostrar cartas -->
        <div class="container">
          <div class="row">
              @foreach ($cards as $card)
              @php
                $noDisponible = $idsNoDisponibles->contains($card->id);
              @endphp
              <div class="col-6 col-md-3 mb-4">
                  <div class="card h-100 {{ $noDisponible ? 'opacity-50' : '' }}" style="{{ $noDisponible ? 'pointer-events: none;' : '' }}">
                    <img src="{{ $card->imagen ? asset($card->imagen) : asset('img/default-card.png') }}" class="card-img-top" alt="{{ $card->nombre }}">
                    <div class="card-body d-flex flex-column">
                      <h5 class="card-title text-center">{{ $card->nombre }}</h5>

                      <p class="card-text mb-1">
                          <i class="bi bi-tags"></i>
                          {{ $categoriasAmigables[$card->categoria] ?? ucfirst($card->categoria) }}
                      </p>

                      <p class="card-text mb-2">
                          <i class="bi bi-person-circle"></i>
                          {{ $card->user->name }}
                      </p>

                      <div class="text-center mt-auto">
                        @if ($noDisponible)
                          <button class="btn btn-secondary btn-sm" disabled>No disponible</button>
                        @else
                          <a href="{{ route('cards.show', $card) }}" class="btn btn-outline-primary btn-sm">Ver más</a>
                        @endif
                      </div>
                    </div>
                  </div>
              </div>
              @endforeach
          </div>

          <div class="d-flex justify-content-center mt-4">
            {{ $cards->withQueryString()->onEachSide(1)->links('pagination::bootstrap-5') }}
          </div>
        </div>
    @else
        <div class="container mt-5">
        @if ($hasFilter)
            <p class="text-center fs-4">No se encontraron cartas publicadas para esta búsqueda o categoría.</p>
        @else
            <p class="text-center fs-4">No se encontraron cartas publicadas.</p>
        @endif
        </div>
    @endif

  <script>
    document.getElementById('searchForm').addEventListener('submit', function(e) {
      const query = document.getElementById('searchInput').value.trim();
      if (!query) {
        e.preventDefault();
      }
    });
  </script>
@endsection
