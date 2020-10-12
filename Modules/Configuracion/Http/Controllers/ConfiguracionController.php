<?php

namespace Modules\Configuracion\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
/**
 * Modelos
 */
use App\AdmigasMenus;

class ConfiguracionController extends Controller
{
    public function __construct(Dispatcher $events)
    {

        $this->middleware('auth');

        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $menus = AdmigasMenus::active()->where('admigas_cat_modulos_id', 4)->orderBy('orden', 'asc')->get();
            foreach ($menus as $v) {
                $event->menu->add([
                    'text' => $v->nombre,
                    'id' => $v->id,
                    'url' => $v->url,
                    'icon' => $v->icono,
                    'permiso' => $v->permiso,
                    'clase' => 'menu',
                ]);
            }

        });
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        /**
         * Definimos el modulo del cliente
         */
        $modulo = 4;

        return view('configuracion::index', compact('modulo'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('configuracion::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
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
