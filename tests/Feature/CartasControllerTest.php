<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Carta;
use App\Models\Intercambio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartasControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_shows_cards_index_without_filters()
    {
        Carta::factory()->count(3)->create();

        $response = $this->get('/cards');

        $response->assertStatus(200);
        $response->assertViewIs('cards.index');
        $response->assertViewHas('cards');
    }

    public function test_it_filters_cards_by_category()
    {
        Carta::factory()->create(['categoria' => 'pokemon']);
        Carta::factory()->create(['categoria' => 'magic']);

        $response = $this->get('/cards?categoria=pokemon');

        $response->assertStatus(200);
        $this->assertCount(1, $response->viewData('cards'));
    }

    public function test_it_searches_cards_by_name()
    {
        Carta::factory()->create(['nombre' => 'Charizard']);
        Carta::factory()->create(['nombre' => 'Blastoise']);

        $response = $this->get('/cards?q=Char');

        $response->assertStatus(200);
        $this->assertTrue(
            $response->viewData('cards')->contains('nombre', 'Charizard')
        );
    }

    public function test_it_shows_individual_card()
    {
        $card = Carta::factory()->create();

        $response = $this->get("/cards/{$card->id}");

        $response->assertStatus(200);
        $response->assertViewIs('cards.show');
        $response->assertViewHas('card', $card);
    }

    public function test_it_detects_unavailable_card()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $cartaOriginal = Carta::factory()->create(['user_id' => $user1->id]);
        $cartaOfrecida = Carta::factory()->create(['user_id' => $user2->id]);

        Intercambio::create([
            'user_id' => $user2->id,
            'carta_id' => $cartaOriginal->id,
            'carta_ofrecida_id' => $cartaOfrecida->id,
            'estado' => 'a',
            'fecha' => now()->addDays(2),
            'lugar' => 'Plaza',
        ]);

        $response = $this->get("/cards/{$cartaOriginal->id}");
        $response->assertStatus(200);
        $this->assertTrue($response->viewData('isUnavailable'));
    }

    public function test_it_detects_proposed_and_received_trades_for_logged_user()
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        $card = Carta::factory()->create(['user_id' => $owner->id]);
        $offeredCard = Carta::factory()->create(['user_id' => $otherUser->id]);

        $intercambio = Intercambio::create([
            'user_id' => $otherUser->id,
            'carta_id' => $card->id,
            'carta_ofrecida_id' => $offeredCard->id,
            'estado' => 'p',
            'fecha' => now()->addDays(2),
            'lugar' => 'Centro',
        ]);

        $this->actingAs($otherUser);
        $response = $this->get("/cards/{$card->id}");

        $response->assertStatus(200);
        $this->assertTrue($response->viewData('yaPropuesto'));
        $this->assertEquals($intercambio->id, $response->viewData('intercambio')->id);
    }
}
