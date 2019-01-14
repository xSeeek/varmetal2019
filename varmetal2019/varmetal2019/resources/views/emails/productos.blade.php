<!DOCTYPE html>
<html lang="es-ES">
<head>
    <meta charset="utf-8">
</head>
  <body>
    <h2>
      Aviso:{!! $cantProductos !!} {!! $nombreProducto !!} completados/as.
    </h2>
    <div>
      <h4>
        Codigo del producto: {!! $codigoProducto !!}
      </h4>
      <h5>
        Email solicitado por el trabajador: {!! $email !!}<br>
        Nombre: {!! $name !!}<br>
        Rut: {!! $rut !!}<br>
        Cantidad producida: {!! $cantProductos !!}<br>
      </h5>
      <h3>Descripcion: {!! $nombreProducto !!} completados/as, se solicita supervisión.</h3>
    </div>
  </body>
</html>
