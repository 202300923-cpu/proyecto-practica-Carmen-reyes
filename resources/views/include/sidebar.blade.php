<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">

    <!-- User Info -->
    <div class="user-info">
        <div class="image">
            <img src="{{ url('images/user.png') }}" width="60" height="60" alt="User" />
        </div>
        <div class="info-container">
            <div class="name">{{ Auth::user()->name }}</div>
            <div class="email">{{ Auth::user()->email }}</div>
        </div>
    </div>
    <!-- #User Info -->

    <!-- Menu -->
    <div class="menu">
        <ul class="list">

            <li class="header">NAVEGACIÓN PRINCIPAL</li>

            <!-- Dashboard -->
            <li class="{{ request()->is('/') ? 'active' : '' }}">
                <a href="{{ url('/') }}">
                    <i class="material-icons">dashboard</i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Clientes -->
            <li>
                <a href="{{ route('customers.index') }}">
                    <i class="material-icons">people</i>
                    <span>Clientes</span>
                </a>
            </li>

            <!-- Gestión de Accesorios -->
            <li>
                <a href="{{ route('products.index') }}">
                    <i class="material-icons">inventory</i>
                    <span>Gestión de Accesorios</span>
                </a>
            </li>

            <!-- Gestión de Etiquetas (DESPLEGABLE) -->
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">label</i>
                    <span>Gestión de Etiquetas</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="{{ route('labels.index') }}">Listado de Etiquetas</a>
                    </li>
                    <li>
                        <a href="{{ route('labels.create') }}">Nueva Etiqueta</a>
                    </li>
                </ul>
            </li>
            
             <!-- Gestión de Reparaciones -->
            <li>
                <a href="{{ route('reparaciones.index') }}">
                    <i class="material-icons">build</i>
                    <span>Gestión de Reparaciones</span>
                </a>
            </li>


            <!-- Entradas -->
            <li>
                <a href="{{ route('entries.index') }}">
                    <i class="material-icons">input</i>
                    <span>Entradas</span>
                </a>
            </li>

            <!-- Salidas / Facturación -->
            <li>
                <a href="{{ route('sells.index') }}">
                    <i class="material-icons">receipt_long</i>
                    <span>Salidas / Facturación</span>
                </a>
            </li>

           
            <!-- Usuarios -->
            <li>
                <a href="{{ route('users.index') }}">
                    <i class="material-icons">admin_panel_settings</i>
                    <span>Gestión de Usuarios</span>
                </a>
            </li>

            <!-- Reportes -->
            <li>
                <a href="{{ route('reports.index') }}">
                    <i class="material-icons">bar_chart</i>
                    <span>Reportes</span>
                </a>
            </li>

            <!-- Configuración -->
            <li>
                <a href="{{ route('settings.index') }}">
                    <i class="material-icons">settings</i>
                    <span>Configuración</span>
                </a>
            </li>

        </ul>
    </div>
</aside>
<!-- #END# Left Sidebar -->