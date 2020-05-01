<?php

namespace Modules\Edificios\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Edificios\Http\Requests\DepartamentosRequest;
/**
 * Modelos
 */
use App\AdmigasDepartamentos;
use App\AdmigasContactoDepartamentos;
use App\AdmigasMedidores;
use App\AdmigasLecturasMedidores;

class DepartamentosController extends Controller
{
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
        $depto = AdmigasDepartamentos::create([
                                                'numero_departamento' => $request->numero_departamento,
                                                'numero_referencia' =>  $request->numero_referencia,
                                                'admigas_condominios_id' => $request->admigas_condominios_id
                                            ]);
        /**
         * Creamos el contacto del departamento
         */
        AdmigasContactoDepartamentos::create([
                                                'nombre' => $request->nombre,
                                                'apellidos' =>  $request->apellidos,
                                                'telefono' => $request->telefono,
                                                'celular' => $request->celular,
                                                'correo_electronico' => $request->correo_electronico,
                                                'admigas_departamentos_id' => $depto->id
                                            ]);
        /**
         * Creamos el medidor
         */
        $medidor = AdmigasMedidores::create([
                                                'tipo' => $request->tipo,
                                                'marca' =>  $request->marca,
                                                'numero_serie' => $request->numero_serie,
                                                'lectura' => $request->lectura,
                                                'admigas_departamentos_id' => $depto->id
                                            ]);
        /**
         * Insertamos la lectura inicial de los medidores
         */
        AdmigasLecturasMedidores::create([
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
        return view('edificios::departamentos.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('edificios::departamentos.edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
