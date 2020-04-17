<?php

namespace Modules\Configuracion\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
/**
 * Modelos
 */
use App\AdmigasEmpresas;
use Modules\Configuracion\Http\Requests\EmpresasRequest;

class EmpresasController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        /**
         * Obtenemos las empresas activas
         */
        $empresas = AdmigasEmpresas::active()->get();

        return view('configuracion::empresas.index', compact('empresas'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('configuracion::empresas.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(EmpresasRequest $request)
    {
        /**
         * Creamos el nuevo registro
         */
        AdmigasEmpresas::create(  $request->all() );
        /**
         * Redirigimos a la ruta index
         */
        return redirect()->route('empresas.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('configuracion::empresas.show');
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
        $empresa = AdmigasEmpresas::where( 'id', $id )->get()->first();

        return view('configuracion::empresas.edit', compact('empresa'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(EmpresasRequest $request, $id)
    {
        /**
         * Actualizamos el registro
         */
        AdmigasEmpresas::where( 'id', $id )
                        ->update([
                            'razon_social' => $request->razon_social,
                            'rfc' => $request->rfc,
                            'calle' => $request->calle,
                            'numero' => $request->numero,
                            'colonia' => $request->colonia,
                            'municipio' => $request->municipio,
                            'cp' => $request->cp,
                        ]);
        /**
         * Redirigimos a la ruta index
         */
        return redirect()->route('empresas.index');
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
        AdmigasEmpresas::where( 'id', $id )
                        ->update([
                            'activo' => 0,
                        ]);
        /**
         * Redirigimos a la ruta index
         */
        return redirect()->route('empresas.index');
    }
}
