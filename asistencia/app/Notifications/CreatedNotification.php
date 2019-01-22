<?php

namespace Asistencia\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CreatedNotification extends Notification
{
    private $user;
    private $password;

    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */


     public function __construct($user, $password)
     {
       $this->user = $user;
       $this->password = $password;
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
        ->subject('Registro')
        ->markdown('mail.cuenta.registro', ['user'=>$this->user, 'contraseña'=>$this->password]);

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
