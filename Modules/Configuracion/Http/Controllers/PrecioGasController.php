<?php

namespace Modules\Configuracion\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Configuracion\Http\Requests\PrecioGasRequest;
use Carbon\Carbon;
/**
 * Modelos
 */
use App\AdmigasPrecioGas;

class PrecioGasController extends Controller
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
        $precios = AdmigasPrecioGas::empresa( $this->empresa_id )->active()->get();

        return view('configuracion::precio-gas.index', compact('precios'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('configuracion::precio-gas.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(PrecioGasRequest $request)
    {
        /**
         * Actualizamos todos los registros anteriores a inactivos
         */
        AdmigasPrecioGas::where( 'admigas_empresas_id', $this->empresa_id )
                        ->update([
                            'activo' => 0
                        ]);
        /**
         * Insertamos el nuevo registro
         */
        AdmigasPrecioGas::create([
            'precio' => $request->precio,
            'fecha' =>  Carbon::now(),
            'admigas_empresas_id' => $this->empresa_id
        ]);
        /**
         * Redirigimos a la ruta index
         */
        return redirect()->route('precio-gas.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('configuracion::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('configuracion::edit');
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
