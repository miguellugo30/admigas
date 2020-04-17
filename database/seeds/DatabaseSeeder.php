<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesSeed::class);
        $this->call(PermisosSeeder::class);
        $this->call(ModulosSeeder::class);
        $this->call(MenusSeeder::class);
        $this->call(EmpresaSeeder::class);
        $this->call(UserSeeder::class);
    }
}
