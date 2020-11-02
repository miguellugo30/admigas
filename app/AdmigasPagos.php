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
        return $this->belongsTo('App\AdmigasDepartamentos', 'id', 'admigas_departamentos_id');
    }
}
