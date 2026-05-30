@extends('layouts.app')
@section('titulo', 'Panel Monitor')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Mis clases</h2>
    <a href="{{ route('monitor.crear.form') }}" class="btn btn-dark">+ Nueva clase</a>
</div>

<div class="table-responsive">
<table class="table table-bordered table-hover bg-white">
    <thead class="table-dark">
        <tr>
            <th>Tipo</th>
            <th>Monitor</th>
            <th>Fecha</th>
            <th>Horario</th>
            <th>Aforo</th>
            <th>Inscritos</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($clases as $clase)
            <tr>
                <td>{{ $clase->tipoClase->nombre }}</td>
                <td>
                    {{ $clase->monitor->nombre }}
                    @if($clase->monitor_id == session('user_id'))
                        <span class="badge bg-warning text-dark ms-1">Mía</span>
                    @endif
                </td>
                <td>{{ \Carbon\Carbon::parse($clase->fecha)->format('d/m/Y') }}</td>
                <td>{{ $clase->hora_inicio }} - {{ $clase->hora_fin }}</td>
                <td>{{ $clase->aforo }}</td>
                <td>{{ $clase->reservas->where('estado','activa')->count() }} / {{ $clase->aforo }}</td>
                <td class="d-flex gap-2">
                    <a href="{{ route('monitor.inscritos', $clase->id) }}" class="btn btn-sm btn-outline-dark">Ver inscritos</a>
                    @if($clase->monitor_id == session('user_id'))
                        <a href="{{ route('monitor.editar.form', $clase->id) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                        <form method="POST" action="{{ route('monitor.borrar', $clase->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('¿Borrar esta clase y cancelar todas sus reservas?')">
                                Borrar
                            </button>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center py-4 text-muted">
                    No hay clases registradas todavía.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
</div>
@endsection
