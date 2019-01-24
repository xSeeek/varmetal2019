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

class SendEmailRegistro implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $dataArray;
    public $tries = 5;
    public $timeout = 120;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
      $this->dataArray = array(
        'nombre' => $data->nameTrabajador,
        'email' => $data->email,
        'password' => $data->password,
        'tipo' => $data->type,
        'rut' => $data->rutTrabajador,
        'idUser' => $data->idUser,
      );
    }

    public function sendEmailRegistro()
    {
      Mail::send('emails.registrado', $this->dataArray, function($message){
        $user = User::orderBy('id', 'DESC')->first();
        $message->from('servidorvarmetal@gmail.com','Departamento de Informática Varmetal');
        $message->to($user->email)->subject('Cuenta Registrada con exito');
      });
      return 'Email enviado registrado';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->sendEmailRegistro();
    }
}
