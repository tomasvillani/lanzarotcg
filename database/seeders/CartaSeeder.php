<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Carta;
use App\Models\User;

class CartaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = ['pokemon', 'onepiece', 'digimon', 'magic'];

        $users = User::all();

        foreach ($users as $user) {
            Carta::factory()->count(5)->create([
                'user_id' => $user->id,
                'categoria' => $categorias[array_rand($categorias)],
            ]);
        }
    }
}
