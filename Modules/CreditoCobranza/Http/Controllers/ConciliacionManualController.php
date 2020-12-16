<?php

namespace Modules\CreditoCobranza\Http\Controllers;

use App\AdmigasDepartamentos;
use App\AdmigasEdificios;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
/**
 * Modelos
 */
use App\AdmigasPagos;
use App\AdmigasUnidades;

class ConciliacionManualController extends Controller
{
    private $empresa_id;
    private $user_id;
    /**
     * Constructor para obtener el id empresa
     * con base al usuario que esta usando la sesion
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->empresa_id = Auth::user()->Empresas->first()->id;
            $this->user_id = Auth::user()->id;

            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $unidades = AdmigasUnidades::active()->get();

        $pagos = AdmigasPagos::active(0)->modo(1)->get();

        return view('creditocobranza::conciliacionManual.index',compact('pagos', 'unidades'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('creditocobranza::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {

        /**
         * Relacionamos el pago con el departamento
         **/
        \DB::table('admigas_departamentos_pagos')->insert([
            'admigas_departamentos_id' => $request->depto_id,
            'admigas_pagos_id' => $request->pago_id,
            'user_id' => $this->user_id,
            'fecha_aplicacion' => date('Y-m-d'),
        ]);

        AdmigasPagos::where( 'id', $request->pago_id )->update(['estatus' => 1]);

        return redirect()->route('conciliacion-manual.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('creditocobranza::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('creditocobranza::edit');
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


    public function search_edificio($id)
    {
        $edificios = AdmigasEdificios::unidad($id)->get();

        return view('creditocobranza::conciliacionManual.result_search_unidad', compact('edificios'));
    }

    public function search_departamento($id)
    {
        $departamentos = AdmigasDepartamentos::condominio($id)->get();

        return view('creditocobranza::conciliacionManual.result_search_depto', compact('departamentos'));
    }
}
