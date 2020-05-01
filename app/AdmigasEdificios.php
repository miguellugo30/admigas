<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdmigasEdificios extends Model
{
    /**
     * Campos que pueden ser modificados
     */
    protected $fillable = [
        'nombre', 'descuento', 'factor', 'gasto_admin', 'fecha_lectura', 'tipo', 'admigas_unidades_id',
    ];
    /**
     * Nombre de la tabla
     */
    protected $table = 'admigas_condominios';
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
    public function scopeUnidad($query, $unidad_id)
    {
        return $query->where('admigas_unidades_id', $unidad_id );
    }
    /*
    |--------------------------------------------------------------------------
    | RELACIONES DE BASE DE DATOS
    |--------------------------------------------------------------------------
    */
    /**
     * Relacion muchos a uno con unidad
     */
    public function Unidades()
    {
        return $this->belongsTo('App\AdmigasUnidades', 'admigas_unidades_id', 'id');
    }
    /**
     * Relacion muchos a muchos con tanques
     */
    public function Tanques()
    {
        return $this->belongsToMany('App\AdmigasTanques', 'admigas_tanques_condominio', 'admigas_condominios_id', 'admigas_tanques_id');
    }
}
