<?php

use Illuminate\Database\Seeder;

class PermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::select('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('permissions')->truncate();
        DB::select('SET FOREIGN_KEY_CHECKS = 1;');

        DB::table('permissions')->insert([
            'name' => 'view usuarios',
            'guard_name' => 'web',
        ]);

        DB::table('permissions')->insert([
            'name' => 'create usuarios',
            'guard_name' => 'web',
        ]);

        DB::table('permissions')->insert([
            'name' => 'edit usuarios',
            'guard_name' => 'web',
        ]);

        DB::table('permissions')->insert([
            'name' => 'delete usuarios',
            'guard_name' => 'web',
        ]);

        DB::table('permissions')->insert([
            'name' => 'view precio gas',
            'guard_name' => 'web',
        ]);

        DB::table('permissions')->insert([
            'name' => 'create precio gas',
            'guard_name' => 'web',
        ]);

        DB::table('permissions')->insert([
            'name' => 'edit precio gas',
            'guard_name' => 'web',
        ]);

        DB::table('permissions')->insert([
            'name' => 'delete precio gas',
            'guard_name' => 'web',
        ]);

        DB::table('permissions')->insert([
            'name' => 'view servicios',
            'guard_name' => 'web',
        ]);

        DB::table('permissions')->insert([
            'name' => 'create servicios',
            'guard_name' => 'web',
        ]);

        DB::table('permissions')->insert([
            'name' => 'edit servicios',
            'guard_name' => 'web',
        ]);

        DB::table('permissions')->insert([
            'name' => 'delete servicios',
            'guard_name' => 'web',
        ]);

        DB::table('permissions')->insert([
            'name' => 'view mensajes',
            'guard_name' => 'web',
        ]);

        DB::table('permissions')->insert([
            'name' => 'create mensajes',
            'guard_name' => 'web',
        ]);

        DB::table('permissions')->insert([
            'name' => 'edit mensajes',
            'guard_name' => 'web',
        ]);

        DB::table('permissions')->insert([
            'name' => 'delete mensajes',
            'guard_name' => 'web',
        ]);

        DB::table('permissions')->insert([
            'name' => 'view menus',
            'guard_name' => 'web',
        ]);

        DB::table('permissions')->insert([
            'name' => 'create menus',
            'guard_name' => 'web',
        ]);

        DB::table('permissions')->insert([
            'name' => 'edit menus',
            'guard_name' => 'web',
        ]);

        DB::table('permissions')->insert([
            'name' => 'delete menus',
            'guard_name' => 'web',
        ]);

        DB::table('permissions')->insert([
            'name' => 'view empresas',
            'guard_name' => 'web',
        ]);

        DB::table('permissions')->insert([
            'name' => 'create empresas',
            'guard_name' => 'web',
        ]);

        DB::table('permissions')->insert([
            'name' => 'edit empresas',
            'guard_name' => 'web',
        ]);

        DB::table('permissions')->insert([
            'name' => 'delete empresas',
            'guard_name' => 'web',
        ]);
        
        DB::table('permissions')->insert([
            'name' => 'view lecturistas',
            'guard_name' => 'web',
        ]);

        DB::table('permissions')->insert([
            'name' => 'create lecturistas',
            'guard_name' => 'web',
        ]);

        DB::table('permissions')->insert([
            'name' => 'edit lecturistas',
            'guard_name' => 'web',
        ]);

        DB::table('permissions')->insert([
            'name' => 'delete lecturistas',
            'guard_name' => 'web',
        ]);
    }
}
