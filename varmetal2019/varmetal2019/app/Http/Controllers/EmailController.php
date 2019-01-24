<?php

namespace Varmetal\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use Auth;
use Varmetal\User;
use Varmetal\Jobs;
/*use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;*/

class EmailController extends Controller //implements ShouldQueue
{
    //use InteractsWithQueue, Queueable, SerializesModels;

    public function emailPausaEliminada(Request $request)
    {
      $response = JSON_decode($request->DATA, true);
      $job = new \Varmetal\Jobs\EmailPausaEliminada($response);
      dispatch($job);
      return 'Email Pausa Eliminada';
    }


    public function sendEmailRegistro(Request $data)
    {
      $job = new \Varmetal\Jobs\SendEmailRegistro($data);
      dispatch($job);
      return 'Email Con Registro Enviado';
    }

    public function sendEmailPausas(Request $request)
    {
      $response = JSON_decode($request->DATA, true);
      $job = new \Varmetal\Jobs\SendEmailPausas($response);
      dispatch($job);
      return 'Pausa Realizada';
    }

    public function sendEmailProducto(Request $request)
    {
      $response = JSON_decode($request->DATA, true);
      $job = new \Varmetal\Jobs\SendEmailProducto($response);
      dispatch($job);
      return 'Email 5 o más productos terminados';
    }

    public function sendEmailProductoTerminado(Request $request)
    {
      $response = JSON_decode($request->DATA, true);
      $job = new \Varmetal\Jobs\SendEmailProductoTerminado($response);
      dispatch($job);
      return 'Email enviado producto Terminado';
    }
}
