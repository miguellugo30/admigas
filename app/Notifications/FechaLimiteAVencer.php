<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FechaLimiteAVencer extends Notification
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
    public function __construct($depto,$edificio,$unidad, $depto_id)
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
    /*
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Tu fecha limite de pago esta pronto a vencerse.')
                    ->line('Te invitamos a realizar tu pago, para no generar cargos adicionales.')
                    ->action('Pagar Ahora', url('/'))
                    ->line('Gracias por tu preferencia!');
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
            'asunto' => 'Fecha Limite pronto a vencerse',
            'unidad' => $this->unidad,
            'edificio' => $this->edificio,
            'depto' => $this->depto,
            'depto_id' => $this->depto_id,
        ];
    }
}
