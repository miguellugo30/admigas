<?php

namespace Modules\Configuracion\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Configuracion\Http\Requests\ServiciosRequest;
/**
 * Modelos
 */
use App\AdmigasServicios;

class ServiciosController extends Controller
{
    private $empresa_id;
    /**
     * Constructor para obtener el id empresa
     * con base al usuario que esta usando la sesion
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->empresa_id = Auth::user()->Empresas->first()->id;

            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        /**
         * Obtenemos todos los servicios activos
         */
        $servicios = AdmigasServicios::empresa( $this->empresa_id )->active()->get();

        return view('configuracion::servicios.index', compact('servicios'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('configuracion::servicios.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(ServiciosRequest $request)
    {
        /**
         * Creamos el nuevo mensaje
         */
        AdmigasServicios::create([
            'nombre' => $request->nombre,
            'descripcion' =>  $request->descripcion,
            'costo' =>  $request->costo,
            'admigas_empresas_id' => $this->empresa_id
        ]);
        /**
         * Redirigimos a la ruta index
         */
        return redirect()->route('servicios.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('configuracion::servicios.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        /**
         * Obtenemos el registro a editar
         */
        $servicio = AdmigasServicios::where( 'id', $id )->first();

        return view('configuracion::servicios.edit', compact( 'servicio' ));
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
         * Creamos el nuevo mensaje
         */
        AdmigasServicios::where( 'id', $id )
                        ->update([
                                    'nombre' => $request->nombre,
                                    'descripcion' =>  $request->descripcion,
                                    'costo' =>  $request->costo
                                ]);
        /**
         * Redirigimos a la ruta index
         */
        return redirect()->route('servicios.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        /**
         * Desactivamos el registro seleccionado
         */
        AdmigasServicios::where( 'id', $id )
                        ->update([
                            'activo' => 0,
                        ]);
        /**
         * Redirigimos a la ruta index
         */
        return redirect()->route('servicios.index');
    }
}
