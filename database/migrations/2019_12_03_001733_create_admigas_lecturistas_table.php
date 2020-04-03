<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmigasLecturistasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admigas_lecturistas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 100);
            $table->string('apellidos', 100);
            $table->string('telefono', 10);
            $table->string('celular', 50);
            $table->string('correo_electronico', 100);
            $table->tinyInteger('activo')->unsigned()->default(1);;
            $table->integer('admigas_comision_id')->unsigned();
            $table->timestamps();
            $table->foreign('admigas_comision_id')->references('id')->on('admigas_comision')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('admigas_lecturistas');
    }
}
