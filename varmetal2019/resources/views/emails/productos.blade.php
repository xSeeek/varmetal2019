<!DOCTYPE html>
<html lang="es-ES">
<head>
    <meta charset="utf-8">
</head>
  <body>
    <img src={{ asset('img/logo.png') }} class="rounded mx-auto d-block">
    <h2>
      Aviso:{!! $cantProductos !!} {!! $nombreProducto !!} completados/as.
    </h2>
    <div>
      <h4>
        Codigo de la Pieza: {!! $codigoProducto !!}.
      </h4>
      <h5>
        Email solicitado por el Operador: {!! $email !!}.<br>
        Nombre: {!! $name !!}.<br>
        Rut: {!! $rut !!}.<br>
        Cantidad producida: {!! $cantProductos !!}.<br>
      </h5>
      <h3>Descripcion: {!! $nombreProducto !!} completados/as, se solicita supervisión.</h3>
    </div>
  </body>
</html>
