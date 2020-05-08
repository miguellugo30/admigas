<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmigasDepartamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admigas_departamentos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('numero_departamento', 50);
            $table->string('numero_referencia', 50)->unique();
            $table->float('factor', 8,2)->nullable();
            $table->float('descuento', 8,2)->nullable();
            $table->tinyInteger('suministro')->unsigned()->default(1);
            $table->tinyInteger('activo')->unsigned()->default(1);
            $table->integer('admigas_condominios_id')->unsigned();
            $table->timestamps();
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
        Schema::dropIfExists('admigas_departamentos');
    }
}
