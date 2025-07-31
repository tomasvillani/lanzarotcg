<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Intercambio extends Model
{
    protected $fillable = ['user_id', 'carta_id', 'carta_ofrecida_id', 'fecha', 'lugar', 'estado'];

    // El intercambio pertenece a un usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // El intercambio tiene una carta original
    public function cartaOriginal()
    {
        return $this->belongsTo(Carta::class, 'carta_id');
    }

    // El intercambio tiene una carta ofrecida
    public function cartaOfrecida()
    {
        return $this->belongsTo(Carta::class, 'carta_ofrecida_id');
    }
}
