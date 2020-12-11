<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Controllers\GenerarPDFControler;

class CreatePdfEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $empresa_id;
    private $recibos;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $recibos, $empresa_id )
    {
        $this->empresa_id = $empresa_id;
        $this->recibos = $recibos;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ( $this->recibos as $recibo )
        {
            $e = new GenerarPDFControler;
            $e->generate(  $recibo->id_departamento, 2, $recibo, $this->empresa_id );
        }
    }
}
