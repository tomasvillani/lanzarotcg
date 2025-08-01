@extends('layouts.layout')

@section('title', 'Crear Nueva Carta')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Subir Nueva Carta</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('mycards.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" required>
        </div>

        <div class="mb-3">
            <label for="categoria" class="form-label">Categoría</label>
            <select name="categoria" id="categoria" class="form-select" required>
                <option value="" disabled {{ old('categoria') ? '' : 'selected' }}>Selecciona una categoría</option>
                <option value="pokemon" {{ old('categoria') == 'pokemon' ? 'selected' : '' }}>Pokémon</option>
                <option value="onepiece" {{ old('categoria') == 'onepiece' ? 'selected' : '' }}>One Piece</option>
                <option value="digimon" {{ old('categoria') == 'digimon' ? 'selected' : '' }}>Digimon</option>
                <option value="magic" {{ old('categoria') == 'magic' ? 'selected' : '' }}>Magic</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción (opcional)</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="3">{{ old('descripcion') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen (opcional)</label>
            <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Subir Carta</button>
        <a href="{{ route('mycards.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
    </form>
</div>
@endsection
