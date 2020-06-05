<?php

namespace Modules\Edificios\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use App\Http\Controllers\QuerysJoinController;
use DB;
/**
 * Modelos
 */
use App\AdmigasEdificios;
use App\AdmigasLecturistas;

class CapturaLecturaController extends Controller
{
    private $empresa_id;
    private $edificio;
    private $query;
    private $lecturistas;
    /**
     * Constructor para obtener el id empresa
     * con base al usuario que esta usando la sesion
     */
    public function __construct(AdmigasEdificios $edificio, QuerysJoinController $query, AdmigasLecturistas $lecturistas)
    {
        $this->middleware(function ($request, $next) {
            $this->empresa_id = Auth::user()->admigas_empresas_id;

            return $next($request);
        });

        $this->edificio = $edificio;
        $this->query = $query;
        $this->lecturistas = $lecturistas;
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('edificios::captura.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create( $id )
    {
        /**
         * Obtenemos los lecturistas de la empresa
         */
        $lecturistas = $this->lecturistas->empresa( $this->empresa_id )->active()->get();
        /**
         * Obtenemos el registro selecionado
         */
        $condominio = $this->edificio->where('id', $id)->get();
        /**
         * Obtenemos los departamentos del condominios
         */
        $deptos = $this->query->queryCapturaLecturas( $id );

        return view('edificios::captura.create', compact('condominio', 'deptos', 'lecturistas'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $datos = $this->procesar_lecturas($request->data);
        /**
         * Insertamos las nuevas lecturas
         */
        for ($i=0; $i < count( $datos ); $i++) {
            DB::table('admigas_lecturas_medidores')->insert([
                'lectura' => $datos[$i][0],
                'fecha_lectura' =>  $request->fecha_lectura,
                'admigas_departamentos_id' => $datos[$i][1],
                'admigas_medidores_id' => $datos[$i][2],
            ]);
        }
        /**
         * Redireccionamo
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
        return view('edificios::captura.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('edificios::captura.edit');
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

    private function procesar_lecturas( $lecturas )
    {
        for ($i=0; $i < count( $lecturas ); $i++) {
            $data[ $lecturas[$i]['name'].'_'.$i ] = $lecturas[$i]['value'];
        }

        return array_chunk( $data, 3 );
    }

}
