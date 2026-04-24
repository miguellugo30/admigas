<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmigasLecturasTanquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admigas_lecturas_tanques', function (Blueprint $table) {
            $table->increments('id');
            $table->string('lectura', 100);
            $table->date('fecha');
            $table->string('tipo_lectura', 5);
            $table->tinyInteger('activo')->unsigned()->default(1);;
            $table->integer('admigas_tanques_id')->unsigned();
            $table->timestamps();
            $table->foreign('admigas_tanques_id')->references('id')->on('admigas_tanques')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('admigas_lecturas_tanques');
    }
}
