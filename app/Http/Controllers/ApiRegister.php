<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
/**
 * Modelos
 */
use App\AdmigasDepartamentos;
/**
 * Email
 */
use App\Mail\NumeroVerificacion;

class ApiRegister extends Controller
{
    private $departamentos;

    public function __construct(
        AdmigasDepartamentos $departamentos
    ) {
    $this->departamentos = $departamentos;
}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $numero = rand(0,99999);
        /**
         * Validamos que la referencia sea valida
         */
        $depto = $this->departamentos
                    ->where('numero_referencia', $request->num_referencia)
                    ->where('activo', 1)
                    ->first();
        if ($depto) {
            /**
             * Enviar correo de confirmación
             */
            Mail::to('mchlugo@hotmail.com')->send(new NumeroVerificacion( $numero ));

            return response()->json([
                'message' => 'La referencia existe',
                'numero_verificacion' => $numero,
                'success' => true
            ]);
        } else {
            return response()->json([
                'message' => 'Número de Referencia no existe',
                'numero_verificacion' => null,
                'success' => false
            ]);
        }



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
