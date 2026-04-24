<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumnAdmigasCuentasBancarias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admigas_cuentas_bancarias', function (Blueprint $table) {
            $table->string('convenio_cie', 50)->after('clabe');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admigas_cuentas_bancarias', function (Blueprint $table) {
            $table->dropColumn(['convenio_cie']);
        });
    }
}
