<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoClase extends Model
{
    protected $table = 'tipos_clase';
    protected $fillable = ['nombre'];

    public function clases() {
        return $this->hasMany(Clase::class, 'tipo_clase_id');
    }
}
