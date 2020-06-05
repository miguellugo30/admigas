<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAdmigasRecibosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admigas_recibos', function (Blueprint $table) {
            $table->float('lectura_anterior', 12,3)->after('fecha_lectura_anterior');
            $table->float('lectura_actual', 12,3)->after('fecha_lectura_actual');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admigas_recibos', function (Blueprint $table) {
            $table->dropColumn('lectura_anterior');
            $table->dropColumn('lectura_anterior');
        });
    }
}
