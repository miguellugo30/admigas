<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdmigasCuentasBancarias extends Model
{
    /**
     * Campos que pueden ser modificados
     */
    protected $fillable = [
        'cuenta', 'clabe', 'admigas_empresas_id'
    ];
    /**
     * Nombre de la tabla
     */
    protected $table = 'admigas_cuentas_bancarias';
    /**
     * Funcion para obtener solo los registros activos
     */
    public function scopeActive($query)
    {
        return $query->where('activo', 1);
    }/**
     * Funcion para obtener solo los registros activos
     */
    public function scopeEmpresa($query, $empresa_id)
    {
        return $query->where('admigas_empresas_id', $empresa_id );
    }
    /*
    |--------------------------------------------------------------------------
    | RELACIONES DE BASE DE DATOS
    |--------------------------------------------------------------------------
    */
    public function Empresas()
    {
        return $this->belongsTo('App\AdmigasEmpresas', 'id', 'admigas_empresas_id');
    }
}
