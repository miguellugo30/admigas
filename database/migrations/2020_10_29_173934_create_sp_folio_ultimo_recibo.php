<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpFolioUltimoRecibo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::unprepared("
                        CREATE PROCEDURE `SP_folio_ultimo_recibo`()
                            BEGIN
                                SELECT
                                    admigas_recibos.clave_recibo
                                FROM
                                    admigas_recibos
                                WHERE
                                    admigas_recibos.activo = 1
                                    ORDER BY admigas_recibos.id DESC
                                    LIMIT 1;
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
        Schema::dropIfExists('sp_folio_ultimo_recibo');
    }
}
