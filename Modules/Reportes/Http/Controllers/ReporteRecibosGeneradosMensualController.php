<?php

namespace Modules\Reportes\Http\Controllers;

use App\Exports\ReporteRecibosGeneradosExport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use DB;

class ReporteRecibosGeneradosMensualController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('reportes::recibosGeneradosMensual.index');
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
        $data =  DB::select("call SP_reporte_recibos_generados( '$request->desde', '$request->hasta' )");
        return view('reportes::recibosGeneradosMensual.show', compact('data'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('reportes::show');
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
        $data =  DB::select("call SP_reporte_recibos_generados( '$fecha_inicial', '$fecha_final' )");
        return (new ReporteRecibosGeneradosExport($data))->download('reporte_recibos_generados.xlsx');
    }

}
