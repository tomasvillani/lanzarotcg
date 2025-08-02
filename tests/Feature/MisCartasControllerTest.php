<?php

namespace Tests\Feature;

use App\Models\Carta;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MisCartasControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_displays_user_cards()
    {
        $user = User::factory()->create();

        // Crear cartas para el usuario autenticado con nombres claros y únicos
        $cartasUser = Carta::factory()->count(3)->sequence(
            ['nombre' => 'CartaUsuario1'],
            ['nombre' => 'CartaUsuario2'],
            ['nombre' => 'CartaUsuario3']
        )->create([
            'user_id' => $user->id,
        ]);

        // Crear cartas para otro usuario con nombres únicos que no se confundan con palabras comunes
        $otherUser = User::factory()->create();
        $cartasOtherUser = Carta::factory()->count(2)->sequence(
            ['nombre' => 'CartaOtroUserA123'],
            ['nombre' => 'CartaOtroUserB456']
        )->create([
            'user_id' => $otherUser->id,
        ]);

        $response = $this->actingAs($user)->get(route('mycards.index'));

        // DEBUG: si quieres guardar el HTML para revisar, descomenta esta línea:
        // file_put_contents('debug.html', $response->getContent());

        $response->assertStatus(200);

        // Verificar que aparecen las cartas del usuario autenticado
        foreach ($cartasUser as $carta) {
            $response->assertSeeText($carta->nombre);
        }

        // Verificar que NO aparecen las cartas de otro usuario
        foreach ($cartasOtherUser as $carta) {
            $response->assertDontSeeText($carta->nombre);
        }
    }

    public function test_create_view_is_accessible()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('mycards.create'))
            ->assertStatus(200)
            ->assertViewIs('mycards.create');
    }

    public function test_store_creates_new_card_with_image()
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $file = UploadedFile::fake()->image('card.jpg');

        $data = [
            'nombre' => 'Carta Test',
            'categoria' => 'pokemon',
            'descripcion' => 'Descripción de prueba',
            'imagen' => $file,
        ];

        $response = $this->actingAs($user)->post(route('mycards.store'), $data);

        $response->assertRedirect(route('mycards.index'));
        $response->assertSessionHas('success', 'Carta creada correctamente.');

        $this->assertDatabaseHas('cartas', [
            'nombre' => 'Carta Test',
            'categoria' => 'pokemon',
            'user_id' => $user->id,
        ]);

        Storage::disk('public')->assertExists('cartas/' . $file->hashName());
    }

    public function test_edit_only_owner_can_access()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $carta = Carta::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->get(route('mycards.edit', $carta))
            ->assertStatus(200)
            ->assertViewIs('mycards.edit');

        $this->actingAs($otherUser)
            ->get(route('mycards.edit', $carta))
            ->assertStatus(403);
    }

    public function test_update_card_changes_data_and_image()
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $carta = Carta::factory()->create(['user_id' => $user->id, 'imagen' => null]);

        $file = UploadedFile::fake()->image('newimage.jpg');

        $data = [
            'nombre' => 'Nombre actualizado',
            'categoria' => 'magic',
            'descripcion' => 'Nueva descripción',
            'imagen' => $file,
            'eliminar_imagen' => false,
        ];

        $response = $this->actingAs($user)->put(route('mycards.update', $carta), $data);

        $response->assertRedirect(route('mycards.index'));
        $response->assertSessionHas('success', 'Carta actualizada correctamente.');

        $this->assertDatabaseHas('cartas', [
            'id' => $carta->id,
            'nombre' => 'Nombre actualizado',
            'categoria' => 'magic',
            'descripcion' => 'Nueva descripción',
        ]);

        Storage::disk('public')->assertExists('cartas/' . $file->hashName());
    }

    public function test_update_forbidden_for_non_owner()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $carta = Carta::factory()->create(['user_id' => $user->id]);

        $data = [
            'nombre' => 'Nuevo nombre',
            'categoria' => 'digimon',
        ];

        $this->actingAs($otherUser)
            ->put(route('mycards.update', $carta), $data)
            ->assertStatus(403);
    }

    public function test_destroy_deletes_card_and_image()
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $file = UploadedFile::fake()->image('to_delete.jpg');
        $path = $file->store('cartas', 'public');

        $carta = Carta::factory()->create([
            'user_id' => $user->id,
            'imagen' => 'storage/' . $path,
        ]);

        Storage::disk('public')->assertExists($path);

        $response = $this->actingAs($user)->delete(route('mycards.destroy', $carta));

        $response->assertRedirect(route('mycards.index'));
        $response->assertSessionHas('success', 'Carta eliminada correctamente.');

        $this->assertDatabaseMissing('cartas', ['id' => $carta->id]);

        Storage::disk('public')->assertMissing($path);
    }

    public function test_destroy_forbidden_for_non_owner()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $carta = Carta::factory()->create(['user_id' => $user->id]);

        $this->actingAs($otherUser)
            ->delete(route('mycards.destroy', $carta))
            ->assertStatus(403);
    }
}
