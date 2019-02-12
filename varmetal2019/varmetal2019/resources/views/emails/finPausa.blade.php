<!DOCTYPE html>
<html lang="es-ES">
<head>
    <meta charset="utf-8">
</head>
  <body>
    <img src={{ asset('img/logo.png') }} class="rounded mx-auto d-block">
    <h2>
      Aviso Pausa Finalizada por el supervisor:<br>
      Nombre: {!! $nombreSupervisor !!}.<br>
      Email: {!! $emailSupervisor !!}.<br><br>
    </h2>
    <div>
      <h4>
        @if($motivo==0)
          Pausa: Falta materiales.<br>
        @endif
        @if($motivo==1)
          Pausa: Falla en el equipo.<br>
        @endif
        @if($motivo==2)
          Pausa: Falla en el plano.<br>
        @endif
        @if($motivo==3)
          Pausa: Cambio de pieza.<br>
        @endif
        @if($motivo==4)
          Pausa: Otro.<br>
          Descripcion: {!! $descripcion !!}.<br>
        @endif
        Originada Por:<br>
        Nombre: {!! $nombreTrabajador !!}.<br>
        Rut: {!! $rutTrabajador !!}.<br>
        Email: {!! $emailTrabajador !!}.<br><br>
      </h4>
    </div>
  </body>
</html>
