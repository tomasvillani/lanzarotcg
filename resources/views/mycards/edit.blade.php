@extends('layouts.layout')

@section('title', 'Editar Carta: ' . $carta->nombre)

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Editar Carta</h2>

    <form action="{{ route('mycards.update', $carta) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Nombre --}}
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input 
                type="text" 
                id="nombre" 
                name="nombre" 
                class="form-control @error('nombre') is-invalid @enderror" 
                value="{{ old('nombre', $carta->nombre) }}" 
                required
            >
            @error('nombre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Categoría --}}
        <div class="mb-3">
            <label for="categoria" class="form-label">Categoría</label>
            <select 
                id="categoria" 
                name="categoria" 
                class="form-select @error('categoria') is-invalid @enderror" 
                required
            >
                <option value="">Selecciona una categoría</option>
                @foreach($categoriasAmigables as $key => $label)
                    <option value="{{ $key }}" {{ old('categoria', $carta->categoria) == $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            @error('categoria')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Descripción --}}
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea 
                id="descripcion" 
                name="descripcion" 
                rows="4" 
                class="form-control @error('descripcion') is-invalid @enderror"
            >{{ old('descripcion', $carta->descripcion) }}</textarea>
            @error('descripcion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Imagen --}}
        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen (opcional)</label>
            <input 
                type="file" 
                id="imagen" 
                name="imagen" 
                class="form-control @error('imagen') is-invalid @enderror" 
                accept="image/*"
            >
            @error('imagen')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            @if ($carta->imagen)
                <div class="mt-2">
                    <p>Imagen actual:</p>
                    <img src="{{ asset($carta->imagen) }}" alt="{{ $carta->nombre }}" style="max-width: 200px; height: auto; border-radius: 5px;">
                    
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" name="eliminar_imagen" id="eliminar_imagen" value="1">
                        <label class="form-check-label" for="eliminar_imagen">
                            Eliminar imagen actual
                        </label>
                    </div>
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Carta</button>
        <a href="{{ route('mycards.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
    </form>
</div>
@endsection
