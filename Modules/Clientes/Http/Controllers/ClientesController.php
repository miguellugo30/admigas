<?php

namespace Modules\Clientes\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Events\Dispatcher;
use App\Http\Controllers\GenerarPDFControler;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
/**
 * Modelos
 */
use App\AdmigasMenus;
use App\AdmigasRecibos;
use App\AdmigasContactoDepartamentos;
use App\AdmigasDepartamentos;
use App\AdmigasEmpresas;
use App\AdmigasPagos;

class ClientesController extends Controller
{
    private $recibos;
    private $departamentos;
    private $contactoDepartamento;
    private $empresas;
    private $pagos;

    public function __construct(
        Dispatcher $events,
        AdmigasRecibos $recibos,
        AdmigasDepartamentos $departamentos,
        AdmigasContactoDepartamentos $contactoDepartamento,
        AdmigasEmpresas $empresas,
        AdmigasPagos $pagos
        )
    {

        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {

            $event->menu->add([
                'text' => 'Inicio',
                'id' => 0,
                'url' => "/clientes",
                'icon' => 'fas fa-home',
                'permiso' => 'view inicio',
                'clase' => ''
            ]);

            $categorias = AdmigasMenus::active()->where('admigas_cat_modulos_id',5)->orderBy('orden', 'asc')->get();

            foreach ($categorias as $v) {
                $event->menu->add( [
                    'text' => $v->nombre,
                    'id' => $v->id,
                    'url' => "#",
                    'icon' => $v->icono,
                    'permiso' => $v->permiso,
                    'clase' => 'menu'
                ]);
            }
        });

        $this->recibos = $recibos;
        $this->departamentos = $departamentos;
        $this->contactoDepartamento = $contactoDepartamento;
        $this->empresas = $empresas;
        $this->pagos = $pagos;
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $modulo = 5;
        /**
         * Recuperamos los datos del cliente
         */
        $depto =  $this->departamentos->find( \Auth::user()->Departamentos->first()->id );
        /**
         * Contacto Depto
         */
        $saldo = \DB::select("call SP_saldo_recibo( '$depto->numero_referencia' )");
        //dd($saldo);
        /**
         * Recibos
         */
        $recibos = $depto->Recibos;
        /**
         * Recuperamos los ultimos 6 recibos
         */
        $ultimosRecibos = \DB::select('call SP_consumo_recibos( ' . \Auth::user()->Departamentos->first()->id . ' );');

        $data = $recibos->first()->referencia."_".$recibos->first()->clave_recibo;
        $data .=  number_format( round( (float)$saldo[0]->total_recibos - (float)$saldo[0]->total_pagos ), 2, '.', '');
        //$data .=  number_format( 1 , 2);
        $data .= 1842;
        $signature = hash_hmac("sha256", $data, 'l5dSMMeQCyZua-zH22Tx');

        return view('clientes::index', compact('modulo', 'depto', 'recibos', 'ultimosRecibos', 'saldo', 'signature'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $consumos = \DB::select("call SP_consumo_recibos( $id )");
        Carbon::setlocale(config('app.locale'));

        $fechas = array();
        $litros = array();
        $data = array();

        foreach ($consumos as $consumo)
        {
            array_push($fechas, Carbon::parse($consumo->fecha_recibo)->translatedFormat('F') );
            array_push($litros, $consumo->litros );
        }

        $data['fechas'] = $fechas;
        $data['litros'] = $litros;

        return response()->json($data, 200);
    }
    /**
     * codigo = 0 éxito , 3 pagado por CLABE y cualquier otro número es un error
     * mensaje = "Pago exitoso" o mensaje de error
     * autorizacion = Valor numérico de la autorización del pago
     * referencia = REF001
     * importe = 1.00
     * mediopago = Medio de pago utilizado para realizar la transacción
     * financiado = Indica en el pago aplicó financiamiento
     * plazos = Número de meses en que aplica el financiamiento
     * s_transm = Identificador único del pago
     * hash = Cadena de identificación del pago utilizado por Multipagos
     * tarjetahabiente = Propietario de la tarjeta utilizada para el pago
     * cveTipoPago = ID del tipo de pago, estos valores son propios de un catálogo del SAT.(Solo pagos tarjeta)
     * signature = Se calcula con el algoritmo SHA256 concatenando los valores (referencia + importe + idexpress) y la llave otorgada.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {

        $hash = hash( 'sha256', $request->referencia." ".$request->importe." 1842" );

        \Log::info($request);

        if ( $request->codigo== 0 )
        {
            $pago = $this->pagos->create([
                                            'referencia' => $request->referencia,
                                            'referencia_completa' => $request->s_transm."_".$request->referencia,
                                            'importe' => $request->importe,
                                            'fecha_pago' => \DB::raw('NOW()'),
                                            'estatus' => 1,
                                            'modo' => 1,
                                        ]);

            return response()->json( "Pago exitoso" );
        }
        else if( $request->codigo== 3 )
        {
            return response()->json( "El pago se realizo por clabe, el cobro se realizara de 1 0 2 dias habiles, si el cobro no se realiza en este tiempo favor de comunicarse." );
        }
        else
        {
            return response()->json( "Tuvimos un problema con su pago, favor de comunicase a los siguientes numeros." );
        }



        return response()->json( $hash   );
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('clientes::edit');
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
         * Creamos el contacto del departamento
         */
        $this->contactoDepartamento->where('admigas_departamentos_id', $request->departamento_id)
            ->update([
                'nombre' => $request->nombre,
                'apellido_paterno' =>  $request->apellido_paterno,
                'apellido_materno' =>  $request->apellido_materno,
                'telefono' => $request->telefono,
                'celular' => $request->celular,
                'correo_electronico' => $request->correo_electronico
            ]);
    }

    public function mi_cuenta(Request $request)
    {
        /**
         * Recuperamos los datos del cliente
         */
        $depto =  $this->departamentos->find($request->departamento_id);

        return view('clientes::mi_cuenta', compact('depto'));
    }

    public function estado_cuenta(Request $request)
    {
        $estado_cuenta = \DB::select("call SP_estado_cuenta( $request->departamento_id )");

        return view('clientes::estado_cuenta', compact('estado_cuenta'));
    }

    public function medios_contacto(Request $request)
    {
        return view('clientes::medios_contacto');
    }
    /**
     * Mostrar recibo
     */
    public function showRecibo($id, $option)
    {
        /**
         * Recuperamos los datos del cliente
         */
        $depto =  $this->departamentos->find(\Auth::user()->Departamentos->first()->id);
        /**
         * Recuperamos el recibo a mostrar
         */
        $recibos = $this->recibos->where('id', $id)->first();

        $e = new GenerarPDFControler;
        $pdf = $e->generate( $depto->id, 1, $recibos,$depto->condominios->Unidades->Zonas->admigas_empresas_id );

        return $pdf;
    }
}
