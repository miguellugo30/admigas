<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NumeroVerificacion extends Mailable
{
    use Queueable, SerializesModels;

    private $numero_verificacion;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($numero_verificacion)
    {
        $this->numero_verificacion = $numero_verificacion;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('administradora@2gadmin.com')
        ->subject("Número de Verificación")
        ->view('numero_verificacion')
        ->with([
            'numero_verificacion' => $this->numero_verificacion
        ]);
    }
}
