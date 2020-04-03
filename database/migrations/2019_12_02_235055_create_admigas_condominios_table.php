<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmigasCondominiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admigas_condominios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 100);
            $table->float('descuento', 8,2);
            $table->float('factor', 8,2);
            $table->float('gasto_admin', 8,2);
            $table->date('fecha_lectura', 100);
            $table->tinyInteger('tipo')->unsigned();
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
        Schema::dropIfExists('admigas_condominios');
    }
}
