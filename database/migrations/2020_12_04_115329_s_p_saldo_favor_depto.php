<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SPSaldoFavorDepto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	        \DB::unprepared("
                        CREATE PROCEDURE `SP_saldo_favor_depto`(IN referencia VARCHAR(50), IN fecha DATE)
                            BEGIN
                                SELECT
                                    sum(admigas_recibos.total_pagar) as total_recibos,
                                    (SELECT sum( admigas_pagos.importe ) FROM admigas_pagos WHERE admigas_pagos.referencia = referencia AND admigas_pagos.fecha_pago < fecha) AS total_pagos
                                FROM
                                    admigas_recibos
                                WHERE
                                    admigas_recibos.referencia = referencia
                                AND admigas_recibos.activo = 1
				AND admigas_recibos.fecha_recibo < fecha;
                            END
                        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
