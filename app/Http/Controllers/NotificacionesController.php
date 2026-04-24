<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
/**
 * Modelos
 */
use App\AdmigasCargosAdicionales;

class NotificacionesController extends Controller
{
    private $empresa_id;
    private $user;
    private $cargos;
    /**
     * Constructor para obtener el id empresa
     * con base al usuario que esta usando la sesion
     */
    public function __construct(AdmigasCargosAdicionales $cargos)
    {
        $this->middleware(function ($request, $next) {
            $this->empresa_id = Auth::user()->Empresas->first()->id;
            $this->user = Auth::user();

            return $next($request);
        });

        $this->cargos = $cargos;

    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return response()->json([
            'total' => $this->user->unreadNotifications->count()
        ]);

    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('creditocobranza::create');
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
    public function show()
    {
        $notificaciones = $this->user->unreadNotifications;

        return view('notificaciones.show', compact('notificaciones'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {

        $validar = $this->cargos->where([
                                        ['admigas_departamentos_id', '=', $id],
                                        ['admigas_servicios_id', '=', '2'],
                                        ['activo', '=', '1'],
                                    ])->exists();

        return response()->json([
                                'validar' => $validar
                            ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {

        if ( (int)$request->cargo == 1 ) {
            $this->cargos->create([
                'plazo' => 1,
                'admigas_servicios_id' => 2,
                'admigas_departamentos_id' => $id
            ]);
        }

        \DB::table('notifications')
                ->where('id', $request->notification_id)
                ->update(['read_at' => now()]);

         /**
         * Redirigimos a la ruta index
         */
        return redirect()->route('notificaciones.show', [$id]);


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
