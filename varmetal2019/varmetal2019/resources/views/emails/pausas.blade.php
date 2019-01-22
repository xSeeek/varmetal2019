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
        Motivo: {!! $motivo !!}<br><br>
        Detalles: {!! $detalle !!}.<br><br>
      </h4>
      <h3>Descripcion: Aviso para realizar una supervision debido a la pausa realizadas por el trabajador.</h3>
    </div>
  </body>
</html>