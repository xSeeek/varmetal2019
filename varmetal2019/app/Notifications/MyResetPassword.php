<?php

namespace Varmetal\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MyResetPassword extends Notification
{
    use Queueable;
    public $token;

    public function __construct($data)
    {
      $this->token=$data;
    }

    public function toMail($notifiable)
    {
      return (new MailMessage)
            ->subject('Cambio de Contraseña')
            ->greeting('Hola', $this->token)
            ->line('Estás recibiendo este email, porque nosotros revibimos una solicitud de cambio de contraseña para tu cuenta.')
            //->action('Reestablecer contraseña', url(config('app.url').route('password.reset',$this->token,false)))
            ->action('Cambio de Contraseña', route('password.reset', $this->token))
            ->line('Si tú no pediste la solicitud, ignora este correo.')
            ->salutation('Saludos '. 'Varmetal');
    }

    /**
     * Create a new notification instance.
     *
     * @return void
     */

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
    /*public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }
    */
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
