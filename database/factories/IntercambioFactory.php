<?php

namespace Database\Factories;

use App\Models\Intercambio;
use App\Models\User;
use App\Models\Carta;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class IntercambioFactory extends Factory
{
    protected $model = Intercambio::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'carta_id' => Carta::factory(),
            'carta_ofrecida_id' => Carta::factory(),
            'fecha' => $this->faker->dateTimeBetween('-10 days', '+10 days')->format('Y-m-d'),
            'lugar' => $this->faker->city(),
            'estado' => $this->faker->randomElement(['p', 'a', 'r']), // pendiente, aceptado, rechazado
        ];
    }
}
