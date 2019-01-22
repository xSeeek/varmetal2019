@component('mail::message')
  <h1>Cambio de Contraseña</h1>
  <p>{{$user->trabajador->nombre}}, recibimos una solicitud para efectuar un cambio de contraseña</p>
  @component('mail::panel')
    <a href="{!! route("password.reset", ["token"=>$token]) !!}">{!! route("password.reset", ["token"=>$token]) !!}</a>
  @endcomponent
  <p>Si no fuiste tu el que realizo esta solicitud, ignora este mensaje</p>
@endcomponent
