<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAdmigasMensajesRecibos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admigas_mensajes_recibos', function (Blueprint $table) {
            $table->integer('admigas_mensajes_id')->unsigned();
            $table->bigInteger('admigas_recibos_id')->unsigned();
            $table->timestamps();
            $table->foreign('admigas_mensajes_id')->references('id')->on('admigas_mensajes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('admigas_recibos_id')->references('id')->on('admigas_recibos')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('table_admigas_mensajes_recibos');
    }
}
