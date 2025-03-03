<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact - Stock Management</title>

    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;600&display=swap" rel="stylesheet">

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

        .contact-info {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .links {
            margin-top: 20px;
        }

        .links > a {
            color: #2196F3;
            padding: 10px 20px;
            font-size: 18px;
            text-decoration: none;
            border: 2px solid #2196F3;
            border-radius: 5px;
        }

        .links > a:hover {
            background-color: #2196F3;
            color: white;
        }
    </style>
</head>

<body>
    <h1>Contact Us</h1>
    
    <div class="contact-info">
        <p>Email: aurytresorishimwe@gmail.com</p>
        <p>Phone: +25765184785</p>
    </div>

    <div class="links">
        <a href="{{ url('/') }}">Back to Home</a>
    </div>
</body>
</html>