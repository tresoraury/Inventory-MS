<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    @yield('title')
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <!-- CSS Files -->
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" /> 
  <link href="../assets/css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="../assets/demo/demo.css" rel="stylesheet" />
  <link href="{{ asset('assets/css/custom-dashboard.css') }}" rel="stylesheet" />

  <link rel="stylesheet" href="{{ asset('assets/css/dataTables.min.css') }}">

  <link href="{{ asset('assets/css/custom-dashboard.css') }}" rel="stylesheet" />
</head>
<style>
  <style>
  .dropdown-menu {
    /*background-color: #ffffff;  Light background for better contrast */
    border: 1px solid #ccc; /* Subtle border */
    border-radius: 4px; /* Rounded corners */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Soft shadow for depth */
  }

  .dropdown-item {
    color: #333; /* Dark text color for better readability */
    padding: 10px 15px; /* Padding for better touch targets */
  }

  .dropdown-item:hover {
    /*background-color: #f1f1f1; /* Light grey on hover */
    color: #000; /* Dark text on hover */
  }

  .dropdown-item:focus {
    outline: none; /* Remove outline on focus */
    /*background-color: #e9ecef; /* Slightly darker grey for focus */
  }
  .sidebar .active {
    background-color: #f39c12; 
    /*color: #fff; 
}
.sidebar-header {
    padding: 20px 0;
    background-color: #343a40; /* Dark background for the header */
}

.sidebar-header h2 {
    color: white; /* Title color */
    margin: 0; /* Remove default margin */
}

.sidebar-header p {
    color: white; /* Tagline color */
    font-style: italic; /* Italic style for the tagline */
}
</style>
</style>

<body class="">
  <div class="wrapper ">
  <div class="sidebar" data-color="black">
    <!-- Custom Title or Logo Section -->
    <!--<div class="sidebar-header" style="text-align: center; padding: 20px;">
        <h2 style="color: white; margin: 0;">Inventory Management</h2>
        <!-- Uncomment the following line to use a logo instead -->
        <!-- <img class="card_image" src="path/to/your/logo.png" alt="Logo" style="width: 100%; height: auto;"> 
        <p style="color: white; font-style: italic;">Manage your inventory effortlessly.</p>
    </div> -->

    <div class="sidebar-wrapper" id="sidebar-wrapper">
        <ul class="nav">
            <li class="{{ 'dashboard' == request()->path() ? 'active' : '' }}">
                <a href="/dashboard">
                    <i class="fas fa-home fa-5x"></i>
                    <p>HOME</p>
                </a>
            </li>
            <li>
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
            <li>
              <a href="{{ route('low_stock') }}">
                <i class="fas fa-exclamation-triangle"></i>
                <p>Low Stock Alerts</p>
              </a>
            </li>
            <li>
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
      <nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="#pablo">LISTE DES TABLE</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <form>
              <div class="input-group no-border">
                
                <div class="input-group-append">
                  <div class="input-group-text">
                    
                  </div>
                </div>
              </div>
            </form>
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="#pablo">
                  
                  <p>
                    
                  </p>
                </a>
              </li>
               
              <li class="nav-item dropdown">
                           <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                  {{ Auth::user()->name }} <span class="caret"></span>
                              </a>

                           <ul class="dropdown-menu dropdown-menu-right" role="menu">
                         <li>
                         <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                       LOGOUT
                       </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>


              {{-- <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="now-ui-icons location_world"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Some Actions</span>
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="#">Action</a>
                  <a class="dropdown-item" href="#">Another action</a>
                  <a class="dropdown-item" href="#">Something else here</a>
                </div>
              </li> --}}
              <li class="nav-item">
                <a class="nav-link" href="#pablo">
                  <i class="now-ui-icons users_single-02"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Account</span>
                  </p>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
     
      

      <div class="panel-header panel-header-sm">
      </div>
      <div class="content">
        @yield('content')

         
       
      </div>
      
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="../assets/js/core/jquery.min.js"></script>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>

  <script src="{{ asset('assets/js/dataTables.min.js') }}"></script>

  <script type="text/javascript" src="js/jquery.printPage.js"></script>

  <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chart JS -->
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="../assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript"></script><!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
  <script src="../assets/demo/demo.js"></script>

  <script src="{{ asset('assets/js/sweetalert.js') }}"></script>
  
  <script>
    @if (session('status'))
        
        swal({
            title: '{{ session('status') }}',
            //text: "You clicked the button!",
            icon: '{{ session('statuscode') }}',
            button: "OK!",
           });
    @endif
  </script>

  @yield('scripts')
</body>

</html>