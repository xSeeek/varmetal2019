<!DOCTYPE html>
<html lang="es-ES">
<head>
    <meta charset="utf-8">
</head>
  <body>
    <h2>
      Felicidades {!! $nombre !!} tu cuenta fue registrada con exito.
    </h2>
    <div>
      <h5>
        <h4>Datos de la cuenta:<h4><br>
        Nombre: {!! $nombre !!}.<br>
        Rut: {!! $rut !!}.<br>
        Email: {!! $email !!}.<br>
        Contraseña: {!! $password !!}.
        <br><br>
      </h5>
      <h4>
        Usted es <h3>{!! $tipo !!}<h3>
      </h4>
      <h3>Si desea cambiar su contraseña, presione aquí: http://gestion.varmetal.cl/password/reset</h3>
    </div>
  </body>
</html>
