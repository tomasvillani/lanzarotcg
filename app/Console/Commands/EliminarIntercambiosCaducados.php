<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Intercambio;
use App\Models\Carta;
use Carbon\Carbon;

class EliminarIntercambiosCaducados extends Command
{
    protected $signature = 'intercambios:eliminar-caducados';
    protected $description = 'Eliminar intercambios y cartas cuando un intercambio aceptado tenga más de 1 día desde su fecha';

    public function handle()
    {
        $hoy = Carbon::today();

        // Intercambios aceptados cuya fecha es menor o igual a ayer (hoy - 1 día)
        $intercambiosCaducados = Intercambio::where('estado', 'a')
            ->whereDate('fecha', '<=', $hoy->copy()->subDay())
            ->get();

        $totalIntercambiosEliminados = 0;
        $totalCartasEliminadas = 0;

        foreach ($intercambiosCaducados as $intercambio) {
            $carta1 = $intercambio->carta_id;
            $carta2 = $intercambio->carta_ofrecida_id;

            // Eliminar intercambios relacionados con esas cartas
            $eliminados = Intercambio::where(function ($query) use ($carta1, $carta2) {
                $query->where('carta_id', $carta1)
                      ->orWhere('carta_ofrecida_id', $carta1)
                      ->orWhere('carta_id', $carta2)
                      ->orWhere('carta_ofrecida_id', $carta2);
            })->delete();

            $totalIntercambiosEliminados += $eliminados;

            // Eliminar las cartas involucradas
            $cartasEliminadas = Carta::whereIn('id', [$carta1, $carta2])->delete();

            $totalCartasEliminadas += $cartasEliminadas;
        }

        $this->info("Intercambios eliminados: $totalIntercambiosEliminados");
        $this->info("Cartas eliminadas: $totalCartasEliminadas");

        return 0;
    }
}
