<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmigasLecturasMedidoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admigas_lecturas_medidores', function (Blueprint $table) {
            $table->increments('id');
            $table->float('lectura', 12,3);
            $table->date('fecha_desintalacion');
            $table->tinyInteger('activo')->unsigned()->default(1);
            $table->integer('admigas_departamentos_id')->unsigned();
            $table->integer('admigas_medidores_id')->unsigned();
            $table->timestamps();
            $table->foreign('admigas_departamentos_id')->references('id')->on('admigas_departamentos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('admigas_medidores_id')->references('id')->on('admigas_medidores')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('admigas_lecturas_medidores');
    }
}
