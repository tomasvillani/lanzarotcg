<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Intercambio;
use App\Models\Carta;
use Carbon\Carbon;

class EliminarIntercambiosCaducados extends Command
{
    protected $signature = 'intercambios:eliminar-caducados';
    protected $description = 'Eliminar intercambios relacionados con cartas cuya fecha de intercambio + 1 día ya pasó, y eliminar las cartas involucradas';

    public function handle()
    {
        $hoy = Carbon::today();

        // Obtener intercambios aceptados
        $intercambiosAceptados = Intercambio::where('estado', 'a')->get();

        $totalIntercambiosEliminados = 0;
        $totalCartasEliminadas = 0;

        foreach ($intercambiosAceptados as $intercambio) {
            // Fecha + 1 día
            $fechaMasUnDia = Carbon::parse($intercambio->fecha)->addDay();

            // Si la fecha + 1 día es menor o igual a hoy, eliminar intercambios y cartas
            if ($fechaMasUnDia->lte($hoy)) {
                $carta1 = $intercambio->carta_id;
                $carta2 = $intercambio->carta_ofrecida_id;

                // Eliminar todos los intercambios relacionados con las dos cartas
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
        }

        $this->info("Intercambios eliminados: $totalIntercambiosEliminados");
        $this->info("Cartas eliminadas: $totalCartasEliminadas");

        return 0;
    }
}
