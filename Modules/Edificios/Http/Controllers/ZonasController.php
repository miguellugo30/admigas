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
    private $zonas;
    /**
     * Constructor para obtener el id empresa
     * con base al usuario que esta usando la sesion
     */
    public function __construct(AdmigasZonas $zonas)
    {
        $this->middleware(function ($request, $next) {
            $this->empresa_id = Auth::user()->Empresas->first()->id;

            return $next($request);
        });

        $this->zonas = $zonas;
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
        $zonas = $this->zonas->empresa( $this->empresa_id )->active()->get();
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
        /**
         * Recuperamos la informacion de la zona
         */
        $zona = AdmigasZonas::where('id', $id)->first();

        return view('edificios::zonas.edit', compact('zona'));
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
         * Actualizamos el registro
         */
        AdmigasZonas::where( 'id', $id )
                    ->update([
                        'nombre' => $request->nombre,
                        'descripcion' => $request->descripcion
                    ]);

        return redirect()->route('zona.breadcrumb', ['id_zona' => $id]);

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
         /**
         * Actualizamos el registro
         */
        AdmigasZonas::where( 'id', $id )
                    ->update([
                        'activo' => 0
                    ]);
        /**
         * Redirigimos a la ruta index
         */
        return redirect()->route('zonas.index');

    }

    public function breadcrumb($id)
    {
        /**
         * Recuperamos la informacion de la zona
         */
        $zona = AdmigasZonas::where('id', $id)->get();
        /**
        * Redirigimos a la ruta index
        */
        return view('edificios::zonas.breadcrumd', compact('zona'));
    }
}
