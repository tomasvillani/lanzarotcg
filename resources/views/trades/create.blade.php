@extends('layouts.layout')

@section('title', 'Proponer intercambio para: ' . $card->nombre)

@section('content')
<div class="container my-5">
    <h2>Proponer intercambio para <strong>{{ $card->nombre }}</strong></h2>

    <form action="{{ route('trades.store', $card) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="offered_card_id" class="form-label">Selecciona la carta que ofreces</label>
            <select name="offered_card_id" id="offered_card_id" class="form-select @error('offered_card_id') is-invalid @enderror" required>
                <option value="">-- Elige una carta --</option>
                @foreach($misCartas as $miCarta)
                    <option value="{{ $miCarta->id }}" {{ old('offered_card_id') == $miCarta->id ? 'selected' : '' }}>
                        {{ $miCarta->nombre }}
                    </option>
                @endforeach
            </select>
            @error('offered_card_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="fecha_intercambio" class="form-label">Fecha del intercambio</label>
            <input 
                type="date" 
                id="fecha_intercambio" 
                name="fecha_intercambio" 
                class="form-control @error('fecha_intercambio') is-invalid @enderror"
                min="{{ now()->addDay()->format('Y-m-d') }}"
                value="{{ old('fecha_intercambio') }}" 
                required
            >
            @error('fecha_intercambio')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="lugar" class="form-label">Lugar del intercambio</label>
            <input 
                type="text" 
                id="lugar" 
                name="lugar" 
                class="form-control @error('lugar') is-invalid @enderror" 
                value="{{ old('lugar') }}" 
                required
            >
            @error('lugar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Enviar propuesta</button>
        <a href="{{ route('cards.show', $card) }}" class="btn btn-secondary ms-2">Cancelar</a>
    </form>
</div>
@endsection
