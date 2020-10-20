<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use ReeceM\Mocker\Mocked;


class EnvioRecibos extends Mailable
{
    use Queueable, SerializesModels;
    private $recibo;
    public $total_pagar;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $recibo, $total_pagar )
    {
        $this->recibo = $recibo;
        $this->total_pagar = $total_pagar;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->from('administradora@administradora.com')
                    ->subject("Recibo de Gas, ")
                    ->view('show_mail')/*
                    ->attach( storage_path()."\app\public/recibo_".$this->recibo->admigas_departamentos_id.".pdf", [
                        'as' => 'recibo_gas.pdf',
                        'mime' => 'application/pdf',
                    ] )*/
                    ->with([
                        'nombre' => $this->recibo->condomino,
                        'fecha_limite_pago' => date('d-m-Y', strtotime( $this->recibo->fecha_limite_pago ) ),
                        'importe' => $this->recibo->importe,
                        'adeudo_anterior' =>  $this->recibo->adeudo_anterior,
                        'cargos_del_mes' =>  $this->recibo->cargos_adicionales,
                        'gasto_admin' =>  $this->recibo->gasto_admin,
                        'total_pagar' => $this->total_pagar,
                        'referencia' => $this->recibo->referencia,
                    ]);
    }
}
