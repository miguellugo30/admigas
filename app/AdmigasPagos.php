<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdmigasPagos extends Model
{
    /**
     * estatus
     *
     * 1 conciliado
     * 0 no conciliado
     *
     * modo
     *
     * 1 portal cliente
     * 2 archivo conciliacion
     */
    /**
     * Campos que pueden ser modificados
     */
    protected $fillable = [
        'referencia', 'referencia_completa', 'importe', 'fecha_pago', 'autorizacion', 'medio_pago', 's_transm', 'tarjeta_habiente', 'cve_tipo_pago', 'estatus', 'modo', 'admigas_empresas_id'
    ];
    /**
     * Nombre de la tabla
     */
    protected $table = 'admigas_pagos';
     /**
     * Funcion para obtener solo los registros activos
     */
    public function scopeActive($query, $estatus)
    {
        return $query->where('estatus', $estatus );
    }
    /**
    * Funcion para obtener solo los registros activos
    */
   public function scopeModo($query, $modo)
   {
       return $query->where('modo', $modo );
   }
    /*
    |--------------------------------------------------------------------------
    | RELACIONES DE BASE DE DATOS
    |--------------------------------------------------------------------------
    */
    /**
     * Relacion uno a uno con Departamentos
     */
    public function Departamento()
    {
        return $this->belongsToMany('App\AdmigasDepartamentos', 'admigas_departamentos_pagos');
    }
}
