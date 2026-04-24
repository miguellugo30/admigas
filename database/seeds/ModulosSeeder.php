<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ModulosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::select('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('admigas_cat_modulos')->truncate();
        DB::select('SET FOREIGN_KEY_CHECKS = 1;');

        DB::table('admigas_cat_modulos')->insert([
            'nombre' => 'Edificios',
        ]);

        DB::table('admigas_cat_modulos')->insert([
            'nombre' => 'Credito y Cobranza',
        ]);

        DB::table('admigas_cat_modulos')->insert([
            'nombre' => 'Reportes',
        ]);

        DB::table('admigas_cat_modulos')->insert([
            'nombre' => 'Configuracion',
        ]);
    }
}
