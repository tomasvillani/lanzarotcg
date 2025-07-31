<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carta extends Model
{
    protected $fillable = ['user_id', 'nombre', 'categoria', 'descripcion', 'imagen'];

    // Una carta pertenece a un usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Intercambios donde esta carta es la carta original
    public function intercambiosOriginales()
    {
        return $this->hasMany(Intercambio::class, 'carta_id');
    }

    // Intercambios donde esta carta es la carta ofrecida
    public function intercambiosOfrecidos()
    {
        return $this->hasMany(Intercambio::class, 'carta_ofrecida_id');
    }
}
