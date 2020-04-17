<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::select('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('admigas_empresas')->truncate();
        DB::select('SET FOREIGN_KEY_CHECKS = 1;');

        DB::table('admigas_empresas')->insert([
                'razon_social' => 'Miguel Chavez Lugo',
                'rfc' => 'CALM891303P2',
                'calle' => 'Independencia',
                'numero' => '22',
                'colonia' => 'San Francisco Tlaltenco',
                'municipio' => 'Tlahuac',
                'cp' => '13400',
            ]);

    }
}
