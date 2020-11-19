<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpReporteSaldos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::unprepared("
                        CREATE DEFINER=`administradora_condominios`@`localhost` PROCEDURE `SP_reporte_saldos`()
                        BEGIN
                            SELECT
                                AU.nombre AS unidad,
                                AC.nombre as edificio,
                                AD.numero_departamento,
                                AD.numero_referencia,
                                (SELECT sum( admigas_recibos.gasto_admin ) FROM admigas_recibos WHERE admigas_recibos.referencia = AD.numero_referencia AND admigas_recibos.activo = 1) AS total_gasto_admin,
                                (SELECT sum( admigas_recibos.importe ) FROM admigas_recibos WHERE admigas_recibos.referencia = AD.numero_referencia AND admigas_recibos.activo = 1) AS total_importe,
                                (SELECT sum( admigas_recibos.cargos_adicionales ) FROM admigas_recibos WHERE admigas_recibos.referencia = AD.numero_referencia AND admigas_recibos.activo = 1) AS total_cargos,
                                (SELECT sum( admigas_recibos.total_pagar ) FROM admigas_recibos WHERE admigas_recibos.referencia = AD.numero_referencia AND admigas_recibos.activo = 1) AS total_recibos,
                                (SELECT sum( admigas_pagos.importe ) FROM admigas_pagos WHERE admigas_pagos.referencia = AD.numero_referencia) AS total_pagos
                            FROM
                                admigas_unidades AU
                            INNER JOIN
                                admigas_condominios AC
                            ON
                                AC.admigas_unidades_id = AU.id
                            INNER JOIN
                                admigas_departamentos AD
                            ON
                                AD.admigas_condominios_id = AC.id;
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
        Schema::dropIfExists('sp_reporte_saldos');
    }
}
