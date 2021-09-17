<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'TestApp') }}</title>
    <!-- Styles -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('css')
</head>
<body>
    <div id="app">
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        @auth
            <ul id="dropdown1" class="dropdown-content">
                <li><a href="{{ route('logout') }}" class="logout">{{ __('Logout') }}</a></li>

            </ul>
        @endauth
        <nav>
            <div class="nav-wrapper">
                <a href="{{ url('/') }}" class="brand-logo">retour</a>
                <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                @guest
                    <ul class="right hide-on-med-and-down">
                        <li><a href="{{ route('register') }}">{{ __('Register') }}</a></li>
                        
                    </ul>
                @else
                    <ul class="right hide-on-med-and-down">
                        <li><a class="dropdown-trigger" href="#!" data-target="dropdown1">{{ Auth::user()->name }}<i class="material-icons right"></i></a></li>
                    </ul>

                @endguest
            </div>
        </nav>
        <ul class="sidenav" id="mobile-demo">
            @guest
                <li><a href="{{ route('login') }}">{{ __('Login') }}</a></li>
                <li><a href="{{ route('register') }}">{{ __('Register') }}</a></li>
            @else

                <li><a href="{{ route('logout') }}" class="logout">{{ __('Logout') }}</a></li>

            @endguest
        </ul>
        @yield('content')
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('.sidenav').sidenav();
            $('.dropdown-trigger').dropdown();
            $('.logout').click(function(e) {
                e.preventDefault();
                $('#logout-form').submit();
            });
        });
    </script>
</body>
</html>