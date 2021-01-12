<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddColumnPrecioGasUnidades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admigas_unidades', function (Blueprint $table) {
            $table->float('precio_gas', 8,2)->after('fecha_alta')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admigas_unidades', function (Blueprint $table) {
            $table->dropColumn(['precio_gas']);
        });
    }
}
