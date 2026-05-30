@extends('layouts.app')
@section('titulo', 'GimGoya')

@section('contenido')
<div class="text-center py-5">
    <h1 class="fw-bold mb-2">GimGoya</h1>
    <p class="text-muted mb-4">Gestión de clases y reservas para monitores y socios.</p>
    <a href="{{ route('login.form') }}" class="btn btn-dark btn-lg px-5">Acceder</a>
</div>
@endsection
