<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Intercambio;
use App\Models\Carta;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class EliminarIntercambiosCaducadosTest extends TestCase
{
    use RefreshDatabase;

    public function test_eliminar_intercambios_caducados_y_cartas_relacionadas()
    {
        // Crear usuarios
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Cartas para el intercambio viejo (deberían eliminarse)
        $cartaVieja1 = Carta::factory()->create(['user_id' => $user1->id]);
        $cartaVieja2 = Carta::factory()->create(['user_id' => $user2->id]);

        // Cartas para el intercambio reciente (no eliminar)
        $cartaNueva1 = Carta::factory()->create(['user_id' => $user1->id]);
        $cartaNueva2 = Carta::factory()->create(['user_id' => $user2->id]);

        // Intercambio aceptado viejo (fecha pasada: hoy - 3 días)
        $intercambioAceptadoViejo = Intercambio::factory()->create([
            'user_id' => $user1->id,
            'carta_id' => $cartaVieja1->id,
            'carta_ofrecida_id' => $cartaVieja2->id,
            'estado' => 'a',
            'fecha' => Carbon::now()->subDays(3),
        ]);

        // Intercambio pendiente que involucra cartaVieja1 (también debería borrarse)
        $intercambioPendiente = Intercambio::factory()->create([
            'user_id' => $user1->id,
            'carta_id' => $cartaVieja1->id,
            'carta_ofrecida_id' => $cartaNueva1->id,
            'estado' => 'p',
            'fecha' => Carbon::now()->subDays(1),
        ]);

        // Intercambio aceptado reciente (fecha futura, no eliminar)
        $intercambioAceptadoReciente = Intercambio::factory()->create([
            'user_id' => $user2->id,
            'carta_id' => $cartaNueva1->id,
            'carta_ofrecida_id' => $cartaNueva2->id,
            'estado' => 'a',
            'fecha' => Carbon::now()->addDays(3),
        ]);

        // Ejecutar el comando
        $this->artisan('intercambios:eliminar-caducados')->assertExitCode(0);

        // El intercambio viejo aceptado y el pendiente relacionado con cartaVieja1 deben ser eliminados
        $this->assertDatabaseMissing('intercambios', ['id' => $intercambioAceptadoViejo->id]);
        $this->assertDatabaseMissing('intercambios', ['id' => $intercambioPendiente->id]);

        // Las cartas viejas deben haber sido eliminadas
        $this->assertDatabaseMissing('cartas', ['id' => $cartaVieja1->id]);
        $this->assertDatabaseMissing('cartas', ['id' => $cartaVieja2->id]);

        // El intercambio reciente y sus cartas NO deben eliminarse
        $this->assertDatabaseHas('intercambios', ['id' => $intercambioAceptadoReciente->id]);
        $this->assertDatabaseHas('cartas', ['id' => $cartaNueva1->id]);
        $this->assertDatabaseHas('cartas', ['id' => $cartaNueva2->id]);
    }
}
