<?php

namespace Modules\Edificios\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use DB;
/**
 * Modelos
 */
use App\AdmigasEdificios;
use App\AdmigasDepartamentos;


class CapturaLecturaController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('edificios::captura.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create( $id )
    {
        /**
         * Obtenemos el registro selecionado
         */
        $condominio = AdmigasEdificios::where('id', $id)->get();
        /**
         * Obtenemos los departamentos del condominios
         */
        $deptos = DB::table('admigas_departamentos')
                        ->join( 'admigas_contacto_departamentos', 'admigas_departamentos.id', '=', 'admigas_contacto_departamentos.admigas_departamentos_id' )
                        ->join( 'admigas_medidores', 'admigas_departamentos.id', '=', 'admigas_medidores.admigas_departamentos_id' )
                        ->select(
                                    'admigas_departamentos.id AS departamento_id',
                                    'admigas_departamentos.numero_departamento',
                                    'admigas_contacto_departamentos.nombre',
                                    'admigas_contacto_departamentos.apellidos',
                                    'admigas_medidores.id AS medidor_id',
                                    'admigas_medidores.numero_serie',
                                    DB::raw("(SELECT admigas_lecturas_medidores.lectura FROM admigas_lecturas_medidores WHERE admigas_lecturas_medidores.admigas_medidores_id = admigas_medidores.id ORDER BY fecha_lectura DESC LIMIT 1 ) AS lectura_anterior")
                                )
                        ->where('admigas_departamentos.admigas_condominios_id', $id)
                        ->get();

        return view('edificios::captura.create', compact('condominio', 'deptos'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $datos = $this->procesar_lecturas($request->data);
        /**
         * Insertamos las nuevas lecturas
         */
        for ($i=0; $i < count( $datos ); $i++) {
            DB::table('admigas_lecturas_medidores')->insert([
                'lectura' => $datos[$i][0],
                'fecha_lectura' =>  $request->fecha_lectura,
                'admigas_departamentos_id' => $datos[$i][1],
                'admigas_medidores_id' => $datos[$i][2],
            ]);
        }
        /**
         * Redireccionamo
         */
        return redirect()->route('condominios.show', [$request->admigas_condominios_id]);

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('edificios::captura.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('edificios::captura.edit');
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

    private function procesar_lecturas( $lecturas )
    {
        for ($i=0; $i < count( $lecturas ); $i++) {
            $data[ $lecturas[$i]['name'].'_'.$i ] = $lecturas[$i]['value'];
        }

        return array_chunk( $data, 3 );
    }

}
