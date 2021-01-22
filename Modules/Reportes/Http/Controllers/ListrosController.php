<?php

namespace Modules\Reportes\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReporteLitrosExport;

class ListrosController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('reportes::litros.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('reportes::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data =  DB::select("call SP_reporte_litros( '$request->desde', '$request->hasta' )");
        return view('reportes::litros.show', compact('data'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {

        return view('reportes::edit');
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

    public function export($fecha_inicial, $fecha_final)
    {
        $data =  DB::select("call SP_reporte_litros( '$fecha_inicial', '$fecha_final' )");
        $data = $this->processData( $data );
        return (new ReporteLitrosExport($data))->download('reporte_litros.xlsx');
    }

    public function processData($data)
    {
        $result = array();
        foreach ($data as $e)
        {
            $litros = ( $e->m3 * $e->factor ) * $e->precio_litro;
            $e->litros = number_format($litros, 2);
            $e->m3 = number_format($e->m3, 2);
            unset( $e->factor );
            unset( $e->precio_litro );
            array_push($result, $e);
        }
        return $result;
    }
}
