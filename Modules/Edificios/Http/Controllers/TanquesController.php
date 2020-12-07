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
        /**
         * Redirigimos a la ruta index
         */
        return redirect()->route('tanques.show', [$request->admigas_unidades_id]);
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
        return view('edificios::tanques.show', compact('unidad'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $tanque = AdmigasTanques::find( $id );

        return view('edificios::tanques.edit', compact('tanque'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(TanquesRequest $request, $id)
    {
        AdmigasTanques::where('id', $id)
        ->update([
            'num_serie' => $request->num_serie,
            'marca' =>  $request->marca,
            'fecha_fabricacion' =>  $request->fecha_fabricacion,
            'estado_al_recibir' =>  $request->estado_al_recibir,
            'capacidad' =>  $request->capacidad,
            'inventario' =>  $request->inventario
        ]);
        /**
         * Redirigimos a la ruta index
         */
        return redirect()->route('tanques.show', [$request->admigas_unidades_id]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {

        $tanque = AdmigasTanques::find( $id );
        $tanque->activo = 0;
        $tanque->save();
        /**
         * Redirigimos a la ruta index
         */
        return redirect()->route('tanques.show', [$tanque->admigas_unidades_id]);
    }
}
