<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

class DeptosEjemploSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run( Faker $faker )
    {

        for ($i=0; $i < 10; $i++) {

            /**
             * Creamos el nuevo departamento
             */
            $referencia = $faker->creditCardNumber;
            $depto = DB::table('admigas_departamentos')->insertGetId([
                                                                        'numero_departamento' => $faker->randomNumber(3,false),
                                                                        'numero_referencia' =>  $faker->creditCardNumber,
                                                                        'admigas_condominios_id' => 1
                                                                    ]);
            /**
            * Creamos el contacto del departamento
            */
            DB::table('admigas_contacto_departamentos')->insert([
                                                                    'nombre' => $faker->firstName,
                                                                    'apellidos' =>  $faker->lastName,
                                                                    'telefono' => $faker->randomNumber(5,false),
                                                                    'celular' => $faker->randomNumber(5,false),
                                                                    'correo_electronico' => $faker->unique()->email,
                                                                    'admigas_departamentos_id' => $depto
                                                                ]);
            /**
             * Creamos el saldo inicial
             */
            DB::table('admigas_saldos')->insert([
                                                    'referencia' => $referencia,
                                                    'total_recibos' => 0,
                                                    'total_pagos' => 0,
                                                    'saldo' => 0,
                                                    'admigas_departamentos_id' => $depto
                                                ]);
            /**
            * Creamos el medidor
            */

            $lectura = $faker->randomFloat(3, 0, 999);

            $medidor = DB::table('admigas_medidores')->insertGetId([
                                                                'tipo' => 1,
                                                                'marca' =>  'Khumo',
                                                                'numero_serie' => $faker->randomNumber(6,false),
                                                                'lectura' => $lectura,
                                                                'admigas_departamentos_id' => $depto
                                                            ]);
            /**
            * Insertamos la lectura inicial de los medidores
            */
            DB::table('admigas_lecturas_medidores')->insert([
                                                                'lectura' => $lectura,
                                                                'fecha_lectura' =>  '2020-05-08',
                                                                'admigas_departamentos_id' => $depto,
                                                                'admigas_medidores_id' => $medidor,
                                                            ]);
        }
    }
}
