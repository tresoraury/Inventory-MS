<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Inventory Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: #ffffff;
            position: fixed;
            top: 0;
            bottom: 0;
            overflow-y: auto;
            z-index: 1000;
        }
        .sidebar .nav-link {
            color: #ffffff;
            padding: 10px 15px;
            transition: background-color 0.2s ease-in-out;
        }
        .sidebar .nav-link:hover {
            background-color: #17a2b8;
        }
        .sidebar .nav-link.active {
            background-color: #17a2b8;
            font-weight: 600;
        }
        .sidebar-brand {
            font-weight: 700;
            color: #ffffff !important;
            padding: 15px;
            display: block;
            text-align: center;
        }
        .content-wrapper {
            margin-left: 250px;
            flex: 1;
            padding: 20px;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .content-wrapper {
                margin-left: 0;
            }
            .sidebar-toggle {
                display: block;
            }
        }
        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 10px;
            left: 10px;
            z-index: 1100;
        }
        .dropdown-menu {
            background-color: #343a40;
            border: none;
        }
        .dropdown-item {
            color: #ffffff;
        }
        .dropdown-item:hover {
            background-color: #17a2b8;
            color: #ffffff;
        }
        @media print {
            body * {
                visibility: hidden;
            }
            .receipt-container, .receipt-container * {
                visibility: visible;
            }
            .sidebar, .sidebar-toggle, form, .btn, .no-print, .alert, .table:not(.receipt-table) {
                display: none !important;
            }
            .content-wrapper {
                margin-left: 0;
                padding: 0;
            }
            .card {
                border: none;
                box-shadow: none;
            }
            .card-body {
                padding: 0;
            }
            h5.card-title {
                font-size: 18px;
                margin-bottom: 10px;
            }
            p {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <button class="btn btn-dark sidebar-toggle no-print" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <div class="sidebar no-print">
        <a class="sidebar-brand" href="{{ route('dashboard') }}">Inventory MS</a>
        <ul class="nav flex-column">
            @can('view dashboard')
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                </li>
            @endcan
            @can('manage products')
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                        <i class="fas fa-box me-2"></i> Products
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                        <i class="fas fa-list me-2"></i> Categories
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('suppliers.*') ? 'active' : '' }}" href="{{ route('suppliers.index') }}">
                        <i class="fas fa-truck me-2"></i> Suppliers
                    </a>
                </li>
            @endcan
            @can('manage operation types')
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('operation_types.*') ? 'active' : '' }}" href="{{ route('operation_types.index') }}">
                        <i class="fas fa-cogs me-2"></i> Operation Types
                    </a>
                </li>
            @endcan
            @can('manage stock')
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('operations.*') ? 'active' : '' }}" href="{{ route('operations.index') }}">
                        <i class="fas fa-exchange-alt me-2"></i> Operations
                    </a>
                </li>
            @endcan
            @can('manage sales')
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('pos.*') ? 'active' : '' }}" href="{{ route('pos.index') }}">
                        <i class="fas fa-cash-register me-2"></i> POS
                    </a>
                </li>
            @endcan
            @can('manage customers')
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('customers.*') ? 'active' : '' }}" href="{{ route('customers.index') }}">
                        <i class="fas fa-users me-2"></i> Customers
                    </a>
                </li>
            @endcan
            @can('manage products')
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('low_stock') ? 'active' : '' }}" href="{{ route('low_stock') }}">
                        <i class="fas fa-exclamation-triangle me-2"></i> Low Stock
                    </a>
                </li>
            @endcan
            @can('manage purchase orders')
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('purchase_orders.*') ? 'active' : '' }}" href="{{ route('purchase_orders.index') }}">
                        <i class="fas fa-shopping-cart me-2"></i> Purchase Orders
                    </a>
                </li>
            @endcan
            @can('manage users')
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('roles.*') ? 'active' : '' }}" href="{{ route('roles.index') }}">
                        <i class="fas fa-user-shield me-2"></i> Roles
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('role.*') ? 'active' : '' }}" href="{{ route('role.register') }}">
                        <i class="fas fa-user me-2"></i> Users
                    </a>
                </li>
            @endcan
            @can('view reports')
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                        <i class="fas fa-chart-bar me-2"></i> Reports
                    </a>
                </li>
            @endcan
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>

    <div class="content-wrapper">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('active');
        }
    </script>
</body>
</html>