<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFkCatModulosMenus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admigas_menus', function (Blueprint $table) {
            $table->renameColumn('modulo', 'admigas_cat_modulos_id');

            $table->foreign('admigas_cat_modulos_id')->references('id')->on('admigas_cat_modulos')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admigas_menus', function (Blueprint $table) {
            $table->dropForeign('admigas_cat_modulos_id');
        });
    }
}
