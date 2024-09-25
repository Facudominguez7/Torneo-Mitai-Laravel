<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TablaGoleador extends Model
{
    use HasFactory;

    protected $table = 'tabla_goleadores'; // Nombre de la tabla
    public $timestamps = false;

    protected $fillable = [
        'idEquipo', // ID del equipo al que pertenece el goleador
        'cantidadGoles', // Número de goles anotados
        'idEdicion', // ID de la edición del torneo
        'idCategoria',
        'nombre',
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

    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where('tabla_goleadores.nombre', 'LIKE', "%$search%");
        }
    }
}
