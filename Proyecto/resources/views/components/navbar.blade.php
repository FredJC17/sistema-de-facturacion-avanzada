<nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container-fluid">
        <!-- Logo y nombre del sistema -->
        <a class="navbar-brand d-flex align-items-center navbar-brand-container" href="{{ route('dashboard') }}">
            <div class="d-flex align-items-center logo-icon-wrapper">
                <img src="{{ asset('images/logo/sfa.png') }}" alt="SFA Logo" height="40" class="me-2">
                <span class="brand-acronym fw-bold">SFA</span>
            </div>
            <span class="brand-text">Sistema de Facturación Avanzada</span>
        </a>

        <!-- Botón responsive para móviles -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <!-- Selector de tema (solo en navbar para móviles) -->
                <li class="nav-item d-lg-none">
                    <button class="nav-link selector-tema" type="button">
                        <i class="bi bi-moon-stars icono-luna"></i>
                        <i class="bi bi-sun icono-sol" style="display: none;"></i>
                        <span class="ms-2">Cambiar tema</span>
                    </button>
                </li>

                <!-- Notificaciones (opcional) -->
                <!-- Notificaciones (Solo Admin) -->
                @if(auth()->user()->isAdministrator())
                <li class="nav-item dropdown d-none d-lg-block me-3">
                    <a class="nav-link position-relative" href="#" id="notificationsDropdown" data-bs-toggle="dropdown">
                        <i class="bi bi-bell fs-5"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $lowStockProducts->count() }}
                            <span class="visually-hidden">notificaciones</span>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown">
                        <li><h6 class="dropdown-header">Notificaciones</h6></li>
                        <li><h6 class="dropdown-header">Notificaciones</h6></li>
                        @if(isset($lowStockProducts) && $lowStockProducts->count() > 0)
                            @foreach($lowStockProducts->take(5) as $product)
                            <li>
                                <a class="dropdown-item" href="{{ route('articulos.index', ['search' => $product->descripcion]) }}">
                                    <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
                                    {{ Str::limit($product->descripcion, 20) }} 
                                    <span class="badge bg-danger ms-1">{{ $product->stock }}</span>
                                </a>
                            </li>
                            @endforeach
                            @if($lowStockProducts->count() > 5)
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-center text-muted small" href="{{ route('articulos.index', ['filter' => 'low_stock']) }}">
                                        Ver +{{ $lowStockProducts->count() - 5 }} más
                                    </a>
                                </li>
                            @endif
                        @else
                            <li><span class="dropdown-item text-muted">Sin notificaciones de stock</span></li>
                        @endif
                    </ul>
                </li>
                @endif

                <!-- Dropdown del usuario -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" 
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" 
                             style="width: 35px; height: 35px;">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <span class="d-none d-lg-inline">{{ auth()->user()->getNombreCompleto() }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <div class="dropdown-header">
                                <strong>{{ auth()->user()->getNombreCompleto() }}</strong><br>
                                <small class="text-muted">{{ auth()->user()->email }}</small>
                            </div>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bi bi-person me-2"></i> Mi Perfil
                            </a>
                        </li>
                        @if(auth()->user()->isAdministrator())
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bi bi-gear me-2"></i> Configuración
                            </a>
                        </li>
                        @endif
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <button class="dropdown-item selector-tema" type="button">
                                <i class="bi bi-moon-stars icono-luna me-2"></i>
                                <i class="bi bi-sun icono-sol me-2" style="display: none;"></i>
                                <span>Cambiar tema</span>
                            </button>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i> Cerrar Sesión
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
