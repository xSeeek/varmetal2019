<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Varmetal</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            #content_page{
                position: fixed;
                left: 0;
                right: 0;
                z-index: 9999;
                margin-left: 20px;
                margin-right: 20px;
            }

            #bg_image {
                position: fixed;
                left: 0;
                right: 0;
                z-index: 1;

                display: block;
                background-image:url({{url('img/background.jpg')}});
                width: 100%;
                height: 100%;

                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;

                -webkit-filter: blur(8px);
                -moz-filter: blur(8px);
                -o-filter: blur(8px);
                -ms-filter: blur(8px);
                filter: blur(8px);

            }
        </style>
    </head>
    <body>
        <div id = "bg_image"></div>
        <div class="flex-center position-ref full-height" id="content_page">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}" style="color:white"><b>Home</b></a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();" style="color:white">
                            <b>{{ __('Logout') }}</b>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @else
                        <a href="{{ route('login') }}" style="color:white"><b>Login</b></a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    <img src={{ asset('img/logo.png') }} class="rounded mx-auto d-block">
                </div>
            </div>
        </div>
    </body>
</html>
