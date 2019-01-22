<?php

namespace Asistencia\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MyResetPassword extends Notification
{


    private $token;
    private $user;

    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */


     public function __construct($token, $user)
     {
       $this->token=$token;
       $this->user=$user;
     }
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
      return (new MailMessage)
        ->from(env('MAIL_USERNAME'), 'Gestion Asistencia-Varmetal')
        ->subject('Cambio de contraseña')
        ->markdown('mail.cuenta.cambioContraseña', ['user'=>$this->user, 'token'=>$this->token]);

    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
