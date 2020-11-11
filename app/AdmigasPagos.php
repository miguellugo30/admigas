<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdmigasPagos extends Model
{
    /**
     * Campos que pueden ser modificados
     */
    protected $fillable = [
        'referencia', 'referencia_completa', 'importe', 'fecha_pago', 'estatus', 'modo', 'admigas_empresas_id'
    ];
    /**
     * Nombre de la tabla
     */
    protected $table = 'admigas_pagos';
     /**
     * Funcion para obtener solo los registros activos
     */
    public function scopeActive($query)
    {
        return $query->where('estatus', 1 );
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
