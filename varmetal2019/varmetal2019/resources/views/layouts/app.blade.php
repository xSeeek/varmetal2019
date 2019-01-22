<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

    <!-- Sweet Alerts 2-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.28.4/dist/sweetalert2.all.min.js"></script>

    <!-- js ui -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!--Data table-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <link href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css" rel="stylesheet"/>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>

    <!--Rut Formater-->
    <script src={{asset("js/jquery.rut.js")}}></script>

    <!--Date Picker-->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- JS Mensajes -->
    <script src={{ asset("/js/mensajes.js")}}></script>
    <script src={{ asset("/js/notify.js")}}></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script src={{ asset("js/datatables.js")}}></script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}"><img src={{ asset('img/logo.png') }} class="rounded mx-auto d-block" style="width:161px;height:42px;"></a>
                <!--https://getbootstrap.com/docs/4.0/components/navbar/#how-it-works-->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                      <a class="btn btn-outline-primary btn-md" id="boton" onclick="detenerPausa()" role="button" style="display:none;">Ver Pausas</a>
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @else
                            @if(Auth::user()->type == 'Supervisor')
                              <audio id="alarma"></audio> <!--autoplay loop-->
                            @endif
                            <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Opciones
                              </a>
                              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ url('/') }}">Varmetal</a>
                                <div class="dropdown-divider"></div>
                                @if(Auth::user()->type == 'Supervisor')
                                  <a class="dropdown-item" href="{{url('/admin')}}">
                                      Volver al Inicio
                                  </a>
                                @else
                                  <a class="dropdown-item" href="{{url('/homepage/Trabajador')}}">
                                      Volver al Inicio
                                  </a>
                                @endif
                                <a class="dropdown-item" href="{{url('/cambiarContraseña')}}">Cambiar Contraseña</a>
                                <a class="dropdown-item" href="{{url('/cambiarEmail')}}">Cambiar Email</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                                <!--a id="navbarDropdown" class="nsv-link dropdown-toggle" color="black" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a-->
                              </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>

        <footer class="footer mt-5">
          <div class="container">
            <span class="text-muted float-right"><i class="fas fa-copyright"></i> Derechos reservados <a class="font-bold"><p>Departamento Informatica Varmetal 2019</p></a>
          </div>
        </footer>
    </div>
</body>
</html>

<script>

  window.setInterval(sistema(), 1000);

  function detenerPausa()
  {
    var alarma, boton, pathname = window.location.pathname;
    if(pathname == '/adminPausas')
    {
        boton = document.getElementById('boton');
        boton.style.display="none";
        alarma=document.getElementById('alarma');
        alarma.removeAttribute("src","/music/bleep.mp3");
        alarma.removeAttribute("autoplay","");
        alarma.removeAttribute("loop","");
    }
    else
    {
        boton = document.getElementById('boton');
        boton.style.display="none";
        alarma=document.getElementById('alarma');
        alarma.removeAttribute("src","/music/bleep.mp3");
        alarma.removeAttribute("autoplay","");
        alarma.removeAttribute("loop","");
        window.location.href = "{{url('adminPausas')}}";
    }
  }

  function sistema()
  {
    var alarma;
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: "{{url('/loopInfinito')}}",
        success: function(response){
            if(response == 1)
            {
              var alarma, boton;
              boton = document.getElementById('boton');
              boton.style.display="";
              boton.removeAttribute("readonly");
              alarma = document.getElementById('alarma');
              alarma.setAttribute("src","/music/bleep.mp3");
              alarma.setAttribute("autoplay","");
              alarma.setAttribute("loop","");
            }
        }
    });
      return 1;
  }
</script>
