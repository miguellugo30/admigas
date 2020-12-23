<?php

namespace App\Http\Controllers;

use \DB;
use Carbon\Carbon;
use App\Mail\DeptoFechaPorVencer;
use Illuminate\Support\Facades\Mail;
use App\Notifications\FechaLimiteAVencer;
use Illuminate\Support\Facades\Notification;
/**
 * Modelos
 */
use App\AdmigasEmpresas;
use App\AdmigasRecibos;
use App\Notifications\FechaVencida;
use App\User;

class DeptosFechaLimite extends Controller
{
    private $empresas;
    private $recibos;
    private $user;
    /**
     * Constructor para obtener el id empresa
     * con base al usuario que esta usando la sesion
     */
    public function __construct(
        AdmigasEmpresas $empresas,
        AdmigasRecibos $recibos,
        User $user
    )
    {
        $this->empresas = $empresas;
        $this->recibos = $recibos;
        $this->user = $user;
    }

    public function DeptosProximoVencer()
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
            $this->get_recibos( $condominios );
        }
    }

    private function get_recibos($condominios)
    {
        foreach ($condominios as $c)
        {
            /**
             * Obtenemos la fecha del ultimo recibo
             */
            $fecha = collect( DB::select("call SP_fecha_ultimo_recibo( $c->id )") );
            foreach ($fecha as $f) {
                $date = $f->fecha_recibo;
            }
            /**
             * Obtenemos el ultimo recibo
             */
            $recibos = $this->recibos
                        ->where('admigas_condominios_id', $c->id)
                        ->where('fecha_recibo',$date )
                        ->active()
                        ->get();

            $this->validacion_dias( $recibos );
        }
    }

    public function validacion_dias($recibos)
    {
        foreach ($recibos as $recibo )
        {
            /**
             * Obtenemos el total a pagar
             */
            $saldo = \DB::select("call SP_saldo_recibo( '$recibo->referencia' )");
            $total_pagar = number_format( ( round($saldo[0]->total_recibos) - round($saldo[0]->total_pagos) ),2 );
            /**
             * Calculamos la diferencia en de dias
             */
            $diff = $this->diffDias( $recibo->fecha_limite_pago );
            $this->notificacion( $total_pagar, $diff, $recibo );
        }
    }

    private function notificacion($total_pagar, $diff, $recibo)
    {
        $user = $this->user->find(1);
        if ( $total_pagar > 0 && $diff == 2 )
        {
            /**
             * Obtenemos el correo del condominio
             */
            //Mail::to( $recibo->Departamento->Contacto_Depto->correo_electronico )->send(new DeptoFechaPorVencer( $recibo->condomino ));
            Mail::to('mchlugo@hotmail.com')->send(new DeptoFechaPorVencer( $recibo->condomino ));
            /**
             * Generamos la notificacion en la base de datos
             */
            Notification::send($user,new FechaLimiteAVencer( $recibo->numero_departamento, $recibo->condominio, $recibo->unidad, $recibo->admigas_departamentos_id ));
        }
        elseif ( $total_pagar > 0 && $diff == 0 )
        {
            Notification::send($user, new FechaVencida( $recibo->numero_departamento, $recibo->condominio, $recibo->unidad, $recibo->admigas_departamentos_id ));
        }
    }

    private function diffDias($fecha_limite)
    {
        if ( $fecha_limite >  date('Y-m-d') )
        {
            $fecha_limite = Carbon::createFromFormat( 'Y-m-d', $fecha_limite );
            $fecha_actual = Carbon::createFromFormat( 'Y-m-d', date('Y-m-d') );

            return $fecha_actual->diffInDays( $fecha_limite );
        }
        return 0;
    }
}
