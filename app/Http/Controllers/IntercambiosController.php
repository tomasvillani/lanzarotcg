<?php

namespace App\Http\Controllers;

use App\Models\Carta;
use App\Models\Intercambio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class IntercambiosController extends Controller
{
    public function create(Carta $card)
    {
        // Verificar si la carta está disponible
        $isUnavailable = Intercambio::where('estado', 'a')
            ->where(function ($query) use ($card) {
                $query->where('carta_id', $card->id)
                    ->orWhere('carta_ofrecida_id', $card->id);
            })->exists();

        if ($isUnavailable) {
            return redirect()->route('cards.index')->withErrors('La carta no está disponible para intercambio.');
        }

        // Obtener solo cartas propias disponibles para ofrecer (filtrar también cartas no disponibles)
        $user = Auth::user();
        $misCartas = Carta::where('user_id', $user->id)
        ->whereDoesntHave('intercambiosOriginales', function ($q) {
            $q->where('estado', 'a');
        })
        ->whereDoesntHave('intercambiosOfrecidos', function ($q) {
            $q->where('estado', 'a');
        })
        ->get();

        return view('trades.create', compact('card', 'misCartas'));
    }

    public function store(Request $request, Carta $card)
    {
        $user = Auth::user();

        $request->validate([
            'offered_card_id' => [
                'required',
                Rule::exists('cartas', 'id')->where('user_id', $user->id),
                function ($attribute, $value, $fail) use ($card) {
                    if ($value == $card->id) {
                        $fail('La carta ofrecida no puede ser la misma que la carta solicitada.');
                    }
                }
            ],
            'fecha_intercambio' => [
                'required',
                'date',
                'after:tomorrow' // fecha a partir del día siguiente
            ],
            'lugar' => 'required|string|max:255',
        ]);

        // Validación extra para evitar intercambio consigo mismo
        if ($card->user_id == $user->id) {
            return redirect()->back()->withErrors(['offered_card_id' => 'No puedes proponer un intercambio para una carta que es tuya.']);
        }

        Intercambio::create([
            'user_id' => $user->id,
            'carta_ofrecida_id' => $request->offered_card_id,
            'carta_id' => $card->id,
            'fecha' => $request->fecha_intercambio,
            'lugar' => $request->lugar,
            'estado' => 'p', // pendiente
        ]);

        return redirect()->route('cards.show', $card)->with('success', 'Intercambio propuesto correctamente.');
    }

    // Propuestas realizadas por el usuario autenticado
    public function propuestos()
    {
        $user = Auth::user();

        $intercambios = Intercambio::with(['cartaOriginal', 'cartaOfrecida', 'cartaOriginal.user', 'cartaOfrecida.user'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(12);

        $categoriasAmigables = [
            'pokemon' => 'Pokémon',
            'onepiece' => 'One Piece',
            'digimon' => 'Digimon',
            'magic' => 'Magic',
        ];

        return view('trades.propuestos', compact('intercambios', 'categoriasAmigables'));
    }

    public function recibidos(Carta $card = null)
    {
        $user = Auth::user();

        $query = Intercambio::with(['cartaOriginal', 'cartaOfrecida', 'user', 'cartaOfrecida.user'])
            ->whereHas('cartaOriginal', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });

        if ($card) {
            // Verificar que el usuario sea dueño de la carta para filtrar
            if ($card->user_id !== $user->id) {
                abort(403, 'No tienes permiso para ver los intercambios recibidos para esta carta.');
            }
            $query->where('carta_id', $card->id);
        }

        $intercambios = $query->latest()->paginate(12);

        $categoriasAmigables = [
            'pokemon' => 'Pokémon',
            'onepiece' => 'One Piece',
            'digimon' => 'Digimon',
            'magic' => 'Magic',
        ];

        return view('trades.recibidos', compact('intercambios', 'categoriasAmigables', 'card'));
    }

    public function show(Intercambio $intercambio)
    {
        $user = auth()->user();

        $esPropuestoPorMi = $intercambio->user_id === $user->id;
        $esRecibidoPorMi = $intercambio->cartaOriginal->user_id === $user->id;

        if (!($esPropuestoPorMi || $esRecibidoPorMi)) {
            abort(403, 'No tienes permiso para ver este intercambio.');
        }

        $categoriasAmigables = [
            'pokemon' => 'Pokémon',
            'onepiece' => 'One Piece',
            'digimon' => 'Digimon',
            'magic' => 'Magic',
        ];

        return view('trades.show', compact('intercambio', 'categoriasAmigables'));
    }

    public function aceptar(Intercambio $intercambio)
    {
        $user = Auth::user();

        if ($intercambio->estado !== 'p' || $intercambio->cartaOriginal->user_id !== $user->id) {
            abort(403, 'No tienes permiso para aceptar este intercambio.');
        }

        // Aceptar este intercambio
        $intercambio->update(['estado' => 'a']);

        // Rechazar cualquier otro intercambio pendiente que involucre cualquiera de las dos cartas
        Intercambio::where('estado', 'p')
            ->where(function ($q) use ($intercambio) {
                $q->where('carta_id', $intercambio->carta_id)
                ->orWhere('carta_ofrecida_id', $intercambio->carta_id)
                ->orWhere('carta_id', $intercambio->carta_ofrecida_id)
                ->orWhere('carta_ofrecida_id', $intercambio->carta_ofrecida_id);
            })
            ->where('id', '!=', $intercambio->id)
            ->update(['estado' => 'r']); // r = rechazado

        return redirect()->route('trades.show', $intercambio)->with('success', 'Intercambio aceptado. Otros intercambios relacionados han sido rechazados.');
    }

    public function rechazar(Intercambio $intercambio)
    {
        $user = Auth::user();

        if ($intercambio->estado !== 'p' || $intercambio->cartaOriginal->user_id !== $user->id) {
            abort(403, 'No tienes permiso para rechazar este intercambio.');
        }

        $intercambio->update(['estado' => 'r']); // r = rechazado

        return redirect()->route('trades.show', $intercambio)->with('success', 'Intercambio rechazado correctamente.');
    }

}
