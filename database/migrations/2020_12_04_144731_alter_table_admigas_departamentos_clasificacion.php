<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableAdmigasDepartamentosClasificacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admigas_contacto_departamentos', function (Blueprint $table) {
            $table->string('clasficacion', 100)->after('codigo_verificacion');
            $table->string('medio', 100)->after('clasficacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admigas_contacto_departamentos', function (Blueprint $table) {
            $table->dropColumn(['clasficacion']);
            $table->dropColumn(['medio']);
        });
    }
}
