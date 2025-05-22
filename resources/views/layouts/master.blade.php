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
        .navbar-dark .navbar-nav .nav-link {
            color: #ffffff;
            font-weight: 500;
            transition: color 0.2s ease-in-out;
        }
        .navbar-dark .navbar-nav .nav-link:hover {
            color: #17a2b8;
        }
        .navbar-dark .navbar-nav .nav-link.active {
            color: #17a2b8;
            font-weight: 600;
        }
        .navbar-brand {
            font-weight: 700;
            color: #ffffff !important;
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
            .navbar, form, .btn, .no-print {
                display: none !important;
            }
            .container {
                margin-top: 0;
            }
            .card {
                border: none;
                box-shadow: none;
            }
            .card-body {
                padding: 0;
            }
            .table {
                width: 100%;
                border-collapse: collapse;
            }
            .table th, .table td {
                border: 1px solid #000;
                padding: 8px;
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">Inventory MS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @can('view dashboard')
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                    @endcan
                    @can('manage products')
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">Categories</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('suppliers.*') ? 'active' : '' }}" href="{{ route('suppliers.index') }}">Suppliers</a>
                        </li>
                    @endcan
                    @can('manage operation types')
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('operation_types.*') ? 'active' : '' }}" href="{{ route('operation_types.index') }}">Operation Types</a>
                        </li>
                    @endcan
                    @can('manage stock')
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('operations.*') ? 'active' : '' }}" href="{{ route('operations.index') }}">Operations</a>
                        </li>
                    @endcan
                    @can('manage sales')
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('pos.*') ? 'active' : '' }}" href="{{ route('pos.index') }}">POS</a>
                        </li>
                    @endcan
                    @can('manage products')
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('low_stock') ? 'active' : '' }}" href="{{ route('low_stock') }}">Low Stock</a>
                        </li>
                    @endcan
                    @can('manage purchase orders')
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('purchase_orders.*') ? 'active' : '' }}" href="{{ route('purchase_orders.index') }}">Purchase Orders</a>
                        </li>
                    @endcan
                    @can('manage users')
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('roles.*') ? 'active' : '' }}" href="{{ route('roles.index') }}">Roles</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('role.*') ? 'active' : '' }}" href="{{ route('role.register') }}">Users</a>
                        </li>
                    @endcan
                    @can('view reports')
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                                <i class="fas fa-chart-bar"></i> Reports
                            </a>
                        </li>
                    @endcan
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>