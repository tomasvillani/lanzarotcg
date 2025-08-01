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

    public function test_eliminar_intercambios_caducados()
    {
        // Crear usuarios
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Crear cartas para el intercambio viejo (a eliminar)
        $cartaVieja1 = Carta::factory()->create(['user_id' => $user1->id]);
        $cartaVieja2 = Carta::factory()->create(['user_id' => $user2->id]);

        // Crear cartas para el intercambio reciente (no eliminar)
        $cartaNueva1 = Carta::factory()->create(['user_id' => $user1->id]);
        $cartaNueva2 = Carta::factory()->create(['user_id' => $user2->id]);

        // Intercambio aceptado viejo (fecha pasada)
        $intercambioAceptadoViejo = Intercambio::factory()->create([
            'user_id' => $user1->id,
            'carta_id' => $cartaVieja1->id,
            'carta_ofrecida_id' => $cartaVieja2->id,
            'estado' => 'a',
            'fecha' => Carbon::now()->subDays(3), // 3 días atrás
        ]);

        // Intercambio pendiente con cartas distintas
        $intercambioPendiente = Intercambio::factory()->create([
            'user_id' => $user1->id,
            'carta_id' => $cartaVieja1->id,         // Involucra carta vieja 1 para que se borre
            'carta_ofrecida_id' => $cartaNueva1->id, // pero cartaNueva1 distinta para que no borre todo
            'estado' => 'p',
            'fecha' => Carbon::now()->subDays(1),
        ]);

        // Intercambio aceptado reciente (fecha futura, cartas distintas)
        $intercambioAceptadoReciente = Intercambio::factory()->create([
            'user_id' => $user2->id,
            'carta_id' => $cartaNueva1->id,
            'carta_ofrecida_id' => $cartaNueva2->id,
            'estado' => 'a',
            'fecha' => Carbon::now()->addDays(3), // 3 días adelante
        ]);

        // Ejecutar el comando que elimina intercambios caducados
        $this->artisan('intercambios:eliminar-caducados')
            ->assertExitCode(0);

        // Intercambio viejo y pendiente que involucra carta vieja1 deberían haber sido eliminados
        $this->assertDatabaseMissing('intercambios', ['id' => $intercambioAceptadoViejo->id]);
        $this->assertDatabaseMissing('intercambios', ['id' => $intercambioPendiente->id]);

        // Intercambio reciente NO debe eliminarse
        $this->assertDatabaseHas('intercambios', ['id' => $intercambioAceptadoReciente->id]);
    }
}
