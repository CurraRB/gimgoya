@extends('layouts.app')
@section('titulo', 'Iniciar sesión')

@section('contenido')
<div class="row justify-content-center mt-5">
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-body p-4">
                <h4 class="card-title text-center mb-4">Iniciar sesión</h4>

                <form method="POST" action="{{ route('login.attempt') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Usuario</label>
                        <input type="text" name="usuario" class="form-control"
                               required value="{{ old('usuario') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-dark w-100">Entrar</button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
