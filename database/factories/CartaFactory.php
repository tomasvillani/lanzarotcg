<?php

namespace Database\Factories;

use App\Models\Carta;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartaFactory extends Factory
{
    protected $model = Carta::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),  // <- Esto asigna un usuario válido
            'nombre' => $this->faker->word(),
            'categoria' => $this->faker->randomElement(['pokemon', 'magic', 'yugioh']),
            'descripcion' => $this->faker->sentence(),
            'imagen' => null, // o alguna ruta válida si quieres
        ];
    }
}
