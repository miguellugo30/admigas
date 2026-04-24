<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddColumnApellidoMaternoDepartamentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admigas_contacto_departamentos', function (Blueprint $table) {
            $table->string('apellido_materno', 50)->after('apellidos');
            $table->renameColumn('apellidos', 'apellido_paterno');
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
            $table->dropColumn(['apellido_materno']);
            $table->renameColumn('apellido_paterno', 'apellidos');
        });
    }
}
