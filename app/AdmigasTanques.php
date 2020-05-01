<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdmigasTanques extends Model
{
    /**
     * Campos que pueden ser modificados
     */
    protected $fillable = [
        'num_serie', 'marca', 'capacidad', 'estado_al_recibir', 'inventario', 'admigas_unidades_id',
    ];
    /**
     * Nombre de la tabla
     */
    protected $table = 'admigas_tanques';
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
     * Relacion muchos a uno con Unidades
     */
    public function Unidades()
    {
        return $this->belongsTo('App\AdmigasUnidades', 'admigas_unidades_id', 'id');
    }
    /**
     * Relacion muchos a muchos con condominio
     */
    public function Condominios()
    {
        return $this->belongsToMany('App\AdmigasEdificios', 'admigas_tanques_condominio', 'admigas_condominio_id', 'admigas_tanques_id');
    }
}
