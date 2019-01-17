<?php

namespace Varmetal\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use Auth;
use Varmetal\User;

class EmailController extends Controller
{
    public function sendEmailRegistro(Request $data)
    {
      $dataArray = array(
        'nombre' => $data->nameTrabajador,
        'email' => $data->email,
        'password' => $data->password,
        'tipo' => $data->type,
        'rut' => $data->rutTrabajador,
      );
      Mail::send('emails.registrado', $dataArray, function($message){
        $user = User::orderBy('id', 'DESC')->first();
        $actual = Auth::user();
        $message->from($actual->email,'Departamento de Informática Varmetal');
        $message->to($user->email)->subject('Cuenta Registrada con exito');
      });
      return 'Email enviado registrado';
    }

    public function sendEmailPausas(Request $request)
    {
      $response = JSON_decode($request->DATA, true);
      $data = array(
          'name' => $response[0],
          'rut' => $response[1],
          'email' => $response[2],
          'cantPausas' => $response[3],
          'detalle' => $response[4],
          'motivo' => $response[5],
      );
      Mail::send('emails.pausas', $data, function($message){
        $user = Auth::user();
        $users = User::all();
        $nombre = $user->trabajador->nombre;
        $message->from($user->email, $nombre);
        foreach ($users as $key => $supervisor) {
          if($supervisor->type == 'Supervisor')
          {
            $message->to($supervisor->email)->subject('Aviso Numero de Pausas');
          }
        }
      });
      return "Email enviado";
    }

    public function sendEmailProducto(Request $request)
    {
      $response = JSON_decode($request->DATA, true);

      $data = array(
          'name' => $response[0],
          'rut' => $response[1],
          'email' => $response[2],
          'nombreProducto' => $response[3],
          'codigoProducto' => $response[4],
          'cantProductos' => $response[5]+1,
      );
      Mail::send('emails.productos', $data, function($message){
        $user = Auth::user();
        $users = User::all();
        $nombre = $user->trabajador->nombre;
        $message->from($user->email, $nombre);
        foreach ($users as $key => $supervisor) {
          if($supervisor->type == 'Supervisor')
          {
            $message->to($supervisor->email)->subject('Aviso 5 Productos Terminados');
          }
        }
      });
      return "Email enviado producto";
    }
    public function sendEmailProductoTerminado(Request $request)
    {
      $response = JSON_decode($request->DATA, true);

      $data = array(
          'name' => $response[0],
          'rut' => $response[1],
          'email' => $response[2],
          'nombreProducto' => $response[3],
          'codigoProducto' => $response[4],
      );
      Mail::send('emails.productoTerminado', $data, function($message){
        $user = Auth::user();
        $users = User::all();
        $nombre = $user->trabajador->nombre;
        $message->from($user->email, $nombre);
        foreach ($users as $key => $supervisor) {
          if($supervisor->type == 'Supervisor')
          {
            $message->to($supervisor->email)->subject('Aviso Producto Terminado');
          }
        }
      });
      return "Email enviado producto Terminado";
    }
}
