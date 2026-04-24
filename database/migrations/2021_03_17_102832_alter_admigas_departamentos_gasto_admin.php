<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAdmigasDepartamentosGastoAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admigas_departamentos', function (Blueprint $table) {
            $table->float('gasto_admin', 8,2)->after('descuento')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admigas_departamentos', function (Blueprint $table) {
            $table->dropColumn(['gasto_admin']);
        });
    }
}
