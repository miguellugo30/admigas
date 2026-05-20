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
        $lecturas = $request->input('lecturas');
        $edificio_id = $request->input('edificio_id');

        try {

            foreach ($lecturas as $lectura) {

                $departamento_id = $lectura['departamento_id'];
                $base64Image = $lectura['lectura_foto'];
                $lecturaActual = $lectura['lectura_actual'];

                $departamento = $this->departamentos->find($departamento_id);
                $medidor = $this->medidores->where('admigas_departamentos_id',$departamento_id)->first();
                /**
                 * Validamos que exista la ruta donde se guardara la foto
                 */
                $this->path->validateRutaLocal($edificio_id, $date, '1');
                /**
                 * Creamos el nombre de la imagen
                 */
                $name = $departamento_id . "_" . $departamento->numero_departamento . ".jpeg";

                if ($base64Image) {

                    // 2. Decodificar
                    $imagenDecodificada = base64_decode($base64Image);

                    $rutaStorage = "/1/{$departamento->admigas_condominios_id}/{$date}/{$name}";
                    // Lo guardamos en storage/app/public/lecturas
                   Storage::disk('public')->put($rutaStorage, $imagenDecodificada);

                }


                $this->lecturasMedidores->create([
                    'lectura' => $lecturaActual,
                    'fecha_lectura' => $dateComplete,
                    'admigas_departamentos_id' => $departamento_id,
                    'admigas_medidores_id' => $medidor->id,
                ]);
            }

            return response()->json([
                'message' => 'Se ha guardado correctamente las lecturas',
                'data' => [],
                'success' => true
            ]);

        } catch (\Throwable $th) {

            \Log::error('Error al guardar las lecturas desde la API:', ['message' => $th->getMessage(), 'line' => $th->getLine()]);
            return response()->json([
                'message' => 'Se ha tenido un error al guardar lecturas',
                'data' => [],
                'success' => false
            ], 500); // Es buena práctica regresar el código HTTP 500 cuando hay un fallo

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
