<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['nombre', 'foto', 'idCategoria', 'idEdicion', 'foto'];

    function categoria()
    {
        return $this->belongsTo(Categoria::class, 'idCategoria');
    }
    public function edicion()
    {
        return $this->belongsTo(Edicion::class, 'idEdicion');
    }
    public function campeon()
    {
        return $this->hasOne(Campeon::class, 'idEquipo');
    }
    public function goleador()
    {
        return $this->hasOne(Goleador::class, 'idEquipo');
    }
    public function subcampeon()
    {
        return $this->hasOne(Subcampeon::class, 'idEquipo');
    }
    public function vallaMenosVencida()
    {
        return $this->hasOne(VallaMenosVencida::class, 'idEquipo');
    }
    public function grupos()
    {
        return $this->belongsToMany(Grupo::class, 'equipos_grupos', 'idEquipo', 'idGrupo');
    }

}
