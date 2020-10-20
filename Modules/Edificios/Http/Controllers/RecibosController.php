<?php

namespace Modules\Edificios\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\QuerysJoinController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use DB;
/**
 * Modelos
 */
use App\AdmigasRecibos;
use App\AdmigasEdificios;
use App\Mail\EnvioRecibos;
use App\AdmigasEmpresas;

class RecibosController extends Controller
{
    private $empresa_id;
    private $condominio;
    private $query;
    private $recibos;
    private $empresa;
    /**
     * Constructor para obtener el id empresa
     * con base al usuario que esta usando la sesion
     */
    public function __construct(
                                    AdmigasEdificios $condominio,
                                    QuerysJoinController $query,
                                    AdmigasRecibos $recibos,
                                    AdmigasEmpresas $empresa
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
         * Obtenemos los recibos del condominio
         */
        $recibos = $this->recibos
                    ->where('admigas_condominios_id', $id)
                    ->where('fecha_recibo', 'like', '2020-09%')
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
        return view('edificios::edit');
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

        $recibos = $this->recibos->where('admigas_condominios_id', $id)->take(1)->get();

        foreach ($recibos as $recibo )
        {

            //$this->createPdf( $recibo, 1 );

            $total_pagar = $recibo->cargos_adicionales + $recibo->adeudo_anterior + $recibo->importe +  $recibo->gasto_admin;

            Mail::to('mchlugo@hotmail.com')->send(new EnvioRecibos( $recibo, $total_pagar ));
        }


    }
    /**
     * Funcion para crear los PDF de los recibos
     */
    private function createPdf( $recibos, $opcion  )
    {
         /**
         * Obtenemos el convenio cie de la empresa
         */
        $convenio = $this->empresa->where( 'id', $this->empresa_id )->with('Cuentas')->first();
        $cie =  $convenio->Cuentas->convenio_cie;

        $url_recibo = file_get_contents( public_path('storage/recibo/recibo_2G-v2.png') );

        /**
         * opcion = 1 guardar en disco local
         * opcion = 2 mostrar en navegador
         */
        if ( $opcion == 1 )
        {
            $pdf = \PDF::loadView('edificios::recibos.show_mail', compact( 'recibos', 'url_recibo', 'cie' ) )->setPaper('A5')->output();
            Storage::put('\public\recibo_'.$recibos->admigas_departamentos_id.'.pdf', $pdf);
        }
        elseif( $opcion == 2 )
        {
            return  \PDF::loadView('edificios::recibos.show', compact( 'recibos', 'url_recibo', 'cie' ) )
                        ->setPaper('A5')
                        ->stream('archivo.pdf');
        }
    }
}
