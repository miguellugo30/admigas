<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmigasMenus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admigas_menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 100);
            $table->string('url', 100);
            $table->string('icono', 100);
            $table->tinyInteger('orden')->unsigned()->default(1);
            $table->tinyInteger('activo')->unsigned()->default(1);
            $table->timestamps();
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admigas_menus');
    }
}
