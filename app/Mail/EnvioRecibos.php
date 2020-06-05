<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnvioRecibos extends Mailable
{
    use Queueable, SerializesModels;
    private $recibo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $recibo )
    {
        $this->recibo = $recibo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        /*
        setlocale(LC_TIME, 'Spanish');
        Carbon::setLocale(config('app.locale'));
        $fechaMes = Carbon::parse( $this->recibo->fecha_recibo )->formatLocalized('%B');
        */

        return $this->from('administradora@administradora.com')
                    ->subject("Recibo de Gas, ")
                    ->view('maileclipse::templates.notificacionRecibos')
                    ->with([
                        'nombre' => $this->recibo->condomino,
                        'fecha_limite_pago' => date('d-m-Y', strtotime( $this->recibo->fecha_limite_pago ) ),
                        'importe' => number_format( $this->recibo->importe, 2),
                        'adeudo_anterior' => number_format( $this->recibo->adeudo_anterior, 2),
                        'cargos_del_mes' => number_format( $this->recibo->cargos_adicionales, 2),
                        'total_pagar' => number_format( ( $this->recibo->cargos_adicionales + $this->recibo->adeudo_anterior + $this->recibo->importe ), 2),
                        'referencia' => $this->recibo->referencia,
                    ]);
    }
}
