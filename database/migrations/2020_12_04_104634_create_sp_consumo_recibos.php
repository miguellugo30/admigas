<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpConsumoRecibos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	\DB::unprepared("
                    CREATE PROCEDURE `SP_consumo_recibos`( IN departamento_id INT )
                    BEGIN
                    SELECT
                    AR.id,
                    AR.fecha_recibo,
                    ( AR.lectura_actual - AR.lectura_anterior ) * AC.factor AS litros,
                    AR.precio_litro,
                    (AR.total_pagar - AR.adeudo_anterior) AS total_pagar
                    FROM
                    admigas_recibos AR
                    INNER JOIN admigas_condominios AC
                    ON
                    AR.admigas_condominios_id = AC.id
                    WHERE
                    AR.admigas_departamentos_id = departamento_id
                    AND
                    AR.activo = 1
                    ORDER BY AR.fecha_recibo ASC LIMIT 6;
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
        Schema::dropIfExists('sp_consumo_recibos');
    }
}
