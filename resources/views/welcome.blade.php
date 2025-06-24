<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome - Stock Management</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        body {
            background-color: #f0f0f0; 
            color: #333; 
            font-family: 'Raleway', sans-serif;
            margin: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
            position: relative;
        }

        h1 {
            font-size: 48px;
            color: #FF5722; 
            margin-bottom: 15px;
        }

        p {
            font-size: 20px;
            color: #555; 
            margin-bottom: 40px;
        }

        .links {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px; 
        }

        .links > a {
            color: #2196F3; 
            padding: 15px 30px;
            font-size: 18px;
            font-weight: 700;
            text-decoration: none;
            border: 2px solid #2196F3;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        .links > a:hover {
            background-color: #2196F3;
            color: white;
        }

        .top-right {
            position: absolute;
            right: 20px;
            top: 20px;
        }
    </style>
</head>

<body>
    <h1>Welcome to Your Inventory Hub</h1>
    
    <p>Effortlessly Manage Your Stock</p>

    <div class="links">
        @if (Route::has('login'))
            @if (Auth::check())
                <a href="{{ url('/home') }}">Go to Dashboard</a>
            @else
                <a href="{{ url('/login') }}">Login</a>
            @endif
        @endif
        <a href="{{ url('/about') }}">About Us</a>
        <a href="{{ url('/contact') }}">Contact Support</a>
    </div>
</body>
</html>