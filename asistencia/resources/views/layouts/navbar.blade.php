@extends('layouts.headers')

@section('body')
  <div id="app">
    <nav class="navbar sticky-top navbar-expand-md navbar-light navbar-laravel">
      <div class="container">

        <a class="navbar-brand" href="{{ route('home') }}">
            {{ config('app.name', 'Laravel') }}
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Left Side Of Navbar -->
          <ul class="navbar-nav mr-auto">
            <!--Data table-->
            <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
            <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

          </ul>
          <!-- Right Side Of Navbar -->
          <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            <li class="nav-item">
              <a href="/" class="nav-link">Gestion de producción</a>
            </li>
            @guest
              <li class="nav-item">
                  <a class="nav-link" href="{{ route('login') }}">{{ __('Ingresar Administrador') }}</a>
              </li>
            @else
              <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    Menu <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                  @if (Auth::user()->isAdmin())
                      <a href="{!! route('administrador.menuAdministrador') !!}" class="dropdown-item">Menu Administrador</a>
                  @endif
                  <a class="dropdown-item" href="{{ route('logout') }}"
                     onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                      {{ __('Logout') }}
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                  </form>
                </div>
              </li>
            @endguest
          </ul>
        </div>
      </div>
    </nav>
    <main>
      @yield('main')
    </main>

    <footer class="footer mt-5">
      <div class="container">
        <span class="text-muted float-right"><i class="fas fa-copyright"></i> Derechos reservados <a class="font-bold"><p>Departamento Informatica Varmetal 2019</p></a>
      </div>
    </footer>
  </div>

  <script type="text/javascript">
    $(document).ready(function() {
      @if (session()->has('success'))
        showMensajeSwall(MSG_SUCCESS, "{{session()->get('success')}}");
       @elseif (session()->has('error'))
        showMensajeSwall(MSG_ERROR, "{{session()->get('error')}}");
       @endif
     });
     $(function () {
       $('[data-toggle="tooltip"]').tooltip();
     });
  </script>
@endsection
