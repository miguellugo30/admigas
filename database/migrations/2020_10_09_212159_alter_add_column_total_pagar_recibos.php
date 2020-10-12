<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddColumnTotalPagarRecibos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admigas_recibos', function (Blueprint $table) {
            $table->float('total_pagar', 12, 3)->after('cargos_adicionales');
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
            $table->dropColumn(['total_pagar']);
        });
    }
}
