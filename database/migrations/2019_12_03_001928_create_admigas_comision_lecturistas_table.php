<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmigasComisionLecturistasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admigas_comision_lecturista', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('numero_departamentos')->unsigned();
            $table->date('fecha');
            $table->tinyInteger('activo')->unsigned()->default(1);;
            $table->integer('admigas_lecturista_id')->unsigned();
            $table->integer('admigas_condominios_id')->unsigned();
            $table->timestamps();
            $table->foreign('admigas_lecturista_id')->references('id')->on('admigas_lecturistas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('admigas_condominios_id')->references('id')->on('admigas_condominios')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('admigas_comision_lecturista');
    }
}
