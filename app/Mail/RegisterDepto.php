<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterDepto extends Mailable
{
    use Queueable, SerializesModels;
    private $nombre;
    private $codigo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $nombre, $codigo )
    {
        $this->nombre = $nombre;
        $this->codigo = $codigo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('administradora@administradora.com')
        ->subject("Registro 2G Admin")
        ->view('register_depto')
        ->with([
            'nombre' => $this->nombre,
            'codigo' => $this->codigo
        ]);
    }
}
