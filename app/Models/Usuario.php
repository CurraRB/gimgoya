<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Representa a cualquier usuario del sistema: monitor o socio.
 * El campo 'rol' determina el tipo: 'monitor' o 'socio'.
 * Los monitores usan 'especialidad'; los socios usan 'email'.
 */
class Usuario extends Model
{
    protected $table    = 'usuarios';
    protected $fillable = ['nombre', 'usuario', 'password', 'rol', 'especialidad', 'email'];

    /**
     * Clases creadas por este usuario (solo monitores).
     */
    public function clases() {
        return $this->hasMany(Clase::class, 'monitor_id');
    }

    /**
     * Reservas realizadas por este usuario (solo socios).
     */
    public function reservas() {
        return $this->hasMany(Reserva::class, 'socio_id');
    }
}
