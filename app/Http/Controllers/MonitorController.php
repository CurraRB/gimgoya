<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\Reserva;
use App\Models\TipoClase;
use Illuminate\Http\Request;

/**
 * Gestiona las acciones disponibles para usuarios con rol monitor:
 * ver todas las clases, crear clases propias, borrarlas y ver inscritos.
 */
class MonitorController extends Controller
{
    /**
     * Muestra el panel del monitor con todas las clases del gimnasio.
     * Solo accesible para usuarios con rol 'monitor'.
     */
    public function panel(Request $request) {
        if (!$request->session()->has('user_id') || $request->session()->get('user_role') !== 'monitor') {
            return redirect('/login');
        }

        $clases = Clase::with(['tipoClase', 'monitor'])->get();

        return view('monitor.panel', ['clases' => $clases]);
    }

    /**
     * Muestra el formulario para crear una nueva clase.
     * Carga los tipos de clase disponibles para el desplegable.
     */
    public function formCrearClase(Request $request) {
        if (!$request->session()->has('user_id') || $request->session()->get('user_role') !== 'monitor') {
            return redirect('/login');
        }

        $tipos = TipoClase::all();
        return view('monitor.crear_clase', ['tipos' => $tipos]);
    }

    /**
     * Valida y guarda una nueva clase en la base de datos.
     * La clase queda asignada automáticamente al monitor logueado.
     */
    public function crearClase(Request $request) {
        if (!$request->session()->has('user_id') || $request->session()->get('user_role') !== 'monitor') {
            return redirect('/login');
        }

        $datos = $request->validate([
            'tipo_clase_id' => 'required|exists:tipos_clase,id',
            'fecha'         => 'required|date|after_or_equal:today',
            'hora_inicio'   => 'required',
            'hora_fin'      => 'required',
            'aforo'         => 'required|integer|min:1',
        ]);

        $clase = new Clase();
        $clase->tipo_clase_id = $datos['tipo_clase_id'];
        $clase->monitor_id    = $request->session()->get('user_id');
        $clase->fecha         = $datos['fecha'];
        $clase->hora_inicio   = $datos['hora_inicio'];
        $clase->hora_fin      = $datos['hora_fin'];
        $clase->aforo         = $datos['aforo'];
        $clase->save();

        return redirect()->route('monitor.panel');
    }

    /**
     * Muestra el formulario de edición de una clase propia.
     */
    public function formEditarClase(Request $request, $id) {
        if (!$request->session()->has('user_id') || $request->session()->get('user_role') !== 'monitor') {
            return redirect('/login');
        }

        $clase = Clase::findOrFail($id);

        if ($clase->monitor_id != $request->session()->get('user_id')) {
            return redirect()->route('monitor.panel');
        }

        $tipos = TipoClase::all();
        return view('monitor.editar_clase', ['clase' => $clase, 'tipos' => $tipos]);
    }

    /**
     * Valida y guarda los cambios de una clase propia.
     */
    public function editarClase(Request $request, $id) {
        if (!$request->session()->has('user_id') || $request->session()->get('user_role') !== 'monitor') {
            return redirect('/login');
        }

        $clase = Clase::findOrFail($id);

        if ($clase->monitor_id != $request->session()->get('user_id')) {
            return redirect()->route('monitor.panel');
        }

        $inscritos = Reserva::where('clase_id', $id)->where('estado', 'activa')->count();

        $datos = $request->validate([
            'tipo_clase_id' => 'required|exists:tipos_clase,id',
            'fecha'         => 'required|date|after_or_equal:today',
            'hora_inicio'   => 'required',
            'hora_fin'      => 'required',
            'aforo'         => "required|integer|min:$inscritos",
        ], [
            'aforo.min' => "El aforo no puede ser inferior al número de inscritos actuales ($inscritos).",
        ]);

        $clase->tipo_clase_id = $datos['tipo_clase_id'];
        $clase->fecha         = $datos['fecha'];
        $clase->hora_inicio   = $datos['hora_inicio'];
        $clase->hora_fin      = $datos['hora_fin'];
        $clase->aforo         = $datos['aforo'];
        $clase->save();

        return redirect()->route('monitor.panel')->with('exito', 'Clase actualizada correctamente.');
    }

    /**
     * Borra una clase propia y cancela todas sus reservas activas.
     * Verifica que la clase pertenece al monitor logueado antes de borrar.
     */
    public function borrarClase(Request $request, $id) {
        if (!$request->session()->has('user_id') || $request->session()->get('user_role') !== 'monitor') {
            return redirect('/login');
        }

        $clase = Clase::findOrFail($id);

        // Verificar que la clase pertenece al monitor logueado
        if ($clase->monitor_id != $request->session()->get('user_id')) {
            return redirect()->route('monitor.panel');
        }

        // Cancelar todas las reservas activas
        Reserva::where('clase_id', $id)->update(['estado' => 'cancelada']);

        // Borrar la clase
        $clase->delete();

        return redirect()->route('monitor.panel')->with('exito', 'Clase eliminada correctamente.');
    }

    /**
     * Muestra la lista de socios con reserva activa en una clase concreta.
     */
    public function verInscritos(Request $request, $id) {
        if (!$request->session()->has('user_id') || $request->session()->get('user_role') !== 'monitor') {
            return redirect('/login');
        }

        $clase    = Clase::findOrFail($id);
        $reservas = Reserva::with('socio')->where('clase_id', $id)->where('estado', 'activa')->get();

        return view('monitor.inscritos', ['clase' => $clase, 'reservas' => $reservas]);
    }
}
