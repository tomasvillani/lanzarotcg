<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Carta;
use App\Models\Intercambio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_access_public_routes()
    {
        $this->get('/')->assertOk();
        $this->get('/about')->assertOk();
        $this->get('/cards')->assertOk();
    }

    public function test_guest_can_view_card_detail()
    {
        $card = Carta::factory()->create();
        $this->get("/cards/{$card->id}")->assertOk();
    }

    public function test_authenticated_user_can_access_dashboard()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertOk();
    }

    public function test_authenticated_user_can_manage_profile()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/profile')->assertOk();

        $this->patch('/profile', ['name' => 'Nuevo nombre', 'email' => $user->email])
            ->assertRedirect('/profile');
    }

    public function test_authenticated_user_can_access_mycards_routes()
    {
        $user = User::factory()->create();
        $card = Carta::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)->get('/mycards')->assertOk();
        $this->actingAs($user)->get('/mycards/create')->assertOk();
        $this->actingAs($user)->get("/mycards/{$card->id}/edit")->assertOk();
    }

    public function test_authenticated_user_can_access_trades_routes()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $card = Carta::factory()->create(['user_id' => $user->id]);
        $myCard = Carta::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)->get("/trades/create/{$card->id}")->assertOk();

        $intercambio = Intercambio::factory()->create([
            'user_id' => $user->id,
            'carta_id' => $card->id,
            'carta_ofrecida_id' => $myCard->id,
            'estado' => 'p',
        ]);

        $this->actingAs($user)->get('/trades/sent')->assertOk();
        $this->actingAs($user)->get("/trades/received/{$card->id}")->assertOk();
        $this->actingAs($user)->get("/trades/{$intercambio->id}")->assertOk();
    }

}
