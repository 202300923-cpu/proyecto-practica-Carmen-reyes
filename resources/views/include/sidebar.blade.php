<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">

    <!-- User Info -->
    <div class="user-info">
        <div class="image">
            <img src="{{ asset('images/user.png') }}" width="60" height="60" alt="User" />
        </div>
        <div class="info-container">
            <div class="name">{{ Auth::user()->name }}</div>
            <div class="email">{{ Auth::user()->email }}</div>
        </div>
    </div>

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
            <li class="{{ request()->is('customer*') ? 'active' : '' }}">
                <a href="{{ route('customer.index') }}">
                    <i class="material-icons">people</i>
                    <span>Clientes</span>
                </a>
            </li>

            <!-- Gestión de Accesorios (MENÚ DESPLEGABLE) -->
            <li class="{{ request()->is('accesorios*') || request()->is('category*') || request()->is('proveedores*') ? 'active' : '' }}">
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">inventory</i>
                    <span>Gestión de Accesorios</span>
                </a>

                <ul class="ml-menu">

                    <li class="{{ request()->is('category*') ? 'active' : '' }}">
                        <a href="{{ route('category.index') }}">
                            Categorías
                        </a>
                    </li>

                    <li class="{{ request()->is('accesorios*') ? 'active' : '' }}">
                        <a href="{{ route('accesorios.index') }}">
                            Accesorios
                        </a>
                    </li>

                    <li class="{{ request()->is('proveedores*') ? 'active' : '' }}">
                        <a href="{{ url('proveedores') }}">
                            Proveedores
                        </a>
                    </li>

                </ul>
            </li>

            <!-- Reparaciones -->
            <li class="{{ request()->is('reparaciones*') ? 'active' : '' }}">
                <a href="{{ url('reparaciones') }}">
                    <i class="material-icons">build</i>
                    <span>Gestión de Reparaciones</span>
                </a>
            </li>

            <!-- Entradas -->
            <li class="{{ request()->is('stock*') ? 'active' : '' }}">
                <a href="{{ route('stock.index') }}">
                    <i class="material-icons">input</i>
                    <span>Entradas</span>
                </a>
            </li>

            <!-- Facturación -->
            <li class="{{ request()->is('invoice*') ? 'active' : '' }}">
                <a href="{{ route('invoice.index') }}">
                    <i class="material-icons">receipt_long</i>
                    <span>Salidas / Facturación</span>
                </a>
            </li>

            <!-- Roles -->
            <li class="{{ request()->is('role*') ? 'active' : '' }}">
                <a href="{{ route('role.index') }}">
                    <i class="material-icons">verified_user</i>
                    <span>Gestión de Roles</span>
                </a>
            </li>

            <!-- Usuarios -->
            <li class="{{ request()->is('user*') ? 'active' : '' }}">
                <a href="{{ route('user.index') }}">
                    <i class="material-icons">admin_panel_settings</i>
                    <span>Gestión de Usuarios</span>
                </a>
            </li>

            <!-- Reportes -->
            <li class="{{ request()->is('report*') ? 'active' : '' }}">
                <a href="{{ route('report.index') }}">
                    <i class="material-icons">bar_chart</i>
                    <span>Reportes</span>
                </a>
            </li>

            <!-- Configuración -->
            <li class="{{ request()->is('comapany-setting') || request()->is('password-change') ? 'active' : '' }}">
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">settings</i>
                    <span>Configuración</span>
                </a>

                <ul class="ml-menu">
                    <li>
                        <a href="{{ route('company.index') }}">
                            Información de la empresa
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('password.index') }}">
                            Cambiar contraseña
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Logout -->
            <li>
                <a href="{{ url('logout') }}">
                    <i class="material-icons">logout</i>
                    <span>Cerrar sesión</span>
                </a>
            </li>

        </ul>
    </div>

</aside>