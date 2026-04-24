<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpReporteCargosAdicionales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::unprepared("
                            CREATE PROCEDURE `SP_reporte_cargos_adicionales`( IN fecha_inicial DATE, IN fecha_fin DATE )
                            BEGIN
                                select
                                    au.nombre as unidad,
                                    ac.nombre as edificio,
                                    ad.numero_departamento ,
                                    ad.numero_referencia,
                                    as2.nombre,
                                    as2.costo ,
                                    aca.periodo,
                                    aca.plazo
                                from
                                admigas_cargos_adicionales aca
                                inner join
                                    admigas_servicios as2
                                on
                                    as2.id  = aca.admigas_servicios_id
                                inner join
                                    admigas_departamentos ad
                                on
                                    ad.id = aca.admigas_departamentos_id
                                inner join
                                    admigas_condominios ac
                                on
                                    ac.id = ad.admigas_condominios_id
                                inner join
                                    admigas_unidades au
                                on
                                    au.id = ac.admigas_unidades_id
                                where
                                    aca.created_at between fecha_inicial and fecha_fin;
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
        Schema::dropIfExists('SP_reporte_cargos_adicionales');
    }
}
