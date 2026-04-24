<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdmigasZonas extends Model
{
    /**
     * Campos que pueden ser modificados
     */
    protected $fillable = [
        'nombre', 'descripcion', 'ruta_imagen', 'activo', 'admigas_empresas_id',
    ];
    /**
     * Nombre de la tabla
     */
    protected $table = 'admigas_zonas';
    /**
     * Funcion para obtener solo los registros activos
     */
    public function scopeActive($query)
    {
        return $query->where('activo', 1);
    }
    /**
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
    /**
     * Relacion muchos a una con empresa
     */
    public function Empresas()
    {
        return $this->belongsTo('App\AdmigasEmpresas', 'admigas_empresas_id', 'id');
    }
    /**
     * Relacion uno a muchos con unidades
     */
    public function Unidades()
    {
        return $this->hasMany('App\AdmigasUnidades', 'admigas_zonas_id', 'id');
    }
}
