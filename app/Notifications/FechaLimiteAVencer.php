<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FechaLimiteAVencer extends Notification
{
    use Queueable;

    protected $deptos;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($deptos)
    {
        $this->deptos = $deptos;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
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
                    ->line('Tu fecha limite de pago esta pronto a vencerse.')
                    ->line('Te invitamos a realizar tu pago, para no generar cargos adicionales.')
                    ->action('Pagar Ahora', url('/'))
                    ->line('Gracias por tu preferencia!');
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
            'deptos' => $this->deptos
        ];
    }
}
