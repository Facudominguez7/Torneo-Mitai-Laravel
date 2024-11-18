<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dia extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'dias';
    protected $fillable = ['diaPartido', 'idEdicion'];

    public function edicion()
    {
        return $this->belongsTo(Edicion::class, 'idEdicion');
    }
    public function partidos()
    {
        return $this->hasMany(Partido::class, 'idDia');
    }

}
