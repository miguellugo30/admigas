<?php

namespace Modules\Clientes\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Carbon\Carbon;
/**
 * Modelos
 */
use App\AdmigasMenus;
use App\AdmigasRecibos;

class ClientesController extends Controller
{
    private $recibos;

    public function __construct(Dispatcher $events,  AdmigasRecibos $recibos)
    {

        $this->middleware('auth');
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $categorias = AdmigasMenus::active()->where('admigas_cat_modulos_id',5)->orderBy('orden', 'asc')->get();

            foreach ($categorias as $v) {
                $event->menu->add( [
                    'text' => $v->nombre,
                    'id' => $v->id,
                    'url' => "",
                    'icon' => $v->icono,
                    'permiso' => $v->permiso,
                    'clase' => 'menu'
                ]);
            }
        });

        $this->recibos = $recibos;
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $modulo = 5;
        /**
         * Recuperamos los datos del cliente
         */
        $depto = \Auth::user()->Departamentos->first();
        /**
         * Contacto Depto
         */
        //$contacto = $depto->Contacto_Depto;
        /**
         * Recibos
         */
        $recibos = $depto->Recibos;
        /**
         * Recuperamos los ultimos 6 recibos
         */
        $ultimosRecibos = \DB::select('call SP_consumo_recibos( ' . \Auth::user()->Departamentos->first()->id . ' );');

        return view('clientes::index', compact('modulo', 'depto', 'recibos', 'ultimosRecibos'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('clientes::create');
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
        $consumos = \DB::select("call SP_consumo_recibos( $id )");
        Carbon::setlocale(config('app.locale'));

        $fechas = array();
        $litros = array();
        $data = array();

        foreach ($consumos as $consumo)
        {
            array_push($fechas, Carbon::parse($consumo->fecha_recibo)->translatedFormat('F') );
            array_push($litros, $consumo->litros );
        }

        $data['fechas'] = $fechas;
        $data['litros'] = $litros;

        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('clientes::edit');
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
    /**
     * Mostrar recibo
     */
    public function showRecibo($id)
    {
        $recibos = $this->recibos->where('id', $id)->get();
        dd( $recibos->Condominios );
        $url_recibo = file_get_contents(public_path('storage/recibo/recibo_2G-v2.png'));

        return  \PDF::loadView('edificios::recibos.show', compact('recibos', 'url_recibo', 'cie'))
            ->setPaper('A5')
            ->stream('archivo.pdf');
    }
}
