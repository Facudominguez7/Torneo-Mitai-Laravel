<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['nombre', 'foto', 'idCategoria', 'idEdicion', 'foto'];

    function categoria() {
        return $this->belongsTo(Categoria::class, 'idCategoria');
    }
    public function edicion()
    {
        return $this->belongsTo(Edicion::class, 'idEdicion');
    }
}
