<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
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
                $code = User::select('remember_token')->where('email', $parameters[0])->get();

                if ($code->isNotEmpty())
                {
                    if ($value == $code->first()->remember_token)
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
            if(User::where('email', $value)->exists()) {
                return true;
            }
            return false;
        }, 'El correo no esta registrado');

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255' ],
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
                return User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                ]);
    }
}
