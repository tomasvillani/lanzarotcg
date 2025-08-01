<?php

namespace App\Http\Controllers;

use App\Models\Carta;
use Illuminate\Http\Request;
use App\Models\Intercambio;

class CartasController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        $categoria = $request->input('categoria');

        $categoriasAmigables = [
            'pokemon' => 'Pokémon',
            'onepiece' => 'One Piece',
            'digimon' => 'Digimon',
            'magic' => 'Magic',
        ];

        $cardsQuery = Carta::query();

        if ($categoria) {
            $cardsQuery->where('categoria', $categoria);
        }

        if ($query) {
            $cardsQuery->where(function ($q) use ($query) {
                $q->where('nombre', 'like', "%$query%")
                ->orWhere('categoria', 'like', "%$query%")
                ->orWhereHas('user', function($q2) use ($query) {
                    $q2->where('name', 'like', "%$query%");
                });
            });
        }

        // Aquí agregas el orden por más reciente primero:
        $cardsQuery->orderBy('created_at', 'desc');

        $cards = $cardsQuery->paginate(12);


        // Aquí enviamos una variable booleana para saber si hubo búsqueda o filtro
        $hasFilter = $query || $categoria;

        $idsNoDisponibles = Intercambio::where('estado', 'a')
            ->pluck('carta_id')
            ->merge(Intercambio::where('estado', 'a')->pluck('carta_ofrecida_id'))
            ->unique();

        return view('cards.index', compact('cards', 'categoria', 'query', 'hasFilter', 'categoriasAmigables', 'idsNoDisponibles'));

    }

    public function show($id)
    {

        $card = Carta::with('user')->findOrFail($id);

        // Verificar si está en un intercambio aceptado
        $isUnavailable = Intercambio::where('estado', 'a')
            ->where(function ($query) use ($card) {
                $query->where('carta_id', $card->id)
                    ->orWhere('carta_ofrecida_id', $card->id);
            })->exists();

        if ($isUnavailable) {
            // Opcional: puedes mostrar un mensaje de que la carta no está disponible o simplemente abortar
            abort(403, 'Esta carta ya fue intercambiada y no está disponible.');
        }

        $categoriasAmigables = [
            'pokemon' => 'Pokémon',
            'onepiece' => 'One Piece',
            'digimon' => 'Digimon',
            'magic' => 'Magic',
        ];

        $user = auth()->user();

        $yaPropuesto = false;
        $intercambio = null;
        $fuePropuestaAmi = false;
        $intercambioRecibido = null;

        if ($user && $user->id !== $card->user_id) {
            // 1. Verificar si yo ya propuse intercambio por esta carta
            $intercambio = Intercambio::where('user_id', $user->id)
                ->where('carta_id', $card->id)
                ->where('estado', 'p') // Solo pendientes
                ->first();

            $yaPropuesto = $intercambio !== null;

            // 2. Verificar si alguien más usó esta carta para proponerme un intercambio
            $intercambioRecibido = Intercambio::where('carta_ofrecida_id', $card->id)
                ->whereHas('cartaOriginal', function ($query) use ($user) {
                    $query->where('user_id', $user->id); // Mi carta
                })
                ->where('estado', 'p') // Solo pendientes
                ->first();

            $fuePropuestaAmi = $intercambioRecibido !== null;
        }

        return view('cards.show', compact(
            'card',
            'categoriasAmigables',
            'yaPropuesto',
            'intercambio',
            'fuePropuestaAmi',
            'intercambioRecibido'
        ));
    }

}

