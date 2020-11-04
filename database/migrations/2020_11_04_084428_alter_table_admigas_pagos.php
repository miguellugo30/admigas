<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableAdmigasPagos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admigas_pagos', function (Blueprint $table) {
            $table->string('autorizacion', 100)->after('fecha_pago');
            $table->string('medio_pago', 100)->after('autorizacion');
            $table->string('s_transm', 100)->after('medio_pago');
            $table->string('tarjeta_habiente', 100)->after('s_transm');
            $table->string('cve_tipo_pago', 100)->after('tarjeta_habiente');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admigas_contacto_departamentos', function (Blueprint $table) {
            $table->dropColumn(['autorizacion']);
            $table->dropColumn(['medio_pago']);
            $table->dropColumn(['s_transm']);
            $table->dropColumn(['tarjeta_habiente']);
            $table->dropColumn(['cve_tipo_pago']);
        });
    }
}
