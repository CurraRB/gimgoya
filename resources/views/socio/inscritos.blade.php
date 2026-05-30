@extends('layouts.app')
@section('titulo', 'Inscritos')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Inscritos en: {{ $clase->tipoClase->nombre }}</h2>
    <a href="{{ route('socio.clases') }}" class="btn btn-outline-secondary">← Volver</a>
</div>

<p class="text-muted">{{ $clase->fecha }} · {{ $clase->hora_inicio }} - {{ $clase->hora_fin }} · Monitor: {{ $clase->monitor->nombre }}</p>

<table class="table table-bordered bg-white">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Nombre</th>
        </tr>
    </thead>
    <tbody>
        @forelse($reservas as $reserva)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $reserva->socio->nombre }}</td>
            </tr>
        @empty
            <tr><td colspan="2" class="text-center">Nadie inscrito todavía.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
