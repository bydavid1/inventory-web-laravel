<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
<<<<<<< HEAD
            body{
                padding: 0;
                background-image: url('assets/media/welcome.jpg');
                background-repeat: no-repeat;
            }
            .c-container{
                color: rgb(255, 255, 255);
=======
            html, body {
                background-color: #fff;
                color: #636b6f;
>>>>>>> database
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }
<<<<<<< HEAD
            .full-height {
                height: 100vh;
            }
=======

            .full-height {
                height: 100vh;
            }

>>>>>>> database
            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }
<<<<<<< HEAD
            .position-ref {
                position: relative;
            }
=======

            .position-ref {
                position: relative;
            }

>>>>>>> database
            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }
<<<<<<< HEAD
            .content {
                text-align: center;
            }
            .title {
                font-size: 84px;
            }
            .subtitle {
                font-size: 30px;
            }
            .links > div > a {
                color: #fff;
=======

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
>>>>>>> database
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }
<<<<<<< HEAD
            .m-b-md {
                margin-bottom: 30px;
            }
            .m-b-sm {
                margin-bottom: 20px;
            }
            .m-b-lg {
                margin-bottom: 40px;
            }
            .btn-sign{
                text-decoration: none;
                font-size: 16px;
                font-weight: 500;
                line-height: 24px;
                -webkit-box-pack: center;
                justify-content: center;
                -webkit-box-align: center;
                align-items: center;
                align-content: center;
                padding: 10px 20px;
                max-width: 400px;
                background-color: #0081FF;
                color: rgb(255, 255, 255);
                border-radius: 4px;
                height: 60px;
                margin-bottom: 24px;
                height: 48px;
                position: relative;
                border: none;
            }
        </style>
    </head>
    <body>
        <div class="c-container">
            <div class="flex-center position-ref full-height">
                <div class="content">
                    <div class="title m-b-sm">
                        POS System
                    </div>
                    <div class="subtitle m-b-md">
                        Hecho con Laravel y vue
                    </div>
                    <div class="m-b-lg">
                        @if (Route::has('login'))
                                @auth
                                    <a href="{{ url('/home') }}" class="btn-sign">Panel de control</a>
                                @else
                                    <a href="{{ route('login') }}" class="btn-sign">Iniciar Sesion</a>
                                @endauth
                        @endif
                    </div>
=======

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Panel de control</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>

                <div class="links">
                    <a href="https://laravel.com/docs">Docs</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://blog.laravel.com">Blog</a>
                    <a href="https://nova.laravel.com">Nova</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://vapor.laravel.com">Vapor</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
>>>>>>> database
                </div>
            </div>
        </div>
    </body>
</html>
