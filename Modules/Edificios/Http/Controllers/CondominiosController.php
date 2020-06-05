<?php

namespace Modules\Edificios\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Edificios\Http\Requests\EdificiosRequest;
/**
 * Modelos
 */
use App\AdmigasUnidades;
use App\AdmigasEdificios;
use App\AdmigasTanques;
use App\AdmigasDepartamentos;

class CondominiosController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index( $id )
    {
         /**
         * Recuperamos la infor de la unidad
         */
        $unidad = AdmigasUnidades::where('id', $id)->with('Zonas')->get();
        /**
         * Recuperamos los edificios de la unidad
         */
        $edificios = AdmigasEdificios::active()->unidad( $id )->get();

        return view('edificios::condominios.index', compact( 'unidad', 'edificios' ));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create( $id )
    {
        /**
         * Recuperamos los tanques de la unidad
         */
        $tanques = AdmigasTanques::where( 'admigas_unidades_id', $id )->get();

        return view('edificios::condominios.create', compact('tanques'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(EdificiosRequest $request)
    {
        /**
         * Creamos el nuevo registro
         */
        $condominio = AdmigasEdificios::create([
                                                'tipo' => $request->tipo,
                                                'nombre' =>  $request->nombre,
                                                'descuento' =>  $request->descuento,
                                                'factor' =>  $request->factor,
                                                'gasto_admin' =>  $request->gasto_admin,
                                                'fecha_lectura' =>  $request->fecha_lectura,
                                                'admigas_unidades_id' => $request->admigas_unidades_id
                                            ]);

        $condominio->Tanques()->attach($request->tanques);

        /**
         * Redirigimos a la ruta index
         */
        return redirect()->route('unidades.condominios', [$request->admigas_unidades_id]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        /**
         * Obtenemos el registro selecionado
         */
        $condominio = AdmigasEdificios::active()->where('id', $id)->get();
        /**
         * Obtenemos los departamentos del condominios
         */
        $deptos = AdmigasDepartamentos::active()->where( 'admigas_condominios_id', $id )->with('Contacto_Depto')->with('Medidores')->with('Saldo')->get();

        //dd( $deptos );

        return view('edificios::condominios.show', compact('condominio', 'deptos'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        /**
         * Recuperamos la informacion de la zona
         */
        $condominio = AdmigasEdificios::where('id', $id)->first();
        $tanquesCondominio = $condominio->Tanques->pluck('id')->toArray();
        /**
         * Recuperamos los tanques de la unidad
         */
        $tanques = AdmigasTanques::where( 'admigas_unidades_id', $condominio->admigas_unidades_id )->get();

        return view('edificios::condominios.edit',compact('condominio', 'tanques', 'tanquesCondominio'));
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
         * Creamos el nuevo registro
         */
        $condominio = AdmigasEdificios::find( $id );

        $condominio->tipo = $request->tipo;
        $condominio->nombre = $request->nombre;
        $condominio->descuento = $request->descuento;
        $condominio->factor = $request->factor;
        $condominio->gasto_admin = $request->gasto_admin;
        $condominio->fecha_lectura = $request->fecha_lectura;

        $condominio->save();

        $condominio->Tanques()->detach();
        $condominio->Tanques()->attach($request->tanques);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        AdmigasEdificios::where('id', $id)
        ->update([
            'activo' => 0
        ]);
    }
}
