<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::select('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('users')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::select('SET FOREIGN_KEY_CHECKS = 1;');

        DB::table('users')->insert([
                'name' => 'Admin',
                'email' => 'ingmchlugo@gmail.com',
                'email_verified_at' => NULL,
                'password' => Hash::make('admin'),
                'admigas_empresas_id' => 1,
                'remember_token' => '',
            ]);

            DB::table('model_has_roles')->insert([
                'role_id' => 1,
                'model_type' => 'App\User',
                'model_id' => 1
            ]);

            DB::table('model_has_permissions')->insert([
                'permission_id' => 1,
                'model_type' => 'App\User',
                'model_id' => 1
            ]);

            DB::table('model_has_permissions')->insert([
                'permission_id' => 2,
                'model_type' => 'App\User',
                'model_id' => 1
            ]);

            DB::table('model_has_permissions')->insert([
                'permission_id' => 3,
                'model_type' => 'App\User',
                'model_id' => 1
            ]);

            DB::table('model_has_permissions')->insert([
                'permission_id' => 4,
                'model_type' => 'App\User',
                'model_id' => 1
            ]);

    }
}
