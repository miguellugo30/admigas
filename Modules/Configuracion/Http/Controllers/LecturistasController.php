<?php

namespace Modules\Configuracion\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Configuracion\Http\Requests\LecturistasRequest;
/**
 * Modelos
 */
use App\AdmigasLecturistas;


class LecturistasController extends Controller
{
    private $empresa_id;
    private $lecturistas;
    /**
     * Constructor para obtener el id empresa
     * con base al usuario que esta usando la sesion
     */
    public function __construct(AdmigasLecturistas $lecturistas)
    {
        $this->middleware(function ($request, $next) {
            $this->empresa_id = Auth::user()->admigas_empresas_id;

            return $next($request);
        });

        $this->lecturistas = $lecturistas;
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $lecturistas = $this->lecturistas->empresa( $this->empresa_id )->active()->get();

        return view('configuracion::lecturistas.index', compact('lecturistas'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('configuracion::lecturistas.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(LecturistasRequest $request)
    {
        /**
         * Creamos el nuevo mensaje
         */
        $this->lecturistas->create([
            'nombre' => $request->nombre,
            'apellidos' =>  $request->apellidos,
            'telefono' =>  $request->telefono,
            'celular' =>  $request->celular,
            'correo_electronico' =>  $request->correo_electronico,
            'admigas_empresas_id' => $this->empresa_id
        ]);
        /**
        * Redirigimos a la ruta index
        */
        return redirect()->route('lecturistas.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('configuracion::lecturistas.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $lecturista = $this->lecturistas->where( 'id', $id )->first();

        return view('configuracion::lecturistas.edit', compact('lecturista'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(LecturistasRequest $request, $id)
    {
        /**
         * Creamos el nuevo mensaje
         */
        $this->lecturistas->where( 'id', $id )
        ->update([
            'nombre' => $request->nombre,
            'apellidos' =>  $request->apellidos,
            'telefono' =>  $request->telefono,
            'celular' =>  $request->celular,
            'correo_electronico' =>  $request->correo_electronico
        ]);
        /**
        * Redirigimos a la ruta index
        */
        return redirect()->route('lecturistas.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        /**
         * Creamos el nuevo mensaje
         */
        $this->lecturistas->where( 'id', $id )
        ->update([
            'activo' => 0,
        ]);
        /**
        * Redirigimos a la ruta index
        */
        return redirect()->route('lecturistas.index');
    }
}
