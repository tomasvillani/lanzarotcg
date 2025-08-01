<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Intercambio;

class IntercambioSeeder extends Seeder
{
    public function run()
    {
        // Crear 50 intercambios aleatorios
        Intercambio::factory()->count(50)->create();
    }
}
