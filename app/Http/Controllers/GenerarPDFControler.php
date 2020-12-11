<?php

namespace App\Http\Controllers;

/**
 * Modelos
 */
use App\AdmigasEmpresas;
use App\AdmigasDepartamentos;

class GenerarPDFControler extends Controller
{
    public function generate($id_departamentos, $opcion = 1, $recibos, $empresa_id)
    {
        /**
         * Recuperamos los datos del cliente
         */
        $depto =  AdmigasDepartamentos::find( $id_departamentos);
        /**
         * Obtenemos el convenio cie de la empresa
         */
        $convenio = AdmigasEmpresas::where('id', $empresa_id)->first();
        $cie =  $convenio->Cuentas->convenio_cie;

        //$empresa_id = $depto->condominios->Unidades->Zonas->admigas_empresas_id;
        /**
         * Obtenemos el codigo de la foto de fondo
         */
        $url_recibo = file_get_contents(public_path('storage/recibo/recibo_2G-v2.png'));
        /**
         * Formateamos las fechas
         */
        $fecha_lectura_anterior = date('m-Y', strtotime($recibos->fecha_lectura_anterior));
        $fecha_lectura_actual = date('m-Y', strtotime($recibos->fecha_lectura_actual));
        /**
         * Validamos que exista la foto
         */
        $foto_anterior = $this->validateUrl( $empresa_id.'/'.$recibos->admigas_condominios_id.'/'.$fecha_lectura_anterior.'/'.$recibos->admigas_departamentos_id."_".$recibos->numero_departamento.".jpeg" );
        $foto_actual = $this->validateUrl( $empresa_id.'/'.$recibos->admigas_condominios_id.'/'.$fecha_lectura_actual.'/'.$recibos->admigas_departamentos_id."_".$recibos->numero_departamento.".jpeg" );
        /**
         * Generamos el PDF
         */
        if ($opcion == 1)
        {
            $pdf = \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
                ->loadView('clientes::vista_recibo', compact('recibos', 'url_recibo', 'cie', 'empresa_id', 'foto_actual', 'foto_anterior'))
                ->setPaper('A5')
                ->stream('archivo.pdf');
        }
        else
        {
            $pdf = \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
                ->loadView('clientes::vista_recibo', compact('recibos', 'url_recibo', 'cie', 'empresa_id', 'foto_actual', 'foto_anterior'))
                ->setPaper('A5')
                ->output();

            \Storage::put('\tmp\recibo_'.$recibos->admigas_departamentos_id.'.pdf', $pdf);

            $pdf = true;
        }

        return $pdf;
    }

    /**
     * Funcion para validar que exista una imagene una URL
     *
     * @param [type] $url
     * @return $foto
     */
    public function validateUrl($url)
    {
        if( \Storage::exists( $url ) )
        {
            $foto = file_get_contents( public_path( 'storage/'.$url ) );
        }
        else
        {
            $foto = '';
        }
        return $foto;
    }
}
