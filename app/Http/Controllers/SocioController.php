<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\Reserva;
use Illuminate\Http\Request;

/**
 * Gestiona las acciones disponibles para usuarios con rol socio:
 * ver clases disponibles, reservar, ver inscritos, ver reservas propias y cancelarlas.
 */
class SocioController extends Controller
{
    /**
     * Muestra las clases disponibles: solo fechas presentes y futuras.
     * Incluye información del monitor y tipo de clase mediante eager loading.
     */
    public function verClases(Request $request) {
        if (!$request->session()->has('user_id') || $request->session()->get('user_role') !== 'socio') {
            return redirect('/login');
        }

        $clases = Clase::with(['monitor', 'tipoClase'])
            ->where('fecha', '>=', now()->toDateString())
            ->get();

        return view('socio.clases', ['clases' => $clases]);
    }

    /**
     * Crea una reserva para el socio logueado en la clase indicada.
     * Valida dos condiciones antes de guardar:
     * 1. El socio no tiene ya una reserva activa en esa clase.
     * 2. Quedan plazas disponibles (inscritos activos < aforo).
     */
    public function reservar(Request $request, $id) {
        if (!$request->session()->has('user_id') || $request->session()->get('user_role') !== 'socio') {
            return redirect('/login');
        }

        $socioId = $request->session()->get('user_id');
        $clase   = Clase::findOrFail($id);

        // Validar que no está ya reservada
        $yaReservada = Reserva::where('socio_id', $socioId)
            ->where('clase_id', $id)
            ->where('estado', 'activa')
            ->exists();

        if ($yaReservada) {
            return redirect()->route('socio.clases')->with('error', 'Ya tienes una reserva activa para esta clase.');
        }

        // Validar aforo
        $inscritos = Reserva::where('clase_id', $id)->where('estado', 'activa')->count();
        if ($inscritos >= $clase->aforo) {
            return redirect()->route('socio.clases')->with('error', 'No hay plazas disponibles.');
        }

        $reserva           = new Reserva();
        $reserva->socio_id = $socioId;
        $reserva->clase_id = $id;
        $reserva->estado   = 'activa';
        $reserva->save();

        return redirect()->route('socio.reservas')->with('exito', 'Reserva realizada correctamente.');
    }

    /**
     * Muestra la lista de socios con reserva activa en una clase concreta.
     */
    public function verInscritos(Request $request, $id) {
        if (!$request->session()->has('user_id') || $request->session()->get('user_role') !== 'socio') {
            return redirect('/login');
        }

        $clase    = Clase::findOrFail($id);
        $reservas = Reserva::with('socio')->where('clase_id', $id)->where('estado', 'activa')->get();

        return view('socio.inscritos', ['clase' => $clase, 'reservas' => $reservas]);
    }

    /**
     * Muestra las reservas activas del socio logueado.
     * Incluye datos de la clase y el monitor mediante eager loading anidado.
     */
    public function misReservas(Request $request) {
        if (!$request->session()->has('user_id') || $request->session()->get('user_role') !== 'socio') {
            return redirect('/login');
        }

        $socioId  = $request->session()->get('user_id');
        $reservas = Reserva::with('clase.monitor')
            ->where('socio_id', $socioId)
            ->where('estado', 'activa')
            ->get();

        return view('socio.mis_reservas', ['reservas' => $reservas]);
    }

    /**
     * Cancela una reserva del socio logueado.
     * Verifica que la reserva pertenece al socio antes de modificarla.
     */
    public function cancelarReserva(Request $request, $id) {
        if (!$request->session()->has('user_id') || $request->session()->get('user_role') !== 'socio') {
            return redirect('/login');
        }

        $socioId = $request->session()->get('user_id');
        $reserva = Reserva::findOrFail($id);

        if ($reserva->socio_id != $socioId) {
            return redirect()->route('socio.reservas');
        }

        $reserva->estado = 'cancelada';
        $reserva->save();

        return redirect()->route('socio.reservas');
    }
}
