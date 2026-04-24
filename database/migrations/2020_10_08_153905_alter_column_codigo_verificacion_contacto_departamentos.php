<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumnCodigoVerificacionContactoDepartamentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admigas_contacto_departamentos', function (Blueprint $table) {
            $table->unsignedInteger('codigo_verificacion')->after('correo_electronico');
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
            $table->dropColumn('codigo_verificacion');
        });
    }
}
