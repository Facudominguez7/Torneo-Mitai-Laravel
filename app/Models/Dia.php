<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dia extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'dias';
    protected $fillable = ['nombre'];

    public function edicion()
    {
        return $this->belongsTo(Edicion::class, 'idEdicion');
    }
}
