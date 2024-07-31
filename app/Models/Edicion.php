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
}
