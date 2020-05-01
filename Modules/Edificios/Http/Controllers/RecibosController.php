<?php

namespace Modules\Edificios\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use DB;
/**
 * Modelos
 */
use App\AdmigasPrecioGas;
use App\AdmigasEdificios;

class RecibosController extends Controller
{
    private $empresa_id;
    /**
     * Constructor para obtener el id empresa
     * con base al usuario que esta usando la sesion
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->empresa_id = Auth::user()->admigas_empresas_id;

            return $next($request);
        });
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
         * Recuperamos el precio del gas de la empresa
         */
        $precio = AdmigasPrecioGas::empresa( $this->empresa_id )->active()->first();
        /**
         * Obtenemos el registro selecionado
         */
        $condominio = AdmigasEdificios::where('id', $id)->get();
        /**
         * Obtenemos los departamentos del condominios
         */
        $deptos = DB::table('admigas_departamentos')
                        ->join( 'admigas_contacto_departamentos', 'admigas_departamentos.id', '=', 'admigas_contacto_departamentos.admigas_departamentos_id' )
                        ->join( 'admigas_medidores', 'admigas_departamentos.id', '=', 'admigas_medidores.admigas_departamentos_id' )
                        ->select(
                                    'admigas_departamentos.id AS departamento_id',
                                    'admigas_departamentos.numero_departamento',
                                    'admigas_contacto_departamentos.nombre',
                                    'admigas_contacto_departamentos.apellidos',
                                    'admigas_medidores.id AS medidor_id',
                                    'admigas_medidores.numero_serie',
                                    DB::raw("(SELECT admigas_lecturas_medidores.lectura FROM admigas_lecturas_medidores WHERE admigas_lecturas_medidores.admigas_medidores_id = admigas_medidores.id ORDER BY fecha_lectura DESC LIMIT 1,2 ) AS lectura_anterior"),
                                    DB::raw("(SELECT admigas_lecturas_medidores.lectura FROM admigas_lecturas_medidores WHERE admigas_lecturas_medidores.admigas_medidores_id = admigas_medidores.id ORDER BY fecha_lectura DESC LIMIT 1 ) AS lectura_actual")
                                )
                        ->where('admigas_departamentos.admigas_condominios_id', $id)
                        ->get();

        return view('edificios::recibos.create', compact('condominio', 'deptos', 'precio'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('edificios::show');
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
}
