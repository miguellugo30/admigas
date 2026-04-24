<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\donwloadFotosLecturasController;

/**
 * Resource
 */
use App\Http\Resources\EdificiosResource;
use App\Http\Resources\DepartamentosResource;
use App\Http\Resources\ContactoDepartamentosResource;
/**
 * Modelos
 */
use App\AdmigasEdificios;
use App\AdmigasContactoDepartamentos;
use App\AdmigasDepartamentos;
use App\AdmigasLecturasMedidores;
use App\AdmigasMedidores;

class APIMobile extends Controller
{
    private $edificios;
    private $departamentos;
    private $lecturasMedidores;
    private $path;
    private $medidores;

    public function __construct(
            AdmigasEdificios $edificios,
            AdmigasDepartamentos $departamentos,
            AdmigasLecturasMedidores $lecturasMedidores,
            donwloadFotosLecturasController $path,
            AdmigasMedidores $medidores
        ) {
        $this->edificios = $edificios;
        $this->departamentos = $departamentos;
        $this->lecturasMedidores = $lecturasMedidores;
        $this->path = $path;
        $this->medidores = $medidores;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return (EdificiosResource::collection( $this->edificios->active()->get() ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $date = date('m-Y');
        $dateComplete = date('Y-m-d');

        $departamento = $this->departamentos->find($request->departamento_id);
        $medidor = $this->medidores->where('admigas_departamentos_id',$request->departamento_id)->first();
        /**
         * Validamos que exista la ruta donde se guardara la foto
         */
        $this->path->validateRutaLocal($departamento->admigas_condominios_id, $date, '1');
        /**
         * Creamos el nombre de la imagen
         */
        //$name = "1039_101.jpeg";
        $name = $request->departamento_id . "_" . $request->num_depto . ".jpeg";
        /**
         * Formateamos la imagen recibida y se guarda
         */
        try {
            $image = $request->foto;  // your base64 encoded
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            Storage::put('/1\/' . $departamento->admigas_condominios_id. '\/' . $date . '\/' . $name, base64_decode($image));


            $this->lecturasMedidores->create([
                'lectura' => $request->lectura,
                'fecha_lectura' => $dateComplete,
                'admigas_departamentos_id' => $request->departamento_id,
                'admigas_medidores_id' => $medidor->id,
            ]);

            return response()->json([
                'message' => 'Se ha guardado correctamente las lecturas',
                'data' => [],
                'success' => true
            ]);

        } catch (\Throwable $th) {

            \Log::error('Error al guardar las lecturas desde la API:', ['message' => $th]);

            return response()->json([
                'message' => 'Se ha tenido un error al guardar lecturas',
                'data' => [],
                'success' => false
            ]);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return ( DepartamentosResource::collection( $this->departamentos->condominio($id)->active()->get() )  );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
