<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::select('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('roles')->truncate();
        DB::select('SET FOREIGN_KEY_CHECKS = 1;');

        DB::table('roles')->insert([
            'name' => 'Super Administrador',
            'guard_name' => 'web',
        ]);

        DB::table('roles')->insert([
            'name' => 'Administrador',
            'guard_name' => 'web',
        ]);

        DB::table('roles')->insert([
            'name' => 'Capturista',
            'guard_name' => 'web',
        ]);
    }
}
