<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Copa extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'copas';
    protected $fillable = ['nombre', 'idEdicion'];

    public function campeones()
    {
        return $this->hasMany(Campeon::class, 'idCopa');
    }
}
