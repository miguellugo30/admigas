<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use DB;
use App\AdmigasContactoDepartamentos;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        /**
         * Validador de codigo
         */
        Validator::extend('codigocliente', function ($field, $value, $parameters)
        {
                $code = AdmigasContactoDepartamentos::select('codigo_verificacion', 'id')->where('correo_electronico', $parameters[0])->get();

                if ($code->isNotEmpty())
                {
                    if ((int)$value == $code->first()->codigo_verificacion)
                    {
                        return true;
                    }
                    return false;
                }

                return false;

            }, 'El codigo no es valido');
        /**
         * Validado de correo existente
         */
        Validator::extend('clientecorreo', function ($field, $value)
        {
            if(AdmigasContactoDepartamentos::where('correo_electronico', $value)->exists()) {
                return true;
            }
            return false;
        }, 'El correo no esta registrado');

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'clientecorreo' ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'code' => ['required', 'numeric','min:8', 'codigocliente:'.$data['email']],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $info = AdmigasContactoDepartamentos::select('amigas_departamentos_id')->where('correo_electronico', $data['email'])->first();

        /**
         * Creamos el usuario y recuperamos el id del usuario
         */
        $user_id = User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'tipo' => 1,
                ]);
        /**
         * Vinculamos el usuario con el departamentos
         */
        DB::table('admigas_departamentos_user')->insert([
            'user_id' => $user_id->id,
            'admigas_departamentos_id' => $info->id
        ]);
         /**
          * Redireccionamos al modulo de clientes
          */
        return $user_id;
    }
}
