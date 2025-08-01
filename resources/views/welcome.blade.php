@extends('layouts.layout')

@section('title', 'LanzaroTCG')

@section('content')
  <div id="carouselExample" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
    <div class="carousel-inner">

      <div class="carousel-item active" style="background-image: url('/img/pokemon.png'); background-size: cover; background-position: center; height: 400px;">
        <div class="carousel-caption">
          <div class="bg-dark bg-opacity-50 p-3 rounded">
            <h5>Pokémon TCG</h5>
            <a href="{{ url('/cards?categoria=pokemon') }}" class="btn btn-warning">Explorar Pokémon</a>
          </div>
        </div>
      </div>

      <div class="carousel-item" style="background-image: url('/img/onepiece.jpg'); background-size: cover; background-position: center; height: 400px;">
        <div class="carousel-caption">
          <div class="bg-dark bg-opacity-50 p-3 rounded">
            <h5>ONE PIECE Card Game</h5>
            <a href="{{ url('/cards?categoria=onepiece') }}" class="btn btn-danger">Ver Barajas de One Piece</a>
          </div>
        </div>
      </div>

      <div class="carousel-item" style="background-image: url('/img/digimon.jpg'); background-size: cover; background-position: center; height: 400px;">
        <div class="carousel-caption">
          <div class="bg-dark bg-opacity-50 p-3 rounded">
            <h5>Digimon Card Game</h5>
            <a href="{{ url('/cards?categoria=digimon') }}" class="btn btn-primary">Descubrir Digimon</a>
          </div>
        </div>
      </div>

      <div class="carousel-item" style="background-image: url('/img/magic.jpg'); background-size: cover; background-position: center; height: 400px;">
        <div class="carousel-caption">
          <div class="bg-dark bg-opacity-50 p-3 rounded">
            <h5>Magic: The Gathering</h5>
            <a href="{{ url('/cards?categoria=magic') }}" class="btn btn-success">Buscar Cartas Magic</a>
          </div>
        </div>
      </div>

    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Anterior</span>
    </button>

    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Siguiente</span>
    </button>
  </div>

  <div class="container mt-4 mb-5">
    <form id="searchForm" action="{{ url('/cards') }}" method="GET" class="d-flex justify-content-center">
      <input id="searchInput" class="form-control me-2" type="search" name="q" placeholder="Buscar por nombre, categoría o usuario" aria-label="Buscar" style="max-width: 500px;">
      <button class="btn btn-primary" type="submit">Buscar</button>
    </form>
  </div>

  <h1 class="mt-5 text-center">Bienvenido a LanzaroTCG</h1>
  <p class="text-center">Tu destino para explorar y descubrir cartas de tus juegos de cartas coleccionables favoritos.</p>

  <script>
    document.getElementById('searchForm').addEventListener('submit', function(e) {
      const query = document.getElementById('searchInput').value.trim();
      if (!query) {
        e.preventDefault();
      }
    });
  </script>
@endsection
