<?php

namespace Modules\Edificios\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Edificios\Http\Requests\DepartamentosRequest;
use DB;
/**
 * Modelos
 */
use App\AdmigasDepartamentos;
use App\AdmigasContactoDepartamentos;
use App\AdmigasMedidores;
use App\AdmigasLecturasMedidores;
use App\AdmigasRecibos;
use App\AdmigasSaldos;

class DepartamentosController extends Controller
{
    private $departamentos;
    private $contactoDepartamento;
    private $medidores;
    private $lecturasMedidores;
    private $saldos;
    private $recibos;
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
        AdmigasRecibos $recibos
    )
    {

        $this->departamentos = $departamentos;
        $this->contactoDepartamento = $contactoDepartamento;
        $this->medidores = $medidores;
        $this->lecturasMedidores = $lecturasMedidores;
        $this->saldos = $saldos;
        $this->recibos = $recibos;
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
    public function create()
    {
        return view('edificios::departamentos.create');
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
                                                'admigas_condominios_id' => $request->admigas_condominios_id
                                            ]);
        /**
         * Creamos el contacto del departamento
         */
        $codigo = $this->codigo();

        $this->contactoDepartamento->create([
                                                'nombre' => $request->nombre,
                                                'apellido_paterno' =>  $request->apellido_paterno,
                                                'apellido_materno' =>  $request->apellido_materno,
                                                'telefono' => $request->telefono,
                                                'celular' => $request->celular,
                                                'correo_electronico' => $request->correo_electronico,
                                                'codigo_verifiacicion' => $codigo,
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
        $recibos = $this->recibos->select('clave_recibo', 'fecha_recibo', 'fecha_limite_pago', DB::raw('importe + gasto_admin + cargos_adicionales AS importe'))->where('admigas_departamentos_id', $id)->get();
        $saldos = $this->saldos->select('total_recibos', 'total_pagos', 'saldo')->where('admigas_departamentos_id', $id)->first();

        return view('edificios::departamentos.show', compact('depto', 'recibos', 'saldos'));
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
         * Creamos el nuevo departamento
         */
        $this->departamentos->where('id', $request->admigas_departamentos_id)
                                    ->update([
                                            'numero_departamento' => $request->numero_departamento,
                                            'numero_referencia' =>  $request->numero_referencia
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
                                        'correo_electronico' => $request->correo_electronico
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
}
