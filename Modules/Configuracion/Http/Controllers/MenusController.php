<?php

namespace Modules\Configuracion\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Configuracion\Http\Requests\MenusRequest;
use DB;
/**
 * Modelos
 */
use App\AdmigasMenus;
use App\AdmigasCatModulos;

class MenusController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        /**
         * Obtenemos los menus dados de alta
         */
        $menus = AdmigasMenus::active()->with('Modulos')->orderBy('admigas_cat_modulos_id', 'desc')->get();

        return view('configuracion::menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        /**
         * Obtenemos los modulos del sistema
         */
        $modulos = AdmigasCatModulos::active()->get();

        return view('configuracion::menus.create', compact('modulos'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(MenusRequest $request)
    {
        /**
         * Creamos los permisos para el nuevo menu
         */
        $permisos = array( 'view', 'create', 'edit', 'delete' );
        for ($i=0; $i < count( $permisos ); $i++)
        {
            DB::table('permissions')->insert([
                                                'name' => $permisos[$i]." ".strtolower($request->nombre),
                                                'guard_name' => 'web'
                                            ]);
        }
        /**
         * Creamos el nuevo menu
         */
        AdmigasMenus::create([
                                'nombre' => $request->nombre,
                                'url' => '/'.strtolower( $request->nombre),
                                'icono' => $request->icono,
                                'permiso' => 'view '.strtolower($request->nombre),
                                'admigas_cat_modulos_id' => $request->modulo,
                            ]);
        /**
         * Redirigimos a la ruta index
         */
        return redirect()->route('menus.index');

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('configuracion::menus.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        /**
         * Obtenemos los modulos del sistema
         */
        $modulos = AdmigasCatModulos::active()->get();
        /**
         * Obtenemos el registro a editar
         */
        $menu = AdmigasMenus::where('id', (int)$id)->get()->first();

        return view('configuracion::menus.edit', compact('modulos', 'menu'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(MenusRequest $request, $id)
    {
        /**
         * Editamos el registro con los nuevos valores
         */
        AdmigasMenus::where( 'id', $id )
                    ->update([
                                'nombre' => $request->nombre,
                                'icono'  => $request->icono,
                                'admigas_cat_modulos_id' => $request->modulo
                            ]);
        /**
         * Redirigimos a la ruta index
         */
        return redirect()->route('menus.index');
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
        AdmigasMenus::where( 'id', $id )
                   ->update([
                       'activo' => 0,
                   ]);
        /**
         * Redirigimos a la ruta index
         */
        return redirect()->route('menus.index');
    }
}
