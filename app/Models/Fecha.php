<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fecha extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'fechas';
    protected $fillable = ['idCategoria', 'idEdicion', 'nombre'];

    public function categoria()
    {
        return $this->belongsToMany(Categoria::class, 'idCategoria');
    }

    public function edicion()
    {
        return $this->belongsTo(Edicion::class, 'idEdicion');
    }
}
