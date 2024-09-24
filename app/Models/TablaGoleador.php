<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TablaGoleador extends Model
{
    use HasFactory;

    protected $table = 'tabla_goleadores'; // Nombre de la tabla

    protected $fillable = [
        'idEquipo', // ID del equipo al que pertenece el goleador
        'idPartido', // ID del partido
        'cantidadGoles', // Número de goles anotados
        'idEdicion', // ID de la edición del torneo
    ];
    // Relación con la tabla de equipos
    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'idEquipo');
    }

    // Relación con la tabla de partidos
    public function partido()
    {
        return $this->belongsTo(Partido::class, 'idPartido');
    }

    // Relación con la tabla de ediciones
    public function edicion()
    {
        return $this->belongsTo(Edicion::class, 'idEdicion');
    }
}
