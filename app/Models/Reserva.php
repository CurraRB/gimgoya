<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $fillable = ['socio_id', 'clase_id', 'estado'];

    public function socio()
    {
        return $this->belongsTo(Usuario::class, 'socio_id');
    }

    public function clase()
    {
        return $this->belongsTo(Clase::class, 'clase_id');
    }
}
