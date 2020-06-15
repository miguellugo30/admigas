<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use DB;

class CreateTriggerActualizarSaldosRecibos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS `admigas`.`admigas_recibos_BEFORE_INSERT`;

                        DELIMITER $$
                        USE `admigas`$$
                        CREATE DEFINER = CURRENT_USER TRIGGER `admigas`.`admigas_recibos_BEFORE_INSERT` BEFORE INSERT ON `admigas_recibos` FOR EACH ROW
                        BEGIN
                            UPDATE 
                                admigas_saldos
                                SET
                                admigas_saldos.total_recibos = admigas_saldos.total_recibos + NEW.importe,
                                admigas_saldos.saldo = admigas_saldos.total_recibos - admigas_saldos.total_pagos
                                WHERE
                                admigas_saldos.admigas_departamentos_id = NEW.admigas_departamentos_id; 
                        END$$
                        DELIMITER ;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS `admigas`.`admigas_recibos_BEFORE_INSERT`;');
    }
}
