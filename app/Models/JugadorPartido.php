<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JugadorPartido extends Model
{
    use HasFactory;
    protected $table = 'jugadores_partido';

    protected $fillable = [
        'idJugador',
        'idPartido',
        'partido_type',
        'goles',
        'asistio',
    ];

    public function jugador()
    {
        return $this->belongsTo(Jugador::class, 'idJugador');
    }

    public function partido()
    {
        return $this->morphTo();
    }
}
