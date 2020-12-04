<?php

namespace Modules\Edificios\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Edificios\Http\Requests\TanquesRequest;
/**
 * Modelo
 */
use App\AdmigasTanques;
use App\AdmigasUnidades;

class TanquesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('edificios::tanques.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('edificios::tanques.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(TanquesRequest $request)
    {
        /**
         * Creamos el nuevo registro
         */
        AdmigasTanques::create([
            'num_serie' => $request->num_serie,
            'marca' =>  $request->marca,
            'fecha_fabricacion' =>  $request->fecha_fabricacion,
            'estado_al_recibir' =>  $request->estado_al_recibir,
            'capacidad' =>  $request->capacidad,
            'inventario' =>  $request->inventario,
            'admigas_unidades_id' => $request->admigas_unidades_id
        ]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {

        $unidad = AdmigasUnidades::where('id', $id)
                                    ->with('Tanques')
                                    ->first();
        //dd( $unidad );
        return view('edificios::tanques.show', compact('unidad'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('edificios::tanques.edit');
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
