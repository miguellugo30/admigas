<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddColumnAdmigasRecibos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admigas_recibos', function (Blueprint $table) {
            $table->float('gasto_admin', 12,3)->after('importe');
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
            $table->dropColumn(['gasto_admin']);
        });
    }
}
