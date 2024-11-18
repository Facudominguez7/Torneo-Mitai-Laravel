<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Edicion extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'ediciones';
    protected $fillable = ['nombre'];

    public function categorias()
    {
        return $this->hasMany(Categoria::class, 'idEdicion');
    }
    public function equipos()
    {
        return $this->hasMany(Equipo::class, 'idEdicion');
    }
    public function fechas()
    {
        return $this->hasMany(Fecha::class, 'idEdicion');
    }
    public function dias()
    {
        return $this->hasMany(Dia::class, 'idEdicion');
    }
    public function goleadores()
    {
        return $this->hasMany(Goleador::class, 'idEdicion');
    }
    public function campeones()
    {
        return $this->hasMany(Campeon::class, 'idEdicion');
    }
    public function subcampeones()
    {
        return $this->hasMany(Subcampeon::class, 'idEdicion');
    }
    public function copas()
    {
        return $this->hasMany(Copa::class, 'idEdicion');
    }
    public function vallasMenosVencidas()
    {
        return $this->hasMany(VallaMenosVencida::class, 'idEdicion');
    }
    public function partidos()
    {
        return $this->hasMany(Partido::class, 'idEdicion');
    }

      // Relación con InstanciaFinal (una edición tiene muchas instancias finales)
      public function instanciasFinales()
      {
          return $this->hasMany(InstanciaFinal::class);
      }
}
