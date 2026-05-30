<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clase extends Model
{
    protected $fillable = ['tipo_clase_id', 'monitor_id', 'fecha', 'hora_inicio', 'hora_fin', 'aforo'];

    public function monitor()
    {
        return $this->belongsTo(Usuario::class, 'monitor_id');
    }

    public function tipoClase()
    {
        return $this->belongsTo(TipoClase::class, 'tipo_clase_id');
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'clase_id');
    }
}
