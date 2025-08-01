<?php

namespace App\Http\Controllers;

use App\Models\Carta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MisCartasController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $cartas = Carta::where('user_id', $user->id)
            ->orderBy('created_at', 'desc') // Mostrar primero las más recientes
            ->paginate(12);

        $categoriasAmigables = [
            'pokemon' => 'Pokémon',
            'onepiece' => 'One Piece',
            'digimon' => 'Digimon',
            'magic' => 'Magic',
        ];

        return view('mycards.index', compact('cartas', 'categoriasAmigables'));
    }

    public function create()
    {
        return view('mycards.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('nombre', 'categoria', 'descripcion');
        $data['user_id'] = Auth::id();

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('cartas', 'public');
            $data['imagen'] = 'storage/' . $path;
        }

        Carta::create($data);

        return redirect()->route('mycards.index')->with('success', 'Carta creada correctamente.');
    }

    public function edit(Carta $carta)
    {
        if ($carta->user_id !== Auth::id()) {
            abort(403);
        }

        $categoriasAmigables = [
            'pokemon' => 'Pokémon',
            'onepiece' => 'One Piece',
            'digimon' => 'Digimon',
            'magic' => 'Magic',
        ];

        return view('mycards.edit', compact('carta', 'categoriasAmigables'));
    }

    public function update(Request $request, Carta $carta)
    {
        if ($carta->user_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|max:2048',
            'eliminar_imagen' => 'nullable|boolean',
        ]);

        if ($request->has('eliminar_imagen') && $request->input('eliminar_imagen')) {
            if ($carta->imagen) {
                $storagePath = str_replace('storage/', 'public/', $carta->imagen);
                if (Storage::exists($storagePath)) {
                    Storage::delete($storagePath);
                }
            }
            $data['imagen'] = null;
        }

        if ($request->hasFile('imagen')) {
            if ($carta->imagen) {
                $storagePath = str_replace('storage/', 'public/', $carta->imagen);
                if (Storage::exists($storagePath)) {
                    Storage::delete($storagePath);
                }
            }
            $path = $request->file('imagen')->store('cartas', 'public');
            $data['imagen'] = 'storage/' . $path;
        }

        $carta->update($data);

        return redirect()->route('mycards.index')->with('success', 'Carta actualizada correctamente.');
    }

    public function destroy(Carta $carta)
    {
        if ($carta->user_id !== Auth::id()) {
            abort(403);
        }

        if ($carta->imagen) {
            $storagePath = str_replace('storage/', '', $carta->imagen);
            if (Storage::disk('public')->exists($storagePath)) {
                Storage::disk('public')->delete($storagePath);
            }
        }

        $carta->delete();

        return redirect()->route('mycards.index')->with('success', 'Carta eliminada correctamente.');
    }
}
