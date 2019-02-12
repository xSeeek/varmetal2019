<?php

namespace Varmetal\Jobs;

use Mail;
use Auth;
use Varmetal\User;
use Varmetal\Producto;
use Varmetal\Trabajador;
use Varmetal\Pausa;
use Varmetal\Jobs;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class EmailFinPausa implements ShouldQueue
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
          'nombreTrabajador' => $response[0],
          'rutTrabajador' => $response[1],
          'emailTrabajador' => $response[2],
          'codigo' => $response[3],
          'producto' => $response[4],
          'idTrabajador' => $response[5],
          'descripcion' => $response[6],
          'motivo' => $response[7],
          'idSupervisor' => $response[8],
          'nombreSupervisor' => $response[9],
          'emailSupervisor' => $response[10],
      );
    }

    public function emailFinPausa()
    {
      Mail::send('emails.finPausa', $this->data, function($message){
        $trabajador = Trabajador::find($this->data['idTrabajador']);
        $supervisor = Trabajador::find($this->data['idSupervisor']);
        $message->from($supervisor->user->email, $supervisor->nombre);
        $message->to($trabajador->user->email)->subject('Aviso Pausa Finalizada');
      });
      return "Email Finalizada";
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->emailFinPausa();
    }
}
