<?php

namespace Modules\CreditoCobranza\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\CreditoCobranza\Http\Requests\ConciliacionRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\AdmigasDepartamentos;
use App\AdmigasPagos;

class ConciliacionController extends Controller
{
    private $user_id;
    /**
     * Constructor para obtener el id empresa
     * con base al usuario que esta usando la sesion
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
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
        return view('creditocobranza::conciliacion.index');
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
    public function store(ConciliacionRequest $request)
    {
        $tmp = $request->archivoConciliar->path();
        $content = explode("\n", \File::get( $tmp ));

        $data = $this->formatearInformacion( $content );

        for ($i=0; $i < count( $data ); $i++)
        {
            /*
             * Validamos que la referencia exista
             */
            if( AdmigasDepartamentos::where('numero_referencia', $data[$i]['referencia'])->exists() )
            {
                /*
                 * Validamos que no exista un pago igual
                 */
                if (
                    !AdmigasPagos::where('referencia', $data[$i]['referencia'])
                                ->where('importe', $data[$i]['importe'])
                                ->where('fecha_pago', $data[$i]['fecha'])
                                ->exists()
                    )
                {
                    /*
                     * Recuperamos le id del departamento
                     **/
                    $id = AdmigasDepartamentos::select('id')->where('numero_referencia', $data[$i]['referencia'])->first();
                    /*
                     * Insertamos el pago
                     **/
                    $pago = AdmigasPagos::create([
                                                    'referencia' => $data[$i]['referencia'],
                                                    'referencia_completa' => $data[$i]['guia_cie'],
                                                    'importe' => $data[$i]['importe'],
                                                    'fecha_pago' => $data[$i]['fecha'],
                                                    'medio_pago' => 'EFE',
                                                    'estatus' => 1,
                                                    'modo' => 2,
                                                ]);

                    /*
                     * Relacionamos el pago con el departamento
                     **/
                    \DB::table('admigas_departamentos_pagos')->insert([
                        'admigas_departamentos_id' => $id->id,
                        'admigas_pagos_id' => $pago->id,
                        'user_id' => $this->user_id,
                        'fecha_aplicacion' => date('Y-m-d'),
                    ]);
                    /*
                     * Marcamos el pago como conciliado
                     */
                    $data[$i]['conciliado'] = 1 ;
                }
            }
            else
            {
                if ( $data[$i]['importe'] != '' )
                {
                    if (!Str::contains( $data[$i]['referencia'], 'VENTAS')                        )
                    {
                        /*
                         * Insertamos el pago
                         **/
                        AdmigasPagos::create([
                            'referencia' => 'SIN REFERENCIA',
                            'referencia_completa' => $data[$i]['guia_cie'],
                            'importe' => $data[$i]['importe'],
                            'fecha_pago' => $data[$i]['fecha'],
                            'medio_pago' => 'EFE',
                            'estatus' => 0,
                            'modo' => 2,
                        ]);
                        /*
                         * Marcamos el pago como conciliado
                         */
                        $data[$i]['conciliado'] = 0 ;
                    }
                    else
                    {
                        $data[$i]['conciliado'] = 2 ;
                    }
                }//IF coincidencia 3300
            }//IF existe referencia
        }//FOR

        $data = collect($data);

        return view('creditocobranza::conciliacion.resultado', compact('data'));
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

    public function formatearInformacion($data)
    {

        $info = array();

        for ($i=1; $i < count( $data ); $i++)
        {
            $datos = explode("\t", $data[$i]);

            if ( count($datos) > 1 )
            {
                $referenciaCompleta = explode('/', $datos[1]);
                $referencia = str_replace('CE', '', $referenciaCompleta[0]);
                $fecha = date('Y-m-d', strtotime($datos[0]));

                    $c['fecha'] = $fecha;
                    $c['guia_cie'] = $datos[1];
                    $c['referencia'] = $referencia;
                    $c['concepto'] = 'Pago recibo';
                    $c['tipo_pago'] = 'EFE';
                    $c['importe'] = str_replace(',', '', $datos[3]);
                    $c['conciliado'] = 2;

                    array_push( $info, $c );
            }

        }
        return $info;
    }
}
