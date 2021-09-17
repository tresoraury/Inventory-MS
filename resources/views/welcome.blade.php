<!doctype html>
<html lang="{{ app()->getLocale() }}">
    
    <body>
        <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>HOME</title>

        <!-- Fonts -->
        

        <!-- Styles -->
        <style>
            html, body {
                background-color: black;
                color: grey;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
                
            }

            
             .full-height {
                height: 100vh;
            }

            .flex-center {
                color: blue;
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {

                position: absolute;
                right: 20px;
                top: 18px;
            }


            .content {
                text-align: center;
            }

            .title {
                font-size:84px;
            }

            .links > a {
                color: blue;
                padding: 0 600px;
                font-size: 30px;
                font-weight: 700;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            .card_image{
                 width: 350px;
                 height: 350px;
                 position: absolute;
                 top: 200px;
                 right: 540px;
            }

            h1{
             text-align: center;
             color: yellow; 
             }

             p{
             text-align: center;
             color: red;
             size: 70px;            
             }


            
            
        </style>

    </head>

 <h1> REGIDESO STOCK MANAGEMENT</h1>
 <p> Veuiller Clicker sur connection pour vous connecter</p>

        
    <div class="flex-center position-ref ">
         
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ url('/login') }}">Connection</a>
                        
                    @endif
                </div>
            </nav>
            </div>

            @endif
                
            
        </div>
        <div class="card">
        <img class="card_image" src="photo.jpg" width="200px">
    </div>
    </body>
</html>