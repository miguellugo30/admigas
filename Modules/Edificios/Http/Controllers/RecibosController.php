<?php

namespace Modules\Edificios\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\QuerysJoinController;
use Illuminate\Support\Facades\Mail;
/**
 * Modelos
 */
use App\AdmigasRecibos;
use App\AdmigasEdificios;
use App\Mail\EnvioRecibos;

class RecibosController extends Controller
{
    private $empresa_id;
    private $condominio;
    private $query;
    private $recibos;
    /**
     * Constructor para obtener el id empresa
     * con base al usuario que esta usando la sesion
     */
    public function __construct(
                                    AdmigasEdificios $condominio,
                                    QuerysJoinController $query,
                                    AdmigasRecibos $recibos
                                )
    {
        $this->middleware(function ($request, $next) {
            $this->empresa_id = Auth::user()->admigas_empresas_id;

            return $next($request);
        });

        $this->condominio = $condominio;
        $this->query = $query;
        $this->recibos = $recibos;
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
        $recibos = $this->recibos->where('admigas_condominios_id', $id)->where('fecha_recibo', 'like', '2020-07%')->take(2)->get();

        $pdf = app('dompdf.wrapper');

        //$url_recibo = file_get_contents( \Storage::url('recibo/recibo_2G.jpg') );
        $url_recibo = file_get_contents( public_path('storage/recibo/recibo_2G-v2.jpeg') );

        return  \PDF::loadView('edificios::recibos.show', compact( 'recibos', 'url_recibo' ) )
                    ->setPaper('A5')
                    ->stream('archivo.pdf');

        //return $pdf->stream('archivo.pdf');
        //return $pdf->download('mi-archivo.pdf');
        //return view('edificios::recibos.show', compact( 'recibos', 'url_recibo' ) );
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
    public function destroy($id)
    {
        //
    }

    public function sendRecibos($id)
    {

        $recibos = $this->recibos->where('admigas_condominios_id', $id)->get();

        foreach ($recibos as $recibo )
        {

            Mail::to('ingmchlugo@gmail.com')->send(new EnvioRecibos( $recibo ));
        }


    }
}