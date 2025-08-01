<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Intercambio;

class Carta extends Model
{

    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = ['user_id', 'nombre', 'categoria', 'descripcion', 'imagen'];

    public function user()
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

    public function isUnavailable()
    {
        return Intercambio::where('estado', 'a')
            ->where(function ($query) {
                $query->where('carta_id', $this->id)
                    ->orWhere('carta_ofrecida_id', $this->id);
            })
            ->exists();
    }

}
