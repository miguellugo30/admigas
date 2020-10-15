<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmigasDepartamentosPagos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admigas_departamentos_pagos', function (Blueprint $table) {
            $table->id();
            $table->integer('admigas_departamentos_id')->unsigned();
            $table->bigInteger('admigas_pagos_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->date('fecha_aplicacion');
            $table->foreign('admigas_departamentos_id')->references('id')->on('admigas_departamentos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('admigas_pagos_id')->references('id')->on('admigas_pagos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
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
        Schema::dropIfExists('admigas_departamentos_pagos');
    }
}
