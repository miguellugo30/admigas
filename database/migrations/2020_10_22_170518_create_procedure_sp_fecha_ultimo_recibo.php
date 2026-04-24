<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcedureSpFechaUltimoRecibo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::unprepared("
                        CREATE PROCEDURE `SP_fecha_ultimo_recibo`(IN condominio_id INT)
                            BEGIN
                            SELECT
                                admigas_recibos.fecha_recibo
                            FROM
                                admigas_recibos
                            WHERE
                                admigas_recibos.admigas_condominios_id = condominio_id
                            AND
                                admigas_recibos.activo = 1
                            GROUP BY admigas_recibos.fecha_recibo
                            ORDER BY admigas_recibos.fecha_recibo
                            DESC LIMIT 1;
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
        //Schema::dropIfExists('procedure_sp_fecha_ultimo_recibo');
    }
}
