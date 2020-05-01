<?php

namespace Modules\Edificios\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Edificios\Http\Requests\UnidadesRequest;
use Carbon\Carbon;
/**
 * Modelos
 */
use App\AdmigasZonas;
use App\AdmigasUnidades;
use App\AdmigasEdificios;

class UnidadesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index( $id )
    {
        /**
         * Recuperamos la informacion de la zona
         */
        $zona = AdmigasZonas::where('id', $id)->get();
        /**
         * Mostramos las unidades de la zona
         */
        $unidades = AdmigasUnidades::active()->zona( $id )->get();

        return view('edificios::unidades.index', compact('unidades', 'zona'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('edificios::unidades.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(UnidadesRequest $request)
    {
        /**
         * Creamos el nuevo registro
         */
        AdmigasUnidades::create([
                                    'nombre' => $request->nombre,
                                    'calle' =>  $request->calle,
                                    'numero' =>  $request->numero,
                                    'colonia' =>  $request->colonia,
                                    'delegacion_municipio' =>  $request->municipio,
                                    'cp' =>  $request->cp,
                                    'estado' =>  $request->estado,
                                    'entre_calle' =>  $request->entre_calles,
                                    'fecha_alta' =>  Carbon::now(),
                                    'admigas_zonas_id' => $request->admigas_zonas_id
                                ]);
        /**
         * Redirigimos a la ruta index
         */
        return redirect()->route('zona.unidades', [$request->admigas_zonas_id]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        /**
         * Recuperamos la infor de la unidad
         */
        $unidad = AdmigasUnidades::where('id', $id)->with('Zonas')->get();
        /**
         * Recuperamos los edificios de la unidad
         */
        $edificios = AdmigasEdificios::unidad( $id )->get();

        return view('edificios::condominios.index', compact( 'unidad', 'edificios' ));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('edificios::unidades.edit');
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
