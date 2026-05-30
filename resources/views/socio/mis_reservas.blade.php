@extends('layouts.app')
@section('titulo', 'Mis reservas')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Mis reservas</h2>
    <a href="{{ route('socio.clases') }}" class="btn btn-outline-dark">← Ver clases</a>
</div>

<div class="table-responsive">
<table class="table table-bordered table-hover bg-white">
    <thead class="table-dark">
        <tr>
            <th>Clase</th>
            <th>Monitor</th>
            <th>Fecha</th>
            <th>Horario</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($reservas as $reserva)
            <tr>
                <td>{{ $reserva->clase->tipoClase->nombre }}</td>
                <td>{{ $reserva->clase->monitor->nombre }}</td>
                <td>{{ \Carbon\Carbon::parse($reserva->clase->fecha)->format('d/m/Y') }}</td>
                <td>{{ $reserva->clase->hora_inicio }} - {{ $reserva->clase->hora_fin }}</td>
                <td><span class="badge bg-success">{{ ucfirst($reserva->estado) }}</span></td>
                <td>
                    <form method="POST" action="{{ route('socio.cancelar', $reserva->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger"
                            onclick="return confirm('¿Cancelar esta reserva?')">
                            Cancelar
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center py-4 text-muted">
                    No tienes reservas activas.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
</div>
@endsection
