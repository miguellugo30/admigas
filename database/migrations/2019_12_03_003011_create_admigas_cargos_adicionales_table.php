<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmigasCargosAdicionalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admigas_cargos_adicionales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('plazo')->unsigned();
            $table->integer('periodo')->unsigned()->default(0);
            $table->tinyInteger('activo')->unsigned()->default(1);
            $table->integer('admigas_servicios_id')->unsigned();
            $table->integer('admigas_departamentos_id')->unsigned();
            $table->timestamps();
            $table->foreign('admigas_servicios_id')->references('id')->on('admigas_servicios')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('admigas_cargos_adicionales');
    }
}
