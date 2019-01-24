<!DOCTYPE html>
<html lang="es-ES">
<head>
    <meta charset="utf-8">
</head>
  <body>
    <img src={{ asset('img/logo.png') }} class="rounded mx-auto d-block">
    <h2>
      Aviso con respecto a las Pausas solicitadas por: {!! $name !!}.
    </h2>
    <div>
      <h5>
        Cantidad de pausas: {!! $cantPausas !!}.<br>
        Nombre: {!! $name !!}.<br>
        Rut: {!! $rut !!}.<br>
        Email: {!! $email !!}.<br><br>
      </h5>
      <h4>
        @if($motivo==0)
          Motivo: Falta materiales<br><br>
        @endif
        @if($motivo==1)
          Motivo: Falla en el equipo<br><br>
        @endif
        @if($motivo==2)
          Motivo: Falla en el plano<br><br>
        @endif
        @if($motivo==3)
          Motivo: Cambio de pieza<br><br>
        @endif
        @if($motivo==4)
          Motivo: Otro<br><br>
          Detalles: {!! $detalle !!}.<br><br>
        @endif
      </h4>
      <h3>Descripcion: Aviso para realizar una supervision debido a la pausa realizadas por el trabajador.</h3>
    </div>
  </body>
</html>
