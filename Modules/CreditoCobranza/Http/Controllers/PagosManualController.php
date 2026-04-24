<?php

namespace Modules\CreditoCobranza\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
/**
 * Modelos
 */
use App\AdmigasPagos;
use App\AdmigasRecibos;
use App\AdmigasUnidades;
use Modules\CreditoCobranza\Http\Requests\PagoManualRequest;

class PagosManualController extends Controller
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

        return view('creditocobranza::pagosManual.index', compact('unidades'));
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
    public function store(PagoManualRequest $request)
    {
        //sdd($request->file('archivoConciliar'));
        $fecha = date('Y-m-d', strtotime( $request->fecha ));
        /**
         * Recuperamos el ultimo recibo del depto
         */
        $recibo = AdmigasRecibos::where('admigas_departamentos_id', $request->depto)->orderby('id', 'desc')->first();
        //dd($recibo);
        /**
         * Validamos que no exista un pago igual
         */
        if (
            !AdmigasPagos::where('referencia', $recibo->referencia)
                        ->where('referencia_completa', $recibo->referencia."_".$recibo->clave_recibo)
                        ->where('importe', $request->importe)
                        ->where('fecha_pago', $fecha)
                        ->exists()
            )
        {
            /**
             * Insertamos el pago
             **/
            $pago = AdmigasPagos::create([
                                            'referencia' => $recibo->referencia,
                                            'referencia_completa' => $recibo->referencia."_".$recibo->clave_recibo,
                                            'importe' => $request->importe,
                                            'fecha_pago' => $fecha,
                                            'medio_pago' => 'EFE',
                                            'estatus' => 1,
                                            'modo' => 3,
                                        ]);
            /**
             * Relacionamos el pago con el departamento
             **/
            \DB::table('admigas_departamentos_pagos')->insert([
                'admigas_departamentos_id' => $request->depto,
                'admigas_pagos_id' => $pago->id,
                'user_id' => $this->user_id,
                'fecha_aplicacion' => date('Y-m-d'),
            ]);

            $request->file('archivoConciliar')->storeAs('/' . $this->empresa_id . '/comprobante_pago/', $request->depto . '_' . $pago->id .'_'  .  $request->file('archivoConciliar')->getClientOriginalName());

        }else {
            return response()->json([
                'message'      =>  'The given data was invalid.',
                'errors'   =>  [
                                    'pago' => [ 'Ya existe un pago igual al que se quiere aplicar' ]
                                ]
            ], 422);
        }

        return redirect()->route('pagos-manual.index');
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
}
