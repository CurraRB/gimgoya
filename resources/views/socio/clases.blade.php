@extends('layouts.app')
@section('titulo', 'Clases disponibles')

@section('contenido')
<h2 class="mb-4">Clases disponibles</h2>

<div class="table-responsive">
<table class="table table-bordered table-hover bg-white">
    <thead class="table-dark">
        <tr>
            <th>Tipo</th>
            <th>Monitor</th>
            <th>Fecha</th>
            <th>Horario</th>
            <th>Plazas libres</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($clases as $clase)
            @php $libres = $clase->aforo - $clase->reservas->where('estado','activa')->count() @endphp
            <tr>
                <td>{{ $clase->tipoClase->nombre }}</td>
                <td>{{ $clase->monitor->nombre }}</td>
                <td>{{ \Carbon\Carbon::parse($clase->fecha)->format('d/m/Y') }}</td>
                <td>{{ $clase->hora_inicio }} - {{ $clase->hora_fin }}</td>
                <td>
                    @if($libres > 0)
                        <span class="badge bg-success fs-6">{{ $libres }} libres</span>
                    @else
                        <span class="badge bg-danger fs-6">Completa</span>
                    @endif
                </td>
                <td class="d-flex gap-2">
                    <a href="{{ route('socio.inscritos', $clase->id) }}" class="btn btn-sm btn-outline-dark">Ver inscritos</a>
                    @if($libres > 0)
                        <form method="POST" action="{{ route('socio.reservar', $clase->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-dark">Reservar</button>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center py-4 text-muted">
                    No hay clases disponibles en este momento.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
</div>

<a href="{{ route('socio.reservas') }}" class="btn btn-outline-dark mt-2">Ver mis reservas</a>
@endsection
