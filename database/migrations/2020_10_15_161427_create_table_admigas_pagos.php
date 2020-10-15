<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAdmigasPagos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admigas_pagos', function (Blueprint $table) {
            $table->id();
            $table->string('referencia', 50);
            $table->string('referencia_completa', 500);
            $table->float('importe', 12, 2);
            $table->date('fecha_pago');
            $table->tinyInteger('estatus')->unsigned()->default(1);// 1 conciliado 2 no conciliado
            $table->tinyInteger('modo')->unsigned()->default(1);//1 automatico 2 manual
            $table->integer('admigas_empresas_id')->unsigned();
            $table->foreign('admigas_empresas_id')->references('id')->on('admigas_empresas')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
            $table->index('referencia');
            $table->index('fecha_pago');
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admigas_pagos');
    }
}
