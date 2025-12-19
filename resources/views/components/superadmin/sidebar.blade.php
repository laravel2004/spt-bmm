<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <!-- Logo Section -->
                <div class="img-fluid">
                    <img src="{{ asset('clients/assets/images/logo.png') }}" alt="Logo" width="150" height="150">
                    <br/>
                    <h5 class="logo-text ms-3">CMS Superadmin</h5>
                </div>
                <!-- Theme Toggle -->
                <div class="theme-toggle d-flex gap-2 align-items-center mt-2">
                    <!-- SVG icons and theme switcher -->
                </div>
                <!-- Sidebar Toggler -->
                <div class="sidebar-toggler x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>
                <li class="sidebar-item {{ activeState('superadmin.dashboard') }}">
                    <a href="{{ route('superadmin.dashboard') }}" class="sidebar-link">
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-title">Master Data</li>
                <li class="sidebar-item {{ activeState('superadmin.mapping-transportir.index') }}">
                    <a href="{{ route('superadmin.mapping-transportir.index') }}" class="sidebar-link">
                        <i class="bi bi-diagram-2"></i>
                        <span>Mapping Transportir</span>
                    </a>
                </li>
                <li class="sidebar-item {{ activeState('superadmin.transportir.index') }}">
                    <a href="{{ route('superadmin.transportir.index') }}" class="sidebar-link">
                        <i class="bi bi-shop"></i>
                        <span>Transportir</span>
                    </a>
                </li>
                <li class="sidebar-item {{ activeState('superadmin.customer.index') }}">
                    <a href="{{ route('superadmin.customer.index') }}" class="sidebar-link">
                        <i class="bi bi-building-fill-gear"></i>
                        <span>Customers</span>
                    </a>
                </li>
                <li class="sidebar-item {{ activeState('superadmin.driver.index') }}">
                    <a href="{{ route('superadmin.driver.index') }}" class="sidebar-link">
                        <i class="bi bi-person-badge-fill"></i>
                        <span>Drivers</span>
                    </a>
                </li>
                <li class="sidebar-item {{ activeState('superadmin.vehicle.index') }}">
                    <a href="{{ route('superadmin.vehicle.index') }}" class="sidebar-link">
                        <i class="bi bi-truck-front"></i>
                        <span>Vehicle</span>
                    </a>
                </li>

                <li class="sidebar-title">Users Management</li>
                <li class="sidebar-item {{ activeState('superadmin.user-management.index') }}">
                    <a href="{{ route('superadmin.user-management.index') }}" class="sidebar-link">
                        <i class="bi bi-people"></i>
                        <span>User</span>
                    </a>
                </li>

                <!-- Logout Section -->
                <li class="sidebar-item">
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-flex align-items-center">
                        @csrf
                        <button type="submit" class="btn sidebar-link w-100 text-danger text-decoration-none d-flex align-items-center">
                            <i class="bi bi-box-arrow-right"></i>
                            <span class="ms-2">Logout</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
