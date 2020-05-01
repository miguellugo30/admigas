<?php

namespace Modules\Configuracion\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
/**
 * Modelos
 */
use App\AdmigasMensajes;
use Modules\Configuracion\Http\Requests\MensajesRequest;

class MensajesController extends Controller
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
         * Recuperamos todos los mensajes de una empresa
         */
        $mensajes = AdmigasMensajes::empresa( $this->empresa_id )->active()->get();

        return view('configuracion::mensajes.index', compact('mensajes'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('configuracion::mensajes.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(MensajesRequest $request)
    {
        /**
         * Creamos el nuevo mensaje
         */
        AdmigasMensajes::create([
                                    'nombre' => $request->nombre,
                                    'mensaje' =>  $request->mensaje,
                                    'admigas_empresas_id' => $this->empresa_id
                                ]);
        /**
         * Redirigimos a la ruta index
         */
        return redirect()->route('mensajes.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('configuracion::mensajes.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        /**
         * Obtenemos el registro ha editar
         */
        $mensaje = AdmigasMensajes::where( 'id', $id )->first();

        return view('configuracion::mensajes.edit', compact('mensaje'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(MensajesRequest $request, $id)
    {
         /**
         * Editamos el registro con los nuevos valores
         */
        AdmigasMensajes::where( 'id', $id )
                    ->update([
                                'nombre' => $request->nombre,
                                'mensaje'  => $request->mensaje
                            ]);
        /**
         * Redirigimos a la ruta index
         */
        return redirect()->route('mensajes.index');
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
        AdmigasMensajes::where( 'id', $id )
                   ->update([
                       'activo' => 0,
                   ]);
        /**
         * Redirigimos a la ruta index
         */
        return redirect()->route('mensajes.index');
    }
}
