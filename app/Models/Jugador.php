<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jugador extends Model
{
    use HasFactory;
    protected $table = 'jugadores';

    protected $fillable = [
        'idEquipo',
        'nombre',
        'dni',
        'numero_camiseta',
        'totalPartidos',
        'totalGoles',
    ];

    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'idEquipo');
    }

    public function partidos()
    {
        return $this->hasMany(JugadorPartido::class, 'idJugador');
    }
    // Relación con ediciones (muchos a muchos)
    public function ediciones()
    {
        return $this->belongsToMany(Edicion::class, 'jugadores_ediciones', 'idJugador', 'idEdicion')
            ->withPivot(['idEquipo', 'idCategoria'])
            ->withTimestamps();
    }
    // Relación con categorías (pertenece a una categoría)
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'idCategoria');
    }
}
