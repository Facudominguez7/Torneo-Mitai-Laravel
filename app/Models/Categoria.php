<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'idEdicion'];

    public function edicion()
    {
        return $this->belongsTo(Edicion::class, 'idEdicion');
    }

    public function equipos()
    {
        return $this->hasMany(Equipo::class, 'idCategoria');
    }
}
