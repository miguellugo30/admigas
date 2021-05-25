<?php

namespace Modules\Edificios\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use App\Http\Controllers\QuerysJoinController;
use Illuminate\Support\Facades\Log;
use DB;
use App\Http\Controllers\donwloadFotosLecturasController;

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
    private $donwload;
    /**
     * Constructor para obtener el id empresa
     * con base al usuario que esta usando la sesion
     */
    public function __construct(
                                    AdmigasEdificios $edificio,
                                    QuerysJoinController $query,
                                    AdmigasLecturistas $lecturistas,
                                    donwloadFotosLecturasController $donwload
                                    )
    {
        $this->middleware(function ($request, $next) {

            $this->empresa_id = Auth::user()->Empresas->first()->id;

            return $next($request);
        });

        $this->edificio = $edificio;
        $this->donwload = $donwload;
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
        if ( $datos == 'error' )
        {
            return response()->json([
                                        'message'      =>  'The given data was invalid.',
                                        'errors'   =>  [
                                                            'lectura_actual' => [ 'El campo Lectura Actual es obligatorio' ]
                                                        ]
                                    ], 422);
        }
        else
        {

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
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id){}
    public function syncData(Request  $request)
    {

        $fecha_lectura = $request->fecha_lectura;

        $condominio = $this->edificio->where('id', $request->admigas_condominios_id)->first();
        /**
         * Descargamos las fotos
         */
        $this->donwload->donwloadFotos( $condominio, $this->empresa_id , date('m-Y', strtotime($request->fecha_lectura)));
        /**
         * Descargamos las lecturas y obtenemos la informacion
         */
        if ( !$this->donwload->importLecturas($condominio, $this->empresa_id, date('m-Y', strtotime($request->fecha_lectura))) ) {
            Log::error('No se encuentra el archivo o no se descargo correctamente');
            return Response::json(array(
                'code'      =>  401,
                'message'   =>  'No se encuentra el archivo o no se descargo correctamente'
            ), 401);
        } else {
            $data = $this->donwload->importLecturas($condominio, $this->empresa_id, date('m-Y', strtotime($request->fecha_lectura)));
        }
        /**
         * Obtenemos los lecturistas de la empresa
         */
        $lecturistas = $this->lecturistas->empresa($this->empresa_id)->active()->get();
        /**
         * Obtenemos los departamentos del condominios
         */
        $deptos = $this->query->queryCapturaLecturas($request->admigas_condominios_id);

        $empresa_id = $this->empresa_id;

        return view('edificios::captura.create_sync', compact('condominio', 'deptos', 'lecturistas', 'data', 'empresa_id', 'fecha_lectura'));
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
    public function updateExcel(Request $request)
    {
        $condominio = $this->edificio->where('id', $request->admigas_condominios_id)->get();

        $this->donwload->createDirectoriesCloud($condominio);

    }

    public function syncFotosInicales(Request $request)
    {
        $condominio = $this->edificio->where('id', $request->admigas_condominios_id)->first();
        $fecha = explode('/', $request->fecha_lectura);

        //dd($condominio);
        Log::info($condominio->nombre);

        $this->donwload->donwloadFotos($condominio, $this->empresa_id, $fecha[1]."-".$fecha[2], 'Iniciales');

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
        for ($i=0; $i < count( $lecturas ); $i++)
        {
            if ($lecturas[$i]['value'] != '')
            {
                $data[ $lecturas[$i]['name'].'_'.$i ] = $lecturas[$i]['value'];
            }
            else
            {
                return 'error';
                exit;
            }
        }
        return array_chunk( $data, 3 );
    }
}
