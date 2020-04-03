<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmigasEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admigas_empresas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('razon_social', 100);
            $table->string('rfc', 50);
            $table->string('calle', 100);
            $table->string('numero', 100);
            $table->string('colonia', 100);
            $table->string('municipio', 100);
            $table->string('cp', 10);
            $table->tinyInteger('activo')->unsigned()->default(1);
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
        Schema::dropIfExists('admigas_empresas');
    }
}
