<?php

namespace Varmetal\Jobs;

use Illuminate\Http\Request;
use Mail;
use Auth;
use Varmetal\User;
use Varmetal\Jobs;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmailProductoTerminado implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;
    public $tries = 5;
    public $timeout = 120;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($response)
    {
      $this->data = array(
          'name' => $response[0],
          'rut' => $response[1],
          'email' => $response[2],
          'nombreProducto' => $response[3],
          'codigoProducto' => $response[4],
          'idUser' => $response[5],
      );
    }

    public function sendEmailProductoTerminado()
    {
      Mail::send('emails.productoTerminado', $this->data, function($message){
        $user = User::find($this->data['idUser']);
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
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->sendEmailProductoTerminado();
    }
}
