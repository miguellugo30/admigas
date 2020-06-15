<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdmigasSaldos extends Model
{
    /**
     * Campos que pueden ser modificados
     */
    protected $fillable = [
        'referencia', 'total_recibos', 'total_pagos', 'saldo', 'admigas_departamentos_id'
    ];
    /**
     * Nombre de la tabla
     */
    protected $table = 'admigas_saldos';
    /**
     * Funcion para obtener solo los registros activos
     */
    public function scopeDepartamento($query, $departamento_id)
    {
        return $query->where('admigas_departamento_id', $departamento_id );
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
        return $this->belongsTo('App\AdmigasDepartamentos', 'id', 'admigas_departamentos_id');
    }
}
