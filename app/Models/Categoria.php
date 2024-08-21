<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['nombreCategoria', 'idEdicion'];

    public function edicion()
    {
        return $this->belongsTo(Edicion::class, 'idEdicion');
    }

    public function equipos()
    {
        return $this->hasMany(Equipo::class, 'idCategoria');
    }
    public function campeones()
    {
        return $this->hasMany(Campeon::class, 'idCategoria');
    }
    public function fechas()
    {
        return $this->hasMany(Fecha::class, 'idCategoria');
    }
    public function goleadores()
    {
        return $this->hasMany(Goleador::class, 'idCategoria');
    }
    public function subcampeones()
    {
        return $this->hasMany(Subcampeon::class, 'idCategoria');
    }
    public function vallasMenosVencidas()
    {
        return $this->hasMany(VallaMenosVencida::class, 'idCategoria');
    }
    public function grupos()
    {
        return $this->hasMany(Grupo::class, 'idCategoria');
    }
}
