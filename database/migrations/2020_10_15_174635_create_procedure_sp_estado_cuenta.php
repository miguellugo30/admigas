<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcedureSpEstadoCuenta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::unprepared("
                        CREATE PROCEDURE `SP_estado_cuenta` (IN departamento_id INT)
                        BEGIN
                            (
                                SELECT
                                    'Pago' AS concepto,
                                    AP.referencia_completa,
                                    AP.referencia,
                                    AP.fecha_pago AS fecha,
                                    AP.importe,
                                    ADP.fecha_aplicacion
                                FROM
                                    admigas_departamentos_pagos ADP
                                INNER JOIN
                                    admigas_pagos AP
                                ON
                                    AP.id = ADP.admigas_pagos_id
                                WHERE
                                    ADP.admigas_departamentos_id = departamento_id
                            )
                            UNION
                            (
                                SELECT
                                    'Recibo' AS concepto,
                                    AR.clave_recibo,
                                    AR.referencia,
                                    AR.fecha_recibo AS fecha,
                                    AR.total_pagar,
                                    AR.fecha_limite_pago
                                FROM
                                    admigas_recibos AR
                                WHERE
                                    AR.admigas_departamentos_id = departamento_id
                                AND
                                    AR.activo = 1
                            )
                            ORDER BY fecha ASC;
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
        //Schema::dropIfExists('procedure_sp_estado_cuenta');
    }
}
