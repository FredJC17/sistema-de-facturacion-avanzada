<div class="d-flex flex-column h-100">
    <!-- Navegación principal -->
    <div class="flex-grow-1">
        <div class="p-3">
            <h6 class="text-muted text-uppercase small mb-3">Menú Principal</h6>
            
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>

            <!-- Reportes Globales -->
            <a href="{{ route('reportes.index') }}" class="sidebar-item {{ request()->routeIs('reportes.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-bar-graph"></i>
                <span>Reportes y Estadísticas</span>
            </a>

            <a href="{{ route('facturas.create') }}" class="sidebar-item {{ request()->routeIs('facturas.create') ? 'active' : '' }}">
                <i class="bi bi-cart-plus"></i>
                <span>Nueva Venta</span>
            </a>

            <!-- Facturas (Documentos) -->
            <a href="{{ route('facturas.index') }}" class="sidebar-item {{ request()->routeIs('facturas.index') ? 'active' : '' }}">
                <i class="bi bi-receipt"></i>
                <span>Historial Facturas</span>
            </a>

            <!-- Devoluciones -->
            <a href="{{ route('devoluciones.index') }}" class="sidebar-item {{ request()->routeIs('devoluciones.*') ? 'active' : '' }}">
                <i class="bi bi-arrow-return-left"></i>
                <span>Devoluciones</span>
            </a>
        </div>

        <hr class="my-2">

        <div class="p-3">
            <h6 class="text-muted text-uppercase small mb-3">Gestión</h6>
            
            <!-- Clientes -->
            <a href="{{ route('clientes.index') }}" class="sidebar-item {{ request()->routeIs('clientes.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                <span>Clientes</span>
            </a>

            <!-- Proveedores -->
            <a href="{{ route('proveedores.index') }}" class="sidebar-item {{ request()->routeIs('proveedores.*') ? 'active' : '' }}">
                <i class="bi bi-truck"></i>
                <span>Proveedores</span>
            </a>

            <!-- Artículos -->
            <a href="{{ route('articulos.index') }}" class="sidebar-item {{ request()->routeIs('articulos.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i>
                <span>Artículos</span>
            </a>

            <!-- Compras -->
            <a href="{{ route('compras.index') }}" class="sidebar-item {{ request()->routeIs('compras.*') ? 'active' : '' }}">
                <i class="bi bi-bag-plus"></i>
                <span>Gestión de Compras</span>
            </a>

            <!-- Ventas -->
            <a href="{{ route('ventas.index') }}" class="sidebar-item {{ request()->routeIs('ventas.*') ? 'active' : '' }}">
                <i class="bi bi-bag-check"></i>
                <span>Gestión de Ventas</span>
            </a>
        </div>

        <hr class="my-2">

        <div class="p-3">
            <h6 class="text-muted text-uppercase small mb-3">Configuración</h6>
            
            <!-- Ciudades -->
            <a href="{{ route('ciudades.index') }}" class="sidebar-item {{ request()->routeIs('ciudades.*') ? 'active' : '' }}">
                <i class="bi bi-geo-alt"></i>
                <span>Ciudades</span>
            </a>

            <!-- Tipos de Documento -->
            <a href="{{ route('tipos-documento.index') }}" class="sidebar-item {{ request()->routeIs('tipos-documento.*') ? 'active' : '' }}">
                <i class="bi bi-card-text"></i>
                <span>Tipos Documento</span>
            </a>

            <!-- Tipos de Artículo -->
            <a href="{{ route('tipos-articulo.index') }}" class="sidebar-item {{ request()->routeIs('tipos-articulo.*') ? 'active' : '' }}">
                <i class="bi bi-tags"></i>
                <span>Tipos Artículo</span>
            </a>

            <!-- Formas de Pago (Eliminado) -->
            {{-- 
            <a href="{{ route('formas-pago.index') }}" class="sidebar-item {{ request()->routeIs('formas-pago.*') ? 'active' : '' }}">
                <i class="bi bi-credit-card"></i>
                <span>Formas de Pago</span>
            </a>
            --}}
        </div>
    </div>

    <!-- Sección inferior fija -->
    <div class="border-top p-3">
        <!-- Selector de tema -->
        <button class="sidebar-item w-100 text-start border-0 bg-transparent selector-tema" type="button">
            <i class="bi bi-moon-stars icono-luna"></i>
            <i class="bi bi-sun icono-sol" style="display: none;"></i>
            <span>Cambiar tema</span>
        </button>

        <!-- Cerrar sesión -->
        <form method="POST" action="{{ route('logout') }}" class="mt-2">
            @csrf
            <button type="submit" class="sidebar-item w-100 text-start border-0 bg-transparent text-danger">
                <i class="bi bi-box-arrow-right"></i>
                <span>Cerrar Sesión</span>
            </button>
        </form>

        <!-- Info del usuario -->
        <div class="mt-3 pt-3 border-top">
            <div class="d-flex align-items-center">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" 
                     style="width: 32px; height: 32px; font-size: 0.85rem;">
                    <i class="bi bi-person-fill"></i>
                </div>
                <div class="small">
                    <div class="fw-semibold">{{ auth()->user()->nombre }}</div>
                    <div class="text-muted" style="font-size: 0.75rem;">Administrador</div>
                </div>
            </div>
        </div>
    </div>
</div>
