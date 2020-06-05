<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmigasRecibosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admigas_recibos', function (Blueprint $table) {
            $table->id();
            $table->string('clave_recibo', 45);
            $table->string('unidad', 45);
            $table->string('condominio', 45);
            $table->string('numero_departamento', 45);
            $table->string('condomino', 45);
            $table->string('calle', 45);
            $table->string('numero_exterior', 45);
            $table->string('numero_interior', 45);
            $table->string('colonia', 45);
            $table->string('delegacion', 45);
            $table->string('cp', 45);
            $table->string('telefono', 45);
            $table->date('fecha_recibo');
            $table->date('fecha_lectura_anterior');
            $table->date('fecha_lectura_actual');
            $table->date('fecha_limite_pago');
            $table->float('precio_litro', 8,3);
            $table->float('importe', 12,3);
            $table->float('adeudo_anterior', 12,3);
            $table->float('cargos_adicionales', 12,3);
            $table->string('referencia', 45);
            $table->string('motivo_cancelacion', 45);
            $table->tinyInteger('activo')->unsigned()->default(1);
            $table->integer('admigas_departamentos_id')->unsigned();
            $table->integer('admigas_condominios_id')->unsigned();
            $table->timestamps();
            $table->foreign('admigas_departamentos_id')->references('id')->on('admigas_departamentos')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('admigas_recibos');
    }
}
