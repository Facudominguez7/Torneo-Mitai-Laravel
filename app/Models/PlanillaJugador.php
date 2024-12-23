<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanillaJugador extends Model
{
    use HasFactory;
    protected $table = 'planilla_jugadores';
    protected $fillable = ['partido_id', 'dni_jugador', 'partido_type', 'idEquipo', 'idEdicion', 'numero_camiseta', 'goles_partido', 'asistio', 'fecha_nacimiento'];

    public function jugador()
    {
        return $this->belongsTo(Jugador::class, 'dni_jugador', 'dni');
    }
    public function partido()
    {
        return $this->morphTo();
    }
    public function equipo()
    {
        return $this->belongsTo(EquipoEdicion::class, 'idEquipo', 'idEquipo');
    }
    public function edicion()
    {
        return $this->belongsTo(Edicion::class, 'idEdicion');
    }

}
