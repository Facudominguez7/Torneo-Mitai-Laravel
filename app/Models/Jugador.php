<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jugador extends Model
{
    use HasFactory;
    protected $table = 'jugadores';
    public $timestamps = false;
    public $primaryKey = 'dni';

    protected $fillable = [
        'nombre',
        'apellido',
        'dni',
        'partidos_totales',
        'goles_totales',
    ];

    public function planillas()
    {
        return $this->hasMany(PlanillaJugador::class, 'dni_jugador', 'dni');
    }
    

}
