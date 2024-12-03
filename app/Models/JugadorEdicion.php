<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JugadorEdicion extends Model
{
    use HasFactory;
    protected $table = 'jugadores_ediciones';

    protected $fillable = [
        'idJugador',
        'idEdicion',
        'idEquipo',
        'idCategoria',
    ];

    // Relaciones

    // Relación con jugadores
    public function jugador()
    {
        return $this->belongsTo(Jugador::class, 'idJugador');
    }

    // Relación con equipos
    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'idEquipo');
    }

    // Relación con ediciones
    public function edicion()
    {
        return $this->belongsTo(Edicion::class, 'idEdicion');
    }

    // Relación con categorías
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'idCategoria');
    }
}
