<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.css')}}">

        <!-- Styles -->
        <style>
            body {
                background-image: url({{ asset('assets/media/welcome-backgroud.jpg') }})
            }
        </style>
    </head>
    <body>
        <div class="vh-100 d-flex justify-content-center align-items-center">
            <div class="card w-50">
                <div class="card-content">
                    <div class="card-body">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <img class="w-50" src="{{ asset('assets/media/ebox.png') }}" alt="logo">
                            <h4 class="pb-2">
                                Bienvenido de nuevo!
                            </h4>
                            @if (Route::has('login'))
                                <div class="top-right links">
                                    @auth
                                        <a class="btn btn-primary align-self-center" href="{{ url('/home') }}">Panel de control</a>
                                    @else
                                        <a class="btn btn-primary align-self-center" href="{{ route('login') }}">Iniciar sesion</a>
                                    @endauth
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
