<?php

namespace Modules\Edificios\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use App\Http\Controllers\QuerysJoinController;
use Illuminate\Support\Facades\Storage;
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

            $this->empresa_id = Auth::user()->Empresas->first()->id;

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
    public function show($id)
    {
        $condominio = $this->edificio->where('id', $id)->first();
        $dirCondomino = $condominio->nombre."_".$condominio->id;
        $fecha = date('Y-m');

        $this->validateRutaLocal($condominio->id, $fecha );
        /**
         * Obtenemos todos los directorios y buscamos el del condominios
         */
        $e = collect( Storage::cloud()->listContents('/', true) );
        $dir = $e->where('type', '=', 'dir')->where('name', '=', $dirCondomino)->first();
        if (!$dir)
        {
            return 'No existe el directorio de la empresa!';
        }
        /**
         * Obtenemos los directorios del condominio
         **/
        $e = collect(Storage::cloud()->listContents($dir['path'], false));
        $dirFotos = $e->where('type', '=', 'dir')->where('name', '=', 'Fotos')->first();
        $dirLecturas = $e->where('type', '=', 'dir')->where('name', '=', 'Lecturas')->first();
        if (!$dir)
        {
            return 'No existe el directorio de las fotos!';
        }
        if (!$dir)
        {
            return 'No existe el directorio de las lecturas!';
        }
        /**
         * Obtenemos los contenidos de los directorios
         */
        $fotos = collect(Storage::cloud()->listContents($dirFotos['path'], false));
        $lecturas = collect(Storage::cloud()->listContents($dirLecturas['path'], false));
        $rawData = Storage::cloud()->get($lecturas[0]['path']);
        /**
         * Descargamos el excel de las lecturas
         */
        Storage::put('/' . $this->empresa_id . '\/' . $condominio->id . '\/' . $fecha . '\/' . $lecturas[0]['name'], $rawData);
        /**
         * Descargamos las fotos de las lecturas
         */
        /*
        foreach ($fotos as  $foto) {
            echo $foto['name'] . "<br>";
            $rawData = Storage::cloud()->get($foto['path']);
            Storage::put('/' . $this->empresa_id . '\/' . $condominio->id. '\/' . $fecha . '\/' . $foto['name'], $rawData);

        }
        */
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

    public function validateRutaLocal( $dirCondomino, $fecha )
    {
        /**
         * Validamos que exista la carpeta de la empresa
         */
        if (!Storage::exists('/'.$this->empresa_id) ) {
            Storage::makeDirectory('/'.$this->empresa_id);
        }
        /**
         * Validamos que exista la carpeta del condominio
         */
        if ( !Storage::exists('/' . $this->empresa_id . '\/' . $dirCondomino) ) {
            Storage::makeDirectory('/' . $this->empresa_id . '\/' . $dirCondomino);
        }
        /**
         * Validamos que exista la fecha de la lectura
         */
        if (!Storage::exists('/' . $this->empresa_id . '\/' .$dirCondomino . '\/' . $fecha)) {
            Storage::makeDirectory('/' . $this->empresa_id. '\/' . $dirCondomino . '\/' . $fecha);
        }
    }

}
