<?php

namespace Varmetal\Jobs;

use Mail;
use Auth;
use Varmetal\User;
use Varmetal\Jobs;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmailPausas implements ShouldQueue
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
          'cantPausas' => $response[3],
          'detalle' => $response[4],
          'motivo' => $response[5],
          'idUser' => $response[6],
      );
    }

    public function sendEmailPausas()
    {
      Mail::send('emails.pausas', $this->data, function($message){
        $user = User::find($this->data['idUser']);
        $users = User::all();
        $nombre = $user->trabajador->nombre;
        $message->from($user->email, $nombre);
        foreach ($users as $key => $supervisor){
          if($supervisor->type == 'Supervisor')
          {
            $message->to($supervisor->email)->subject('Aviso Numero de Pausas');
          }
        }
      });
      return "Email enviado";
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->sendEmailPausas();
    }
}
