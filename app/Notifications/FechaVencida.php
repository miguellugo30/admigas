<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FechaVencida extends Notification
{
    use Queueable;

    protected $depto;
    protected $edificio;
    protected $unidad;
    protected $depto_id;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($depto,$edificio,$unidad,$depto_id)
    {
        $this->depto = $depto;
        $this->edificio = $edificio;
        $this->unidad = $unidad;
        $this->depto_id = $depto_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
            'asunto' => 'Fecha de pago Vencida',
            'unidad' => $this->unidad,
            'edificio' => $this->edificio,
            'depto' => $this->depto,
            'depto_id' => $this->depto_id
        ];
    }
}
