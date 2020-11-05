<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpSaldoDepto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::unprepared("
                        CREATE PROCEDURE `SP_saldo_recibo`(IN referencia VARCHAR(50))
                            BEGIN
                                SELECT
                                    sum(admigas_recibos.total_pagar) as total_recibos,
                                    (SELECT sum( admigas_pagos.importe ) FROM admigas_pagos WHERE admigas_pagos.referencia = referencia) AS total_pagos
                                FROM
                                    admigas_recibos
                                WHERE
                                    admigas_recibos.referencia = referencia
                                AND admigas_recibos.activo = 1;
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
        Schema::dropIfExists('sp_saldo_depto');
    }
}
