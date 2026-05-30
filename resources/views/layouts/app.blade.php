<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Gimnasio')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark px-4">
        <span class="navbar-brand fw-bold">GimGoya</span>
        @if(session('user_name'))
            <div class="d-flex align-items-center gap-3">
                <span class="text-white">{{ session('user_name') }}</span>
                <span class="badge {{ session('user_role') === 'monitor' ? 'bg-warning text-dark' : 'bg-info text-dark' }}">
                    {{ ucfirst(session('user_role')) }}
                </span>
                <a href="{{ route('logout') }}" class="btn btn-outline-light btn-sm">Cerrar sesión</a>
            </div>
        @endif
    </nav>

    <div class="container mt-4">

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if(session('exito'))
            <div class="alert alert-success">{{ session('exito') }}</div>
        @endif

        @yield('contenido')

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
