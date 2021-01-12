<?php

namespace Modules\Edificios\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\QuerysJoinController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Modules\Edificios\Http\Controllers\DepartamentosController;
use App\Jobs\CreatePdfEmail;
use DB;
use App\Events\eventoNotificacion;
use App\Mail\EnvioRecibos;
use App\Notifications\FechaLimiteAVencer;
/**
 * Modelos
 */
use App\AdmigasRecibos;
use App\AdmigasEdificios;
use App\AdmigasEmpresas;
use App\AdmigasDepartamentos;
use App\AdmigasServicios;

class RecibosController extends Controller
{
    private $empresa_id;
    private $condominio;
    private $query;
    private $recibos;
    private $empresa;
    private $departamento;
    private $servicios;
    /**
     * Constructor para obtener el id empresa
     * con base al usuario que esta usando la sesion
     */
    public function __construct(
                                    AdmigasEdificios $condominio,
                                    QuerysJoinController $query,
                                    AdmigasRecibos $recibos,
                                    AdmigasEmpresas $empresa,
                                    AdmigasDepartamentos $departamento,
                                    AdmigasServicios $servicios
                                )
    {
        $this->middleware(function ($request, $next) {
            $this->empresa_id = Auth::user()->Empresas->first()->id;

            return $next($request);
        });

        $this->condominio = $condominio;
        $this->query = $query;
        $this->recibos = $recibos;
        $this->empresa = $empresa;
        $this->departamento = $departamento;
        $this->servicios = $servicios;
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('edificios::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create( $id )
    {
        /**
         * Obtenemos el registro selecionado
         */
        $condominio = $this->condominio->where('id', $id)->get();
        /**
         * Obtenemos los departamentos del condominios
         */
        $deptos = $this->query->queryRecibos( $id );

        $data = $this->query->calcularConsumos( $deptos, $condominio, $this->empresa_id );

        if ( $data->has('error')  ) {
            return '<div class="alert alert-danger text-center" role="alert">No se ha dado de alta un <b>precio de gas<b></div>';
        } else {
            return view('edificios::recibos.create', compact('condominio', 'data'));
        }


    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        /**
         * Obtenemos el registro selecionado
         */
        $condominio = $this->condominio->where('id', $request->admigas_condominios_id)->with('Unidades')->first();
        /**
         * Obtenemos los departamentos del condominios
         */
        $deptos = $this->query->queryRecibos( $request->admigas_condominios_id );

        $this->query->generarRecibos( $deptos, $condominio, $this->empresa_id, $request->fecha_recibo );
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
        /**
         * Obtenemos la fecha del ultimo recibo
         */
        $fecha = DB::select("call SP_fecha_ultimo_recibo( $id )");
        /**
         * Obtenemos los recibos del condominio
         */
        $recibos = $this->recibos
                    ->where('admigas_condominios_id', $id)
                    ->where('fecha_recibo', 'like',date('Y-m', strtotime($fecha[0]->fecha_recibo))."%"  )
                    ->active()
                    ->get();
        return $this->createPdf( $recibos, 2 );

    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        /**
         * Buscamos el departamento
         */
        $depto = $this->departamento::find( $id );
        /**
         * Obtenemos la fecha del ultimo recibo
         */
        $fecha = DB::select("call SP_fecha_ultimo_recibo( $depto->admigas_condominios_id )");
        /**
         * Obtenemos el ultimo recibo
         */
        $recibo = $this->recibos
                        ->where('admigas_departamentos_id', $id)
                        ->where('fecha_recibo', 'like',date('Y-m', strtotime($fecha[0]->fecha_recibo))."%"  )
                        ->active()
                        ->first();
        /**
         * Obtenemos los cargos adicionales
         */
        $servicios = $this->servicios->active()->empresa($this->empresa_id)->get();

        return view('edificios::recibos.edit', compact('recibo', 'servicios'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $recibo = $this->recibos::find( $id );
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {

        if ( $request->cancel == 1 )
        {
            /**
             * Obtenemos la fecha del ultimo recibo
             */
            $fecha = DB::select("call SP_fecha_ultimo_recibo( $id )");

            $this->recibos->where([
                                    'fecha_recibo' => $fecha[0]->fecha_recibo,
                                    'admigas_condominios_id' => $id
                                ])
                            ->update([
                                        'activo' => 0,
                                        'motivo_cancelacion' => $request->motivo_cancelacion
                                    ]);
        }
        else
        {
        }

        /**
         * Redirigimos a la ruta index
         */
        return redirect()->route('vista.recibos', [$id]);
    }
    /**
     * Funcion para enviar lo recibos por correo electronico
     */
    public function sendRecibos($id)
    {
        //$deptos = array(1,2,3,4,5);
        //Auth::user()->notify(new FechaLimiteAVencer( $deptos ));
        event(new eventoNotificacion('Se ha iniciado una tarea en segundo plano, para el envio de recibos'));
        /**
         * Obtenemos la fecha del ultimo recibo
         */
        $fecha = DB::select("call SP_fecha_ultimo_recibo( $id )");
        /**
         * Obtenemos los recibos del condominio
         */
        $recibos = $this->recibos
                    ->where('admigas_condominios_id', $id)
                    ->where('fecha_recibo', 'like',date('Y-m', strtotime($fecha[0]->fecha_recibo))."%"  )
                    ->with('Departamento.Contacto_Depto')
                    ->active()
                    //->take(1)
                    ->get();
        /**
         * Creamos el trabajo para crear los PDF
         */
        event(new eventoNotificacion('Se ha iniciado con la generacion de los PDF, para su envio'));
        CreatePdfEmail::dispatch( $recibos, $this->empresa_id );
        event(new eventoNotificacion('Se ha terminado con la generacion de los PDF, se incia el envio de correos'));

        foreach ($recibos as $recibo )
        {
            /**
             * Obtenemos el total a pagar
             */
            $saldo = \DB::select("call SP_saldo_recibo( '$recibo->referencia' )");
            $total_pagar = number_format( ( round($saldo[0]->total_recibos) - round($saldo[0]->total_pagos) ),2 );
            /**
             * Obtenemos el correo del condominio
             */
            $correo =  $recibo->Departamento->Contacto_Depto->correo_electronico;
            if ( ! \Str::contains($correo, 'fake') ) {
                Mail::to($correo)->send(new EnvioRecibos( $recibo, $total_pagar ));
                //Mail::to('mchlugo@hotmail.com')->send(new EnvioRecibos( $recibo, $total_pagar ));
            }
        }
        event(new eventoNotificacion('Se ha terminado con el envio de correos'));
    }
    /**
     * Funcion para crear los PDF de los recibos
     */
    private function createPdf( $recibos, $opcion  )
    {
        $empresa_id = $this->empresa_id;
         /**
         * Obtenemos el convenio cie de la empresa
         */
        $convenio = $this->empresa->where( 'id', $this->empresa_id )->with('Cuentas')->first();
        $cie =  $convenio->Cuentas->convenio_cie;
        /**
         * opcion = 1 guardar en disco local
         * opcion = 2 mostrar en navegador
         */
        if ( $opcion == 1 )
        {
            $url_recibo = file_get_contents( public_path('storage/recibo/recibo_2G-v2.png') );
            $pdf = \PDF::loadView('edificios::recibos.show_mail', compact('recibos', 'cie','empresa_id', 'url_recibo'))
                        ->setPaper('A4')
                        ->output();
            Storage::put('\public\recibo_'.$recibos->admigas_departamentos_id.'.pdf', $pdf);
        }
        elseif( $opcion == 2 )
        {
            return  \PDF::loadView('edificios::recibos.show', compact( 'recibos', 'cie', 'empresa_id' ) )
                        ->setPaper('letter', 'landscape')
                        ->setOptions(['defaultFont' => 'verdana'])
                        ->stream('archivo.pdf');
        }
    }
}
