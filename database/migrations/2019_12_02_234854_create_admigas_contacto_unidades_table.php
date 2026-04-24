<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmigasContactoUnidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admigas_contacto_unidades', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 100);
            $table->string('apellidos', 100);
            $table->string('cargo', 50);
            $table->string('telefono', 10);
            $table->string('correo_electronico', 100);
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
        Schema::dropIfExists('admigas_contacto_unidades');
    }
}
