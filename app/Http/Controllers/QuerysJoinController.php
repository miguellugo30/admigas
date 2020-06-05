<?php

namespace App\Http\Controllers;

use App\AdmigasPrecioGas;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Collection;

class QuerysJoinController extends Controller
{

    private $precio_gas;
    /**
     * Constructor para obtener el id empresa
     * con base al usuario que esta usando la sesion
     */
    public function __construct( AdmigasPrecioGas $precio_gas  )
    {
        $this->precio_gas = $precio_gas;
    }
    /**
     * Query para mostrar los departamentos y su ultima lectura
     * Se usa en la captura de lecturas
     */
    public function queryCapturaLecturas($id)
    {
        return DB::table('admigas_departamentos')
                    ->join( 'admigas_contacto_departamentos', 'admigas_departamentos.id', '=', 'admigas_contacto_departamentos.admigas_departamentos_id' )
                    ->join( 'admigas_medidores', 'admigas_departamentos.id', '=', 'admigas_medidores.admigas_departamentos_id' )
                    ->join( 'admigas_saldos', 'admigas_departamentos.id', '=', 'admigas_saldos.admigas_departamentos_id' )
                    ->select(
                                'admigas_departamentos.id AS departamento_id',
                                'admigas_departamentos.numero_departamento',
                                'admigas_contacto_departamentos.nombre',
                                'admigas_contacto_departamentos.apellidos',
                                'admigas_medidores.id AS medidor_id',
                                'admigas_medidores.numero_serie',
                                DB::raw("(SELECT admigas_lecturas_medidores.lectura FROM admigas_lecturas_medidores WHERE admigas_lecturas_medidores.admigas_medidores_id = admigas_medidores.id ORDER BY fecha_lectura DESC LIMIT 1 ) AS lectura_anterior"),
                                'admigas_saldos.saldo'
                            )
                    ->where('admigas_departamentos.admigas_condominios_id', $id)
                    ->where('admigas_departamentos.activo', 1)
                    ->get();
    }
    /**
     * Query para mostrar los departamentos y sus dos ultimas lecturas
     * Se usa en la generacion de recibos
     */
    public function queryRecibos( $id )
    {
        return DB::table('admigas_departamentos')
                    ->join( 'admigas_contacto_departamentos', 'admigas_departamentos.id', '=', 'admigas_contacto_departamentos.admigas_departamentos_id' )
                    ->join( 'admigas_medidores', 'admigas_departamentos.id', '=', 'admigas_medidores.admigas_departamentos_id' )
                    ->join( 'admigas_saldos', 'admigas_departamentos.id', '=', 'admigas_saldos.admigas_departamentos_id' )
                    ->select(
                                'admigas_departamentos.id AS departamento_id',
                                'admigas_departamentos.numero_departamento',
                                'admigas_departamentos.numero_referencia',
                                'admigas_contacto_departamentos.nombre',
                                'admigas_contacto_departamentos.apellidos',
                                'admigas_contacto_departamentos.telefono',
                                'admigas_medidores.id AS medidor_id',
                                'admigas_medidores.numero_serie',
                                DB::raw("(SELECT admigas_lecturas_medidores.lectura FROM admigas_lecturas_medidores WHERE admigas_lecturas_medidores.admigas_medidores_id = admigas_medidores.id ORDER BY fecha_lectura DESC LIMIT 1,2 ) AS lectura_anterior"),
                                DB::raw("(SELECT admigas_lecturas_medidores.fecha_lectura FROM admigas_lecturas_medidores WHERE admigas_lecturas_medidores.admigas_medidores_id = admigas_medidores.id ORDER BY fecha_lectura DESC LIMIT 1,2 ) AS fecha_lectura_anterior"),
                                DB::raw("(SELECT admigas_lecturas_medidores.lectura FROM admigas_lecturas_medidores WHERE admigas_lecturas_medidores.admigas_medidores_id = admigas_medidores.id ORDER BY fecha_lectura DESC LIMIT 1 ) AS lectura_actual"),
                                DB::raw("(SELECT admigas_lecturas_medidores.fecha_lectura FROM admigas_lecturas_medidores WHERE admigas_lecturas_medidores.admigas_medidores_id = admigas_medidores.id ORDER BY fecha_lectura DESC LIMIT 1 ) AS fecha_lectura_actual"),
                                'admigas_saldos.saldo',
                            )
                    ->where('admigas_departamentos.admigas_condominios_id', $id)
                    ->where('admigas_departamentos.activo', 1)
                    ->get();
    }

    public function calcularConsumos($deptos, $condominio, $empresa_id )
    {
        /**
         * Recuperamos el precio del gas de la empresa
         */
        $precio = $this->precio_gas->select('precio')->empresa( $empresa_id )->active()->first();
        /**
         * Calculamos los consumos de cada departamento
         */
        for ($i=0; $i < count( $deptos ); $i++)
        {
            $depto = $deptos[$i];
            $depto->me3 = ( $depto->lectura_actual - $depto->lectura_anterior );
            $depto->litros = ( $depto->lectura_actual - $depto->lectura_anterior ) * $condominio->first()->factor;
            $depto->consumo = ( ( $depto->lectura_actual - $depto->lectura_anterior ) * $condominio->first()->factor ) * $precio->precio;
        }

        return $deptos;
    }

    public function generarRecibos($deptos, $condominio, $empresa_id, $fecha_recibo)
    {
        /**
         * Recuperamos el precio del gas de la empresa
         */
        $precio = $this->precio_gas->select('precio')->empresa( $empresa_id )->active()->first();
        /**
         * Formateamos la informacion para poder ser insertada en la tabla de recibos
         */
        $info = array();
        for ($i=0; $i < count( $deptos ); $i++)
        {
            $depto = $deptos[$i];

            $v = array();

            $v['clave_recibo'] = "A-".( $i + 1 ) ;
            $v['unidad'] = $condominio->Unidades->nombre ;
            $v['condominio'] = $condominio->nombre ;
            $v['condomino'] = $depto->nombre." ".$depto->apellidos ;
            $v['numero_departamento'] = $depto->numero_departamento ;
            $v['calle'] = $condominio->Unidades->calle ;
            $v['numero_exterior'] = $condominio->Unidades->numero ;
            $v['numero_interior'] = $depto->numero_departamento ;
            $v['colonia'] = $condominio->Unidades->colonia;
            $v['delegacion'] = $condominio->Unidades->delegacion_municipio ;
            $v['cp'] = $condominio->Unidades->cp ;
            $v['calle'] = $condominio->Unidades->calle ;
            $v['telefono'] = $depto->telefono ;
            $v['fecha_recibo'] = $fecha_recibo;
            $v['fecha_lectura_anterior'] = $depto->fecha_lectura_anterior;
            $v['lectura_anterior'] = $depto->lectura_anterior;
            $v['fecha_lectura_actual'] = $depto->fecha_lectura_actual;
            $v['lectura_actual'] = $depto->lectura_actual;
            $v['fecha_limite_pago'] = Carbon::now()->addDays(7);
            $v['precio_litro'] = $precio->precio;
            $v['importe'] = ( ( $depto->lectura_actual - $depto->lectura_anterior ) * $condominio->factor ) * $precio->precio ;
            $v['adeudo_anterior'] = $depto->saldo;
            $v['cargos_adicionales'] = '0';
            $v['referencia'] = $depto->numero_referencia;
            $v['admigas_departamentos_id'] = $depto->departamento_id;
            $v['admigas_condominios_id'] = $condominio->id;

            array_push( $info, $v );

        }
        /**
         * Creamos los recibos
         */
        DB::table('admigas_recibos')->insert( $info );
    }
}
