<!DOCTYPE html>
<html lang="es-ES">
<head>
    <meta charset="utf-8">
</head>
  <body>
      @php
        $tipoUsuario = null;
        if($tipo == 0)
            $tipoUsuario = "Operador";
        elseif($tipo == 1)
            $tipoUsuario = "Administrador";
        else
            $tipoUsuario = "Supervisor";
        @endphp
    <h2>
      {!! $nombre !!}, Bienvenido a Varmetal.
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
        Se le ha creado una cuenta de tipo: <h3>{!! $tipoUsuario !!}<h3>
      </h4>
      <h3>Si desea cambiar su contraseña, presione aquí: http://gestion.varmetal.cl/password/reset</h3>
    </div>
  </body>
</html>
