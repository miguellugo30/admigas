<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DB;
/**
 * Modelos
 */
use App\AdmigasPrecioGas;
use App\AdmigasCargosAdicionales;

class QuerysJoinController extends Controller
{

    private $precio_gas;
    private $cargos;
    /**
     * Constructor para obtener el id empresa
     * con base al usuario que esta usando la sesion
     */
    public function __construct( AdmigasPrecioGas $precio_gas, AdmigasCargosAdicionales $cargos  )
    {
        $this->precio_gas = $precio_gas;
        $this->cargos = $cargos;
    }
    /**
     * Query para mostrar los departamentos y su ultima lectura
     * Se usa en la captura de lecturas
     */
    public function queryExcelLecturas($id)
    {
        return DB::table('admigas_departamentos')
        ->join('admigas_medidores', 'admigas_departamentos.id', '=', 'admigas_medidores.admigas_departamentos_id')
        ->select(
            'admigas_departamentos.id AS departamento_id',
            'admigas_departamentos.numero_departamento',
            'admigas_medidores.numero_serie',
            DB::raw("(SELECT admigas_lecturas_medidores.lectura FROM admigas_lecturas_medidores WHERE admigas_lecturas_medidores.admigas_medidores_id = admigas_medidores.id ORDER BY fecha_lectura DESC LIMIT 1 ) AS lectura_anterior"),
        )
            ->where('admigas_departamentos.admigas_condominios_id', $id)
            ->where('admigas_departamentos.activo', 1)
            ->orderBy('admigas_departamentos.id', 'asc')
            ->get();
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
                                'admigas_contacto_departamentos.apellido_materno',
                                'admigas_contacto_departamentos.apellido_paterno',
                                'admigas_medidores.id AS medidor_id',
                                'admigas_medidores.numero_serie',
                                DB::raw("(SELECT admigas_lecturas_medidores.lectura FROM admigas_lecturas_medidores WHERE admigas_lecturas_medidores.admigas_medidores_id = admigas_medidores.id ORDER BY fecha_lectura DESC LIMIT 1 ) AS lectura_anterior"),
                                'admigas_saldos.saldo'
                            )
                    ->where('admigas_departamentos.admigas_condominios_id', $id)
                    ->where('admigas_departamentos.activo', 1)
                    ->orderBy('admigas_departamentos.id', 'asc')
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
                                'admigas_contacto_departamentos.apellido_materno',
                                'admigas_contacto_departamentos.apellido_paterno',
                                'admigas_medidores.id AS medidor_id',
                                'admigas_medidores.numero_serie',
                                DB::raw("(SELECT admigas_lecturas_medidores.lectura FROM admigas_lecturas_medidores WHERE admigas_lecturas_medidores.admigas_medidores_id = admigas_medidores.id ORDER BY fecha_lectura DESC LIMIT 1,1 ) AS lectura_anterior"),
                                DB::raw("(SELECT admigas_lecturas_medidores.fecha_lectura FROM admigas_lecturas_medidores WHERE admigas_lecturas_medidores.admigas_medidores_id = admigas_medidores.id ORDER BY fecha_lectura DESC LIMIT 1,1 ) AS fecha_lectura_anterior"),
                                DB::raw("(SELECT admigas_lecturas_medidores.lectura FROM admigas_lecturas_medidores WHERE admigas_lecturas_medidores.admigas_medidores_id = admigas_medidores.id ORDER BY fecha_lectura DESC LIMIT 1 ) AS lectura_actual"),
                                DB::raw("(SELECT admigas_lecturas_medidores.fecha_lectura FROM admigas_lecturas_medidores WHERE admigas_lecturas_medidores.admigas_medidores_id = admigas_medidores.id ORDER BY fecha_lectura DESC LIMIT 1 ) AS fecha_lectura_actual"),
                                'admigas_saldos.saldo'
                            )
                    ->where('admigas_departamentos.admigas_condominios_id', $id)
                    ->where('admigas_departamentos.activo', 1)
                    ->get();
    }
    /**
     * Funcion para calcular los consumos de cada departamento
     */
    public function calcularConsumos($deptos, $condominio, $empresa_id )
    {
        /**
         * Recuperamos el precio del gas de la empresa
         */
        $precio = $this->precio_gas->select('precio')->empresa( $empresa_id )->active()->first();

        if (  $precio == NULL) {
            return collect([ 'error' => 1]);
            exit();
        }
        /**
         * Calculamos los consumos de cada departamento
         */
        for ($i=0; $i < count( $deptos ); $i++)
        {
            $depto = $deptos[$i];

            $depto->me3 = ( $depto->lectura_actual - $depto->lectura_anterior );
            $depto->litros = ( $depto->lectura_actual - $depto->lectura_anterior ) * $condominio->first()->factor;
            $depto->consumo = round( ( ( $depto->lectura_actual - $depto->lectura_anterior ) * $condominio->first()->factor ) * ( $precio->precio - $condominio->first()->descuento ) );
            $depto->cargos = $this->cargosDepto( $depto->departamento_id );
            $depto->gasto_admin = $condominio->first()->gasto_admin ;
        }

        return $deptos;
    }
    /**
     * Funcion para obtener los cargos activos de un departamento
     */
    public function cargosDepto( $departamento_id )
    {
        $cargo = $this->cargos->depto( $departamento_id )->active()->with('Servicios')->get();

        $cargosPeriodo = 0;
        foreach ($cargo as $c) {

            $cargosPeriodo = number_format( $cargosPeriodo + $c->Servicios->costo / $c->plazo, 2);
        }

        return (float)$cargosPeriodo;
    }
    /**
     * Funcion para poder almacenar los recibos del periodo
     */
    public function generarRecibos($deptos, $condominio, $empresa_id, $fecha_recibo)
    {
        /**
         * Agregamos los dias de fecha limite
         **/
        $fecha = new Carbon( $fecha_recibo );
        $fechaLimite = $fecha->addDays(7)->format('Y-m-d');
        /**
         * Recuperamos el precio del gas de la empresa
         */
        $precio = $this->precio_gas->select('precio')->empresa( $empresa_id )->active()->first();
        /**
         * Recuperamos el numero consecutivo para el folio
         */
        $consecutivo = $this->folio_recibo();
        /**
         * Formateamos la informacion para poder ser insertada en la tabla de recibos
         */
        $info = array();
        for ($i=0; $i < count( $deptos ); $i++)
        {
            $depto = $deptos[$i];

            $v = array();

            /**
             * Obtenemos los cargos adicionales
             */
            $cargos_adicionales = $this->cargosDepto( $depto->departamento_id );

            $v['clave_recibo'] = "A-".( $consecutivo++ );
            $v['unidad'] = $condominio->Unidades->nombre ;
            $v['condominio'] = $condominio->nombre ;
            $v['condomino'] = $depto->nombre." ".$depto->apellido_paterno." ".$depto->apellido_materno ;
            $v['numero_departamento'] = $depto->numero_departamento ;
            $v['calle'] = $condominio->Unidades->calle ;
            $v['numero_exterior'] = $condominio->Unidades->numero ;
            $v['numero_interior'] = $depto->numero_departamento ;
            $v['colonia'] = $condominio->Unidades->colonia;
            $v['delegacion'] = $condominio->Unidades->delegacion_municipio ;
            $v['cp'] = $condominio->Unidades->cp ;
            $v['calle'] = $condominio->Unidades->calle ;
            $v['telefono'] = ''/*$depto->telefono*/ ;
            $v['fecha_recibo'] = $fecha_recibo;
            $v['fecha_lectura_anterior'] = $depto->fecha_lectura_anterior;
            $v['lectura_anterior'] = $depto->lectura_anterior;
            $v['fecha_lectura_actual'] = $depto->fecha_lectura_actual;
            $v['lectura_actual'] = $depto->lectura_actual;
            $v['fecha_limite_pago'] = $fechaLimite;
            $v['precio_litro'] = $precio->precio;
            $v['importe'] = round( ( ( $depto->lectura_actual - $depto->lectura_anterior ) * $condominio->factor ) * ( $precio->precio - $condominio->descuento ) );
            $v['gasto_admin'] = $condominio->gasto_admin;
            $v['adeudo_anterior'] = $depto->saldo;
            $v['cargos_adicionales'] = $cargos_adicionales;
            $v['total_pagar'] = round( $cargos_adicionales + $depto->saldo + $condominio->gasto_admin + (($depto->lectura_actual - $depto->lectura_anterior) * $condominio->factor) * ($precio->precio - $condominio->descuento) );
            $v['referencia'] = $depto->numero_referencia;
            $v['admigas_departamentos_id'] = $depto->departamento_id;
            $v['admigas_condominios_id'] = $condominio->id;

            if( ( ( $depto->lectura_actual - $depto->lectura_anterior ) * $condominio->factor ) >= 2 )
            {
                array_push( $info, $v );
            }

        }
        /**
         * Creamos los recibos
         */
        DB::table('admigas_recibos')->insert( $info );
    }

    public function folio_recibo()
    {
        /**
         * Obtenemos el folio del ultimo recibo
         */
        $folio = DB::select("call SP_folio_ultimo_recibo()");

        if ( $folio == NULL || $folio == '' )
        {
                return 1;
        }
        else
        {
            $folio = explode( "-", $folio[0]->clave_recibo );
            return (int)$folio[1] + 1;
        }
    }
}
