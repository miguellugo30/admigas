<?php

namespace Modules\Edificios\Http\Controllers;

use App\AdmigasUnidades;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Edificios\Http\Requests\ZonasRequest;
/**
 * Modelos
 */
Use App\AdmigasZonas;

class ZonasController extends Controller
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
        /**
         * Obtenemos todas las zonas activas
         */
        $zonas = AdmigasZonas::empresa( $this->empresa_id )->active()->get();

        return view('edificios::zonas.index', compact('zonas'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('edificios::zonas.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(ZonasRequest $request)
    {
        /**
         * Creamos el nuevo registro
         */
        AdmigasZonas::create([
                                'nombre' => $request->nombre,
                                'descripcion' =>  $request->descripcion,
                                'admigas_empresas_id' => $this->empresa_id
                            ]);
        /**
        * Redirigimos a la ruta index
        */
        return redirect()->route('zonas.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        /**
         * Recuperamos la informacion de la zona
         */
        $zona = AdmigasZonas::where('id', $id)->get();
        /**
         * Mostramos las unidades de la zona
         */
        $unidades = AdmigasUnidades::active()->zona( $id )->get();

        return view('edificios::unidades.index', compact('unidades', 'zona'));
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
