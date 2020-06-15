<?php

namespace Modules\Edificios\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\QuerysJoinController;
/**
 * Modelos
 */
use App\AdmigasServicios;
use App\AdmigasCargosAdicionales;

class CargosAdicionalesController extends Controller
{
    private $query;
    private $servicios;
    private $cargos;
    /**
     * Constructor para obtener el id empresa
     * con base al usuario que esta usando la sesion
     */
    public function __construct(
            QuerysJoinController $query,
            AdmigasServicios $servicios,
            AdmigasCargosAdicionales $cargos
        )
        {
        $this->middleware(function ($request, $next) {
        $this->empresa_id = Auth::user()->admigas_empresas_id;

        return $next($request);
        });

        $this->query = $query;
        $this->servicios = $servicios;
        $this->cargos = $cargos;
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('edificios::cargosAdicionales.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create($id)
    {
        /**
         * Obtenemos los servicios de la empresa
         */
        $servicios = $this->servicios->active()->get();
        /**
         * Obtenemos los departamentos del condominios
         */
        $deptos = $this->query->queryRecibos( $id );

        return view('edificios::cargosAdicionales.create', compact( 'servicios', 'deptos' ));
        
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $j = 1;
        for ($i=0; $i < count( $request->dataForm ); $i++) { 
            
            $this->cargos->create([
                                    'plazo' => $request->plazo,
                                    'admigas_servicios_id' => $request->servicio,
                                    'admigas_departamentos_id' => $request->dataForm[ 'depto_'.$j]
                                ]);
            $j++;
        }
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
        $cargos = $this->cargos->where( 'admigas_departamentos_id', $id )->active()->with('Servicios')->get();

        return view('edificios::cargosAdicionales.show', compact('cargos'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return 'edificios::cargosAdicionales.edit';
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
