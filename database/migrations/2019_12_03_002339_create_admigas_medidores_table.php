<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmigasMedidoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admigas_medidores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('marca', 50);
            $table->string('numero_serie', 50);
            $table->float('lectura', 12,3);
            $table->tinyInteger('tipo')->unsigned()->default(1);;
            $table->tinyInteger('activo')->unsigned()->default(1);;
            $table->integer('admigas_departamentos_id')->unsigned();
            $table->timestamps();
            $table->foreign('admigas_departamentos_id')->references('id')->on('admigas_departamentos')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('admigas_medidores');
    }
}
