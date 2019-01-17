<!DOCTYPE html>
<html lang="es-ES">
<head>
    <meta charset="utf-8">
</head>
  <body>
    <img src={{ asset('/img/logo.png') }} class="rounded mx-auto d-block">
    <h2>
      Aviso: {!! $nombreProducto !!} fué marcado como terminado/a.
    </h2>
    <div>
      <h4>
        Codigo de la Pieza: {!! $codigoProducto !!}.
      </h4>
      <h5>
        Email solicitado por el trabajador: {!! $email !!}.<br>
        Nombre: {!! $name !!}.<br>
        Rut: {!! $rut !!}.<br>
      </h5>
      <h3>Descripcion: {!! $nombreProducto !!} Terminado/a, se solicita supervisión.</h3>
    </div>
  </body>
</html>
