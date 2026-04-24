<?php

namespace App\Http\Controllers;

use \DB;
/**
 * Modelos
 */
use App\AdmigasEmpresas;
use App\AdmigasDepartamentos;
use App\AdmigasSaldos;

class ActualizarSaldosController extends Controller
{
    private $empresas;
    private $deptos;
    private $saldo;

    /**
     * Constructor para obtener el id empresa
     * con base al usuario que esta usando la sesion
     */
    public function __construct(
        AdmigasEmpresas $empresas,
        AdmigasDepartamentos $deptos,
        AdmigasSaldos $saldo
    )
    {
        $this->empresas = $empresas;
        $this->deptos = $deptos;
        $this->saldo = $saldo;
    }

    public function updateSaldos()
    {
        $emp = $this->get_empresas();
        $this->get_condominios( $emp );

    }

    private function get_empresas()
    {
        return $this->empresas->select('id')->active()->get();
    }

    private function get_condominios($emp)
    {
        foreach ($emp as $e)
        {
            $condominios = DB::select("call SP_condominios_empresa( ".$e->id." )");
            $this->get_deptos( $condominios );
        }
    }

    private function get_deptos($condominios)
    {
        foreach ($condominios as $c)
        {
            $deptos = $this->deptos->where('admigas_condominios_id', $c->id)->get();
            $this->get_saldo_depto($deptos);

        }
    }

    private function get_saldo_depto($deptos)
    {
        foreach ($deptos as $d)
        {
            $saldo = DB::select("call SP_saldo_recibo('".$d->numero_referencia."')");

            $this->saldo
                ->where('admigas_departamentos_id', $d->id)
                ->update([
                    'referencia' => $d->numero_referencia,
                    'total_recibos' => round( $saldo[0]->total_recibos ),
                    'total_pagos' => round($saldo[0]->total_pagos),
                    'saldo' => (round( $saldo[0]->total_recibos)  - round( $saldo[0]->total_pagos ) )
                ]);
        }
    }
}
