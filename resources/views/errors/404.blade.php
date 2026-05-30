@extends('layouts.app')
@section('titulo', 'Página no encontrada')

@section('contenido')
<div class="text-center py-5">
    <h1 class="display-1 fw-bold text-dark">404</h1>
    <p class="fs-4 text-muted mb-4">La página que buscas no existe.</p>
    <a href="{{ url('/') }}" class="btn btn-dark">Volver al inicio</a>
</div>
@endsection
