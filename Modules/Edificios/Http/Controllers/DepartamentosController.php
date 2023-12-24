<?php

namespace Modules\Edificios\Http\Controllers;

use App\Mail\RegisterDepto;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\GenerarPDFControler;
use Modules\Edificios\Http\Requests\DepartamentosRequest;
/**
 * Modelos
 */
use App\AdmigasSaldos;
use App\AdmigasRecibos;
use App\AdmigasEmpresas;
use App\AdmigasEdificios;
use App\AdmigasMedidores;
use App\AdmigasDepartamentos;
use App\AdmigasLecturasMedidores;
use App\AdmigasContactoDepartamentos;

class DepartamentosController extends Controller
{
    private $departamentos;
    private $contactoDepartamento;
    private $medidores;
    private $lecturasMedidores;
    private $saldos;
    private $recibos;
    private $empresa;
    private $empresa_id;
    private $edificios;
    /**
     * Constructor para obtener el id empresa
     * con base al usuario que esta usando la sesion
     */
    public function __construct(
        AdmigasDepartamentos $departamentos,
        AdmigasContactoDepartamentos $contactoDepartamento,
        AdmigasMedidores $medidores,
        AdmigasLecturasMedidores $lecturasMedidores,
        AdmigasSaldos $saldos,
        AdmigasRecibos $recibos,
        AdmigasEmpresas $empresa,
        AdmigasEdificios $edificios
    )
    {
        $this->middleware(function ($request, $next) {
            $this->empresa_id = Auth::user()->Empresas->first()->id;

            return $next($request);
        });

        $this->departamentos = $departamentos;
        $this->contactoDepartamento = $contactoDepartamento;
        $this->medidores = $medidores;
        $this->lecturasMedidores = $lecturasMedidores;
        $this->saldos = $saldos;
        $this->recibos = $recibos;
        $this->empresa = $empresa;
        $this->edificios = $edificios;
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('edificios::departamentos.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create($id)
    {
        /**
         * Recuperamos el ultimo id de departamento creado
         */
        $edificio = $this->edificios->with('Unidades')->find( $id );
        /**
         * Generamos la referencia
         *
         * Zona 2 Digitos
         * Unidad 3 Digitos
         * Edificio 2 Digitos
         */
        $zona_id = str_pad( $edificio->Unidades->admigas_zonas_id, 2, '0', STR_PAD_LEFT);
        $unidad_id = str_pad( $edificio->admigas_unidades_id, 3, '0', STR_PAD_LEFT);
        $edificio_id = str_pad( $edificio->id, 2, '0', STR_PAD_LEFT);

        $referencia = $zona_id.$unidad_id.$edificio_id;

        return view('edificios::departamentos.create', compact('referencia'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(DepartamentosRequest $request)
    {
        /**
         * Creamos el nuevo departamento
         */
        $depto = $this->departamentos->create([
                                                'numero_departamento' => $request->numero_departamento,
                                                'numero_referencia' =>  $request->numero_referencia,
                                                'gasto_admin' =>  $request->gasto_admin,
                                                'admigas_condominios_id' => $request->admigas_condominios_id
                                            ]);
        /**
         * Creamos el contacto del departamento
         */
        $codigo = $this->codigo();
        /**
         * Validamos que el correo y celular vengan con datos
         */
        if ( $request->telefono == '' )
        {
            $request->telefono = '1234567890';
        }
        if ( $request->celular == '' )
        {
            $request->celular = '1234567890';
        }
        if ( $request->correo_electronico == '' )
        {
            $request->correo_electronico = 'fake@2gadmin.com.mx';
        }

        $this->contactoDepartamento->create([
                                                'nombre' => $request->nombre,
                                                'apellido_paterno' =>  $request->apellido_paterno,
                                                'apellido_materno' =>  $request->apellido_materno,
                                                'telefono' => $request->telefono,
                                                'celular' => $request->celular,
                                                'correo_electronico' => $request->correo_electronico,
                                                'codigo_verificacion' => $codigo,
                                                'clasficacion' => $request->clasificacion,
                                                'medio' => $request->medio,
                                                'admigas_departamentos_id' => $depto->id
                                            ]);
        /**
         * Damos de alta su nuevo saldo
         */
        $this->saldos->create([
                                'referencia' => $request->numero_referencia,
                                'total_recibos' => 0,
                                'total_pagos' => 0,
                                'saldo' => 0,
                                'admigas_departamentos_id' => $depto->id,
                            ]);
        /**
         * Creamos el medidor
         */
        $medidor = $this->medidores->create([
                                                'tipo' => $request->tipo,
                                                'marca' =>  $request->marca,
                                                'numero_serie' => $request->numero_serie,
                                                'lectura' => $request->lectura,
                                                'admigas_departamentos_id' => $depto->id
                                            ]);
        /**
         * Insertamos la lectura inicial de los medidores
         */
        $this->lecturasMedidores->create([
                                            'lectura' => $request->lectura,
                                            'fecha_lectura' =>  $request->fecha_lectura,
                                            'admigas_departamentos_id' => $depto->id,
                                            'admigas_medidores_id' => $medidor->id,
                                        ]);
        /**
         * Enviamos correo de registro
         */
        if ( $request->correo_electronico != '' )
        {
            $nombre = $request->nombre." ".$request->apellido_paterno." ".$request->apellido_materno;
            Mail::to($request->correo_electronico)->send(new RegisterDepto($nombre, $codigo));
        }
        /**
         * Redirigimos a la ruta index
         */
        return redirect()->route('condominios.show', [$request->admigas_condominios_id]);

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $depto = $this->departamentos->where('id', $id)->with('Medidores')->with('Contacto_Depto')->first();

        $estado_cuenta = DB::select("call SP_estado_cuenta( $id )");

        return view('edificios::departamentos.show', compact('depto', 'estado_cuenta'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $depto = $this->departamentos->where( 'id', $id )->with('Medidores')->with('Contacto_Depto')->first();
        return view('edificios::departamentos.edit', compact('depto'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {

        /**
         * Validamos que la referencia sea la misma
         */
        $depto = $this->departamentos
                      ->where('id', $request->admigas_departamentos_id)
                      ->first();

        if ($depto->numero_referencia != $request->numero_referencia) {
            /**
             * Actualizamos la referencia en recibos
             */
            DB::table('admigas_recibos')
                ->where('referencia', $depto->numero_referencia)
                ->where('admigas_departamentos_id', $request->admigas_departamentos_id)
                ->update(['referencia' => $request->numero_referencia]);
            /**
             * Actualizamos la referencia en pagos
             */
            DB::table('admigas_pagos')
                ->where('referencia', $depto->numero_referencia)
                ->update(['referencia' => $request->numero_referencia]);
            /**
             * Actualizamos la referencia en saldos
             */
            DB::table('admigas_saldos')
                ->where('referencia', $depto->numero_referencia)
                ->update(['referencia' => $request->numero_referencia]);


        }


        /**
         * Creamos el nuevo departamento
         */
        $this->departamentos->where('id', $request->admigas_departamentos_id)
                                    ->update([
                                            'numero_departamento' => $request->numero_departamento,
                                            'numero_referencia' =>  $request->numero_referencia,
                                            'gasto_admin' =>  $request->gasto_admin
                                        ]);
        /**
         * Creamos el contacto del departamento
         */
        $this->contactoDepartamento->where('admigas_departamentos_id', $request->admigas_departamentos_id)
                                    ->update([
                                        'nombre' => $request->nombre,
                                        'apellido_paterno' =>  $request->apellido_paterno,
                                        'apellido_materno' =>  $request->apellido_materno,
                                        'telefono' => $request->telefono,
                                        'celular' => $request->celular,
                                        'correo_electronico' => $request->correo_electronico,
                                        'clasficacion' => $request->clasificacion,
                                        'medio' => $request->medio,
                                    ]);
        /**
         * Redirigimos a la ruta index
         */
        return redirect()->route('condominios.show', [$request->id_condominio]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $idCondominio = $this->departamentos->select('admigas_condominios_id')->where('id', $id)->first();

        $this->departamentos->where('id', $id)
                                    ->update([
                                            'activo' => 0
                                        ]);
         /**
         * Redirigimos a la ruta index
         */
        return redirect()->route('condominios.show', [$idCondominio->admigas_condominios_id]);

    }

    public function codigo()
    {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
    }

    public function show_recibo( $id_departamentos, $id_recibo )
    {

        $recibos = AdmigasRecibos::active()->where('clave_recibo', $id_recibo)->where('admigas_departamentos_id', $id_departamentos)->with('Mensajes')->first();
        $e = new GenerarPDFControler;
        $pdf = $e->generate( $id_departamentos, 1, $recibos,$this->empresa_id );
        return $pdf;

    }
}
