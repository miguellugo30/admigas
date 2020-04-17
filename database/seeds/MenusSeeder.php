<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class MenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::select('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('admigas_menus')->truncate();
        DB::select('SET FOREIGN_KEY_CHECKS = 1;');

        DB::table('admigas_menus')->insert([
            'nombre' => 'Usuarios',
            'url' => '/usuarios',
            'icono' => 'fas fa-users',
            'permiso' => 'view usuarios',
            'admigas_cat_modulos_id' => '4',
        ]);

        DB::table('admigas_menus')->insert([
            'nombre' => 'Precio Gas',
            'url' => '/precio-gas',
            'icono' => 'fas fa-dollar-sign',
            'permiso' => 'view precio gas',
            'admigas_cat_modulos_id' => '4',
        ]);

        DB::table('admigas_menus')->insert([
            'nombre' => 'Servicios',
            'url' => '/servicios',
            'icono' => 'fas fa-concierge-bell',
            'permiso' => 'view servicios',
            'admigas_cat_modulos_id' => '4',
        ]);

        DB::table('admigas_menus')->insert([
            'nombre' => 'Mensajes',
            'url' => '/mensajes',
            'icono' => 'fas fa-comment-dots',
            'permiso' => 'view mensajes',
            'admigas_cat_modulos_id' => '4',
        ]);

        DB::table('admigas_menus')->insert([
            'nombre' => 'Menus',
            'url' => '/menus',
            'icono' => 'fas fa-align-justify',
            'permiso' => 'view menus',
            'admigas_cat_modulos_id' => '4',
        ]);

        DB::table('admigas_menus')->insert([
            'nombre' => 'Empresas',
            'url' => '/empresas',
            'icono' => 'fas fa-industry',
            'permiso' => 'view empresas',
            'admigas_cat_modulos_id' => '4',
        ]);

    }
}
