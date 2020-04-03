<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmigasZonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admigas_zonas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 100);
            $table->string('descripcion', 100);
            $table->string('ruta_imagen', 100);
            $table->tinyInteger('activo')->unsigned()->default(1);;
            $table->integer('admigas_empresas_id')->unsigned();
            $table->timestamps();
            $table->foreign('admigas_empresas_id')->references('id')->on('admigas_empresas')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('admigas_zonas');
    }
}
