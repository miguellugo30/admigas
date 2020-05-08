<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmigasTanquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admigas_tanques', function (Blueprint $table) {
            $table->increments('id');
            $table->string('num_serie', 100);
            $table->string('marca', 100);
            $table->string('capacidad', 100);
            $table->date('fecha_instalacion')->nullable();
            $table->date('fecha_desintalacion')->nullable();
            $table->date('fecha_fabricacion')->nullable();
            $table->string('estado_al_recibir');
            $table->string('inventario');
            $table->tinyInteger('activo')->unsigned()->default(1);;
            $table->integer('admigas_unidades_id')->unsigned();
            $table->timestamps();
            $table->foreign('admigas_unidades_id')->references('id')->on('admigas_unidades')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('admigas_tanques');
    }
}
