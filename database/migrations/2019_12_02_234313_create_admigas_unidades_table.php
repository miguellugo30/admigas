<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmigasUnidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admigas_unidades', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 100);
            $table->string('calle', 100);
            $table->string('numero', 10);
            $table->string('colonia', 100);
            $table->string('delegacion_municipio', 100);
            $table->string('cp', 10);
            $table->string('estado', 100);
            $table->string('entre_calle', 100);
            $table->date('fecha_alta', 100);
            $table->tinyInteger('activo')->unsigned()->default(1);;
            $table->integer('admigas_zonas_id')->unsigned();
            $table->timestamps();
            $table->foreign('admigas_zonas_id')->references('id')->on('admigas_zonas')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('admigas_unidades');
    }
}
