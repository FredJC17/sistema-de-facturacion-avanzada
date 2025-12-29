
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SFA - Sistema de Facturación Avanzada')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Tema personalizado -->
    <link rel="stylesheet" href="/css/temas.css">
    
    @stack('styles')
</head>
<body data-tema-usuario="{{ auth()->check() ? (auth()->user()->configuracion->tema ?? 'claro') : 'claro' }}">
    @auth
        @include('components.navbar')
    @endauth

    <div class="container-fluid">
        <div class="row">
            @auth
                @if(auth()->user()->isAdministrator())
                    <!-- Sidebar para administradores -->
                    <nav class="col-md-2 col-lg-2 d-md-block sidebar p-0">
                        @include('components.sidebar')
                    </nav>
                    <main class="col-md-10 col-lg-10 ms-sm-auto px-md-4 py-4">
                        @yield('content')
                    </main>
                @else
                    <!-- Sin sidebar para clientes/proveedores -->
                    <main class="col-12 px-md-4 py-4">
                        @yield('content')
                    </main>
                @endif
            @else
                <!-- Sin autenticación -->
                <main class="col-12">
                    @yield('content')
                </main>
            @endauth
        </div>
    </div>

    <!-- Confirm Modal Component -->
    @include('components.confirm-modal')
    
    <!-- Scripts base -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/confirm-modal.js"></script>
    <!-- Sistema de temas -->
    <script src="/js/temas.js"></script>
    
    @stack('scripts')
</body>
</html>
