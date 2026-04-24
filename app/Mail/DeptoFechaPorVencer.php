<?php

namespace App\Mail;

use Exception;
use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeptoFechaPorVencer extends Mailable  implements ShouldQueue
{
    use Queueable, SerializesModels;
    private $nombre;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $nombre )
    {
        $this->nombre = $nombre;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('administradora@2gadmin.com')
        ->subject("Tu fecha limite estar por vencerse")
        ->view('depto_fecha')
        ->with([
            'nombre' => $this->nombre
        ]);
    }

    public function failed(Exception $exception)
    {
        // usually would send new notification to admin/user
        Log::info($exception);
    }
}
