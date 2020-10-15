<?php

namespace Modules\Clientes\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
/**
 * Modelos
 */
use App\AdmigasMenus;
use App\AdmigasRecibos;
use App\AdmigasContactoDepartamentos;
use App\AdmigasDepartamentos;
use App\AdmigasEmpresas;

class ClientesController extends Controller
{
    private $recibos;
    private $departamentos;
    private $contactoDepartamento;
    private $empresas;

    public function __construct(
        Dispatcher $events,
        AdmigasRecibos $recibos,
        AdmigasDepartamentos $departamentos,
        AdmigasContactoDepartamentos $contactoDepartamento,
        AdmigasEmpresas $empresas
        )
    {

        $this->middleware('auth');
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {

            $event->menu->add([
                'text' => 'Inicio',
                'id' => 0,
                'url' => "/clientes",
                'icon' => 'fas fa-home',
                'permiso' => 'view inicio',
                'clase' => ''
            ]);

            $categorias = AdmigasMenus::active()->where('admigas_cat_modulos_id',5)->orderBy('orden', 'asc')->get();

            foreach ($categorias as $v) {
                $event->menu->add( [
                    'text' => $v->nombre,
                    'id' => $v->id,
                    'url' => "#",
                    'icon' => $v->icono,
                    'permiso' => $v->permiso,
                    'clase' => 'menu'
                ]);
            }
        });

        $this->recibos = $recibos;
        $this->departamentos = $departamentos;
        $this->contactoDepartamento = $contactoDepartamento;
        $this->empresas = $empresas;
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
        $depto =  $this->departamentos->find( \Auth::user()->Departamentos->first()->id );
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
        /**
         * Creamos el contacto del departamento
         */
        $this->contactoDepartamento->where('admigas_departamentos_id', $request->departamento_id)
            ->update([
                'nombre' => $request->nombre,
                'apellido_paterno' =>  $request->apellido_paterno,
                'apellido_materno' =>  $request->apellido_materno,
                'telefono' => $request->telefono,
                'celular' => $request->celular,
                'correo_electronico' => $request->correo_electronico
            ]);
    }
    public function mi_cuenta(Request $request)
    {
        /**
         * Recuperamos los datos del cliente
         */
        $depto =  $this->departamentos->find($request->departamento_id);

        return view('clientes::mi_cuenta', compact('depto'));
    }
    public function estado_cuenta(Request $request)
    {
        $estado_cuenta = \DB::select("call SP_estado_cuenta( $request->departamento_id )");

        return view('clientes::estado_cuenta', compact('estado_cuenta'));
    }
    /**
     * Mostrar recibo
     */
    public function showRecibo($id, $option)
    {
        /**
         * Recuperamos los datos del cliente
         */
        $depto =  $this->departamentos->find(\Auth::user()->Departamentos->first()->id);
        /**
         * Obtenemos el convenio cie de la empresa
         */
        $convenio = $this->empresas->where('id', $depto->condominios->Unidades->Zonas->admigas_empresas_id)->first();
        $cie =  $convenio->Cuentas->convenio_cie;
        $recibos = $this->recibos->where('id', $id)->get();

        $url_recibo = file_get_contents(public_path('storage/recibo/recibo_2G-v2.png'));

        if ( $option == 1 ) {
            return \PDF::loadView('edificios::recibos.show', compact('recibos', 'url_recibo', 'cie'))
                ->setPaper('A5')
                ->stream('archivo.pdf');
        } else {
            return \PDF::loadView('edificios::recibos.show', compact('recibos', 'url_recibo', 'cie'))->setPaper('A5')->download('recibo_'.$recibos->first()->fecha_recibo.'.pdf');
            //Storage::put('\public\recibo_' . $depto->id . '.pdf', $pdf);
        }
    }
}
