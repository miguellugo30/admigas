<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpCondominiosEmpresa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::unprepared("
                        CREATE PROCEDURE `SP_condominios_empresa`(IN empresa_id INT)
                            BEGIN
                                SELECT
                                    AC.id,
                                    AC.nombre
                                FROM
                                    admigas_zonas AZ
                                INNER JOIN admigas_unidades AU
                                ON
                                    AU.admigas_zonas_id = AZ.id
                                INNER JOIN admigas_condominios AC
                                ON
                                    AC.admigas_unidades_id = AU.id
                                WHERE
                                    AZ.admigas_empresas_id = empresa_id
                                AND AZ.activo = 1
                                AND AU.activo = 1
                                AND AC.activo = 1;
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
        Schema::dropIfExists('sp_condominios_empresa');
    }
}
