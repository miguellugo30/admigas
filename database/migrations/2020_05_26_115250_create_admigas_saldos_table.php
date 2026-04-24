<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmigasSaldosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admigas_saldos', function (Blueprint $table) {
            $table->id();
            $table->string('referencia', 45);
            $table->float('total_recibos', 12,3);
            $table->float('total_pagos', 12,3);
            $table->float('saldo', 12,3);
            $table->integer('admigas_departamentos_id')->unsigned();
            $table->timestamps();
            $table->foreign('admigas_departamentos_id')->references('id')->on('admigas_departamentos')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('admigas_saldos');
    }
}
