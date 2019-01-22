@component('mail::message')
  <h1>Registro</h1>
  <p>{{$user->trabajador->nombre}}, usted a sido registrado en la aplicación de asistencia de varmetal</p>
  <p>Sus datos son: </p>
  <ul>
    <li><b>Email: </b>{{$user->email}}</li>
    <li><b>Contraseña: </b>{{$contraseña}}</li>
  </ul>
@endcomponent
