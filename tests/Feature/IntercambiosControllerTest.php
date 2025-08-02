<?php

namespace Tests\Feature;

use App\Models\Carta;
use App\Models\Intercambio;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IntercambiosControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_create_trade_form_with_available_cards()
    {
        $user = User::factory()->create();
        $cardToOffer = Carta::factory()->create(['user_id' => $user->id]);
        $cardTarget = Carta::factory()->create();

        $this->actingAs($user);
        $response = $this->get(route('trades.create', $cardTarget));

        $response->assertStatus(200);
        $response->assertViewIs('trades.create');
        $response->assertViewHas('misCartas');
    }

    public function test_user_cannot_offer_trade_if_already_has_pending_proposal()
    {
        $user = User::factory()->create();
        $cardTarget = Carta::factory()->create();
        $offeredCard = Carta::factory()->create(['user_id' => $user->id]);

        Intercambio::factory()->create([
            'user_id' => $user->id,
            'carta_id' => $cardTarget->id,
            'carta_ofrecida_id' => $offeredCard->id,
            'estado' => 'p',
            'fecha' => now()->addDays(3),
        ]);

        $this->actingAs($user);
        $response = $this->get(route('trades.create', $cardTarget));

        $response->assertRedirect(route('cards.show', $cardTarget));
        $response->assertSessionHasErrors();
    }

    public function test_user_can_propose_a_trade()
    {
        $user = User::factory()->create();
        $targetCard = Carta::factory()->create();
        $offeredCard = Carta::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);
        $response = $this->post(route('trades.store', $targetCard), [
            'offered_card_id' => $offeredCard->id,
            'fecha_intercambio' => now()->addDays(3)->toDateString(),
            'lugar' => 'Parque Central',
        ]);

        $response->assertRedirect(route('cards.show', $targetCard));
        $this->assertDatabaseHas('intercambios', [
            'user_id' => $user->id,
            'carta_id' => $targetCard->id,
            'carta_ofrecida_id' => $offeredCard->id,
            'estado' => 'p',
        ]);
    }

    public function test_user_cannot_offer_the_same_card_as_target()
    {
        $user = User::factory()->create();
        $card = Carta::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);
        $response = $this->post(route('trades.store', $card), [
            'offered_card_id' => $card->id,
            'fecha_intercambio' => now()->addDays(3)->toDateString(),
            'lugar' => 'Plaza',
        ]);

        $response->assertSessionHasErrors('offered_card_id');
    }

    public function test_user_can_accept_a_trade()
    {
        $owner = User::factory()->create();
        $proposer = User::factory()->create();

        $targetCard = Carta::factory()->create(['user_id' => $owner->id]);
        $offeredCard = Carta::factory()->create(['user_id' => $proposer->id]);

        $intercambio = Intercambio::factory()->create([
            'user_id' => $proposer->id,
            'carta_id' => $targetCard->id,
            'carta_ofrecida_id' => $offeredCard->id,
            'estado' => 'p',
            'fecha' => now()->addDays(3),
        ]);

        $this->actingAs($owner);
        $response = $this->patch(route('trades.accept', $intercambio));

        $response->assertRedirect(route('trades.show', $intercambio));
        $this->assertEquals('a', $intercambio->fresh()->estado);
    }

    public function test_user_cannot_accept_trade_if_not_owner()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $targetCard = Carta::factory()->create(['user_id' => $otherUser->id]);
        $offeredCard = Carta::factory()->create(['user_id' => $user->id]);

        $intercambio = Intercambio::factory()->create([
            'user_id' => $user->id,
            'carta_id' => $targetCard->id,
            'carta_ofrecida_id' => $offeredCard->id,
            'estado' => 'p',
            'fecha' => now()->addDays(3),
        ]);

        $this->actingAs($user);
        $response = $this->patch(route('trades.accept', $intercambio));

        $response->assertForbidden();
    }

    public function test_user_can_reject_a_trade()
    {
        $owner = User::factory()->create();
        $proposer = User::factory()->create();

        $targetCard = Carta::factory()->create(['user_id' => $owner->id]);
        $offeredCard = Carta::factory()->create(['user_id' => $proposer->id]);

        $intercambio = Intercambio::factory()->create([
            'user_id' => $proposer->id,
            'carta_id' => $targetCard->id,
            'carta_ofrecida_id' => $offeredCard->id,
            'estado' => 'p',
            'fecha' => now()->addDays(3),
        ]);

        $this->actingAs($owner);
        $response = $this->patch(route('trades.reject', $intercambio));

        $response->assertRedirect(route('trades.show', $intercambio));
        $this->assertEquals('r', $intercambio->fresh()->estado);
    }

    public function test_user_cannot_reject_trade_if_not_owner()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $targetCard = Carta::factory()->create(['user_id' => $otherUser->id]);
        $offeredCard = Carta::factory()->create(['user_id' => $user->id]);

        $intercambio = Intercambio::factory()->create([
            'user_id' => $user->id,
            'carta_id' => $targetCard->id,
            'carta_ofrecida_id' => $offeredCard->id,
            'estado' => 'p',
            'fecha' => now()->addDays(3),
        ]);

        $this->actingAs($user);
        $response = $this->patch(route('trades.reject', $intercambio));

        $response->assertForbidden();
    }

    public function test_user_can_view_trade_details_if_proposer_or_owner()
    {
        $owner = User::factory()->create();
        $proposer = User::factory()->create();
        $otherUser = User::factory()->create();

        $targetCard = Carta::factory()->create(['user_id' => $owner->id]);
        $offeredCard = Carta::factory()->create(['user_id' => $proposer->id]);

        $intercambio = Intercambio::factory()->create([
            'user_id' => $proposer->id,
            'carta_id' => $targetCard->id,
            'carta_ofrecida_id' => $offeredCard->id,
            'estado' => 'p',
            'fecha' => now()->addDays(3),
        ]);

        // Proposer can view
        $this->actingAs($proposer);
        $response = $this->get(route('trades.show', $intercambio));
        $response->assertStatus(200);

        // Owner can view
        $this->actingAs($owner);
        $response = $this->get(route('trades.show', $intercambio));
        $response->assertStatus(200);

        // Other user cannot view
        $this->actingAs($otherUser);
        $response = $this->get(route('trades.show', $intercambio));
        $response->assertForbidden();
    }

    public function test_user_cannot_view_received_trades_of_card_they_do_not_own()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $card = Carta::factory()->create(['user_id' => $otherUser->id]);

        $this->actingAs($user);
        $response = $this->get(route('trades.received', $card));

        $response->assertStatus(403);
    }

    public function test_user_cannot_view_received_trades_of_card_already_accepted()
    {
        $user = User::factory()->create();

        $card = Carta::factory()->create(['user_id' => $user->id]);

        Intercambio::factory()->create([
            'carta_id' => $card->id,
            'estado' => 'a',
        ]);

        $this->actingAs($user);
        $response = $this->get(route('trades.received', $card));

        $response->assertStatus(403);
    }
}
