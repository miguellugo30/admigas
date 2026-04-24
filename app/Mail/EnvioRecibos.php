<?php

namespace App\Mail;

use Exception;
use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EnvioRecibos extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    private $recibo;
    private $total_pagar;

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
        return $this->from('administradora@2gadmin.com')
                    ->subject("Recibo de Gas, 2G Administradora de Gas LP en Condominios")
                    ->view('send_recibo_depto')
                    ->attach(
                        storage_path()."/app/public/tmp/recibo_".$this->recibo->admigas_departamentos_id.".pdf",
                        [
                            'as' => 'recibo_gas.pdf',
                            'mime' => 'application/pdf',
                        ]
                    )
                    ->with([
                        'nombre' => $this->recibo->condomino,
                        'fecha_limite_pago' => date('d-m-Y', strtotime( $this->recibo->fecha_limite_pago ) ),
                        'importe' => $this->recibo->importe,
                        'adeudo_anterior' =>  $this->recibo->adeudo_anterior,
                        'cargos_del_mes' =>  $this->recibo->cargos_adicionales,
                        'gasto_admin' =>  $this->recibo->gasto_admin,
                        'total_pagar' => $this->total_pagar,
                        'referencia' => $this->recibo->referencia,
                        'clave_recibo' => $this->recibo->clave_recibo,
                    ]);
    }

    public function failed(Exception $exception)
    {
        // usually would send new notification to admin/user
        Log::info($exception);
    }
}
