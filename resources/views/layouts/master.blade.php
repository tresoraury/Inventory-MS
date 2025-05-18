<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>@yield('title')</title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  
  
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" crossorigin="anonymous">
  
  
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../assets/css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />
  <link href="{{ asset('assets/css/custom-dashboard.css') }}" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/dataTables.min.css') }}">

  <style>
    .sidebar {
      position: fixed;  
      height: 100%;     
      overflow-y: auto; 
    }

    .sidebar .nav {
      padding-top: 20px; 
    }

    .dropdown-menu {
      border: 1px solid #ccc;
      border-radius: 4px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .dropdown-item {
      color: #333;
      padding: 10px 15px;
    }

    .dropdown-item:hover {
      color: #000;
    }

    .sidebar .active {
      background-color: #f39c12; 
    }

    .sidebar-header {
      padding: 20px 0;
      background-color: #343a40;
    }

    .sidebar-header h2 {
      color: white;
      margin: 0;
    }

    .sidebar-header p {
      color: white;
      font-style: italic;
    }
  </style>
</head>

<body class="">
  <div class="wrapper">
    <div class="sidebar" data-color="black">
      <div class="sidebar-wrapper" id="sidebar-wrapper">
        <ul class="nav">
          <li class="{{ 'dashboard' == request()->path() ? 'active' : '' }}">
            <a href="/dashboard">
              <i class="fas fa-home fa-5x"></i>
              <p>HOME</p>
            </a>
          </li>
          <li class="{{ request()->routeIs('pos.index') ? 'active' : '' }}">
            <a href="{{ route('pos.index') }}">
              <i class="fas fa-cash-register"></i> 
              <p>POS</p>
            </a>
          </li>
          <li class="{{ 'categorie' == request()->path() ? 'active' : '' }}">
            <a href="{{ url('categorie') }}">
              <i class="fa fa-align-center"></i>
              <p>CATEGORY</p>
            </a>
          </li>
          <li class="{{ 'magasin' == request()->path() ? 'active' : '' }}">
            <a href="{{ url('magasin') }}">
              <i class="fa fa-shopping-cart"></i>
              <p>Operations</p>
            </a>
          </li>
          <li class="{{ 'materiaux' == request()->path() ? 'active' : '' }}">
            <a href="/materiaux">
              <i class="fas fa-tools"></i>
              <p>PRODUCTS</p>
            </a>
          </li>
          <li class="{{ request()->routeIs('roles.index') ? 'active' : '' }}">
            <a href="{{ route('roles.index') }}">
              <i class="fas fa-user-shield"></i>
              <p>ROLES</p>
            </a>
          </li>
          <li class="{{ 'role-register' == request()->path() ? 'active' : '' }}">
            <a href="/role-register">
              <i class="now-ui-icons users_single-02"></i>
              <p>USERS</p>
            </a>
          </li>
          <li class="{{ 'partenaire' == request()->path() ? 'active' : '' }}">
            <a href="/partenaire">
              <i class="fas fa-cart-arrow-down"></i>
              <p>SUPPLIER</p>
            </a>
          </li>
          <li class="{{ 'input-operations' == request()->path() ? 'active' : '' }}">
            <a href="/input-operations">
              <i class="fas fa-list"></i> 
              <p>INPUT OPERATIONS</p>
            </a>
          </li>
          <li class="{{ request()->routeIs('low_stock') ? 'active' : '' }}">
            <a href="{{ route('low_stock') }}">
              <i class="fas fa-exclamation-triangle"></i>
              <p>Low Stock Alerts</p>
            </a>
          </li>
          <li class="{{ request()->routeIs('reports.index') ? 'active' : '' }}">
            <a href="{{ route('reports.index') }}">
                <i class="fas fa-chart-line"></i>
                <p>Reports</p>
            </a>
          </li>
        </ul>
      </div>
    </div>

    <div class="main-panel" id="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent bg-primary navbar-absolute">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="#pablo">Welcome </a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <ul class="navbar-nav">
              <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  {{ Auth::user()->name }} <span class="caret"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                  <li>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                      LOGOUT
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      {{ csrf_field() }}
                    </form>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->

      <div class="panel-header panel-header-sm"></div>
      <div class="content">
        @yield('content')
      </div>
    </div>
  </div>

  <!-- JS Files -->
  <script src="../assets/js/core/jquery.min.js"></script>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="{{ asset('assets/js/dataTables.min.js') }}"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <script src="../assets/js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript"></script>
  <script src="{{ asset('assets/js/sweetalert.js') }}"></script>
  
  <script>
    @if (session('status'))
      swal({
        title: '{{ session('status') }}',
        icon: '{{ session('statuscode') }}',
        button: "OK!",
      });
    @endif
  </script>

  @yield('scripts')
</body>

</html>