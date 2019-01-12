<?php

namespace Varmetal\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use Auth;
use Varmetal\User;

class EmailController extends Controller
{
    public function sendEmailPausas(Request $request)
    {
      $response = JSON_decode($request->DATA, true);

      $data = array(
          'name' => $response[0],
          'rut' => $response[1],
          'email' => $response[2],
      );
      Mail::send('emails.pausas', $data, function($message){
        $user = Auth::user();
        $users = User::all();
        $nombre = $user->trabajador->nombre;
        $message->from($user->email, $nombre);
        foreach ($users as $key => $user) {
          if($user->type == 'Admin')
          {
            $message->to($user->email)->subject('Aviso Numero de Pausas');
          }
        }
      });
      return "Email enviado";
    }
}
