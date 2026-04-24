<?php

namespace App\Mail;

use Exception;
use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegisterDepto extends Mailable implements ShouldQueue
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
        return $this->from('administradora@2gadmin.com')
        ->subject("Registro 2G Admin")
        ->view('register_depto')
        ->with([
            'nombre' => $this->nombre,
            'codigo' => $this->codigo
        ]);
    }

    public function failed(Exception $exception)
    {
        // usually would send new notification to admin/user
        Log::info($exception);
    }
}
