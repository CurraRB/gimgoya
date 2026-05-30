@extends('layouts.app')
@section('titulo', 'Editar clase')

@section('contenido')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-body p-4">
                <h4 class="mb-4">Editar clase</h4>

                <form method="POST" action="{{ route('monitor.editar', $clase->id) }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Tipo de clase</label>
                        <select name="tipo_clase_id" class="form-select" required>
                            @foreach($tipos as $tipo)
                                <option value="{{ $tipo->id }}" {{ $clase->tipo_clase_id == $tipo->id ? 'selected' : '' }}>
                                    {{ $tipo->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('tipo_clase_id')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha</label>
                        <input type="date" name="fecha" class="form-control" required
                               value="{{ old('fecha', $clase->fecha) }}"
                               min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d', strtotime('+2 years')) }}">
                        @error('fecha')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label class="form-label">Hora inicio</label>
                            <input type="time" name="hora_inicio" class="form-control" required
                                   value="{{ old('hora_inicio', $clase->hora_inicio) }}">
                        </div>
                        <div class="col mb-3">
                            <label class="form-label">Hora fin</label>
                            <input type="time" name="hora_fin" class="form-control" required
                                   value="{{ old('hora_fin', $clase->hora_fin) }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Aforo máximo</label>
                        <input type="number" name="aforo" class="form-control" min="1" required
                               value="{{ old('aforo', $clase->aforo) }}">
                        @error('aforo')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-dark">Guardar cambios</button>
                        <a href="{{ route('monitor.panel') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
