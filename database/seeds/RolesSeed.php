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
        DB::table('roles')->truncate();

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
