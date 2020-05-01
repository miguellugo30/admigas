<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdmigasUnidades extends Model
{
    /**
     * Campos que pueden ser modificados
     */
    protected $fillable = [
        'nombre', 'calle', 'numero', 'colonia', 'delegacion_municipio', 'cp', 'estado', 'entre_calle', 'fecha_alta', 'admigas_zonas_id',
    ];
    /**
     * Nombre de la tabla
     */
    protected $table = 'admigas_unidades';
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
    public function scopeZona($query, $zona_id)
    {
        return $query->where('admigas_zonas_id', $zona_id );
    }
    /*
    |--------------------------------------------------------------------------
    | RELACIONES DE BASE DE DATOS
    |--------------------------------------------------------------------------
    */
    /**
     * Relacion muchos a uno con zonas
     */
    public function Zonas()
    {
        return $this->belongsTo('App\AdmigasZonas', 'admigas_zonas_id', 'id');
    }
    /**
     * Relacion uno a muchos con edificios
     */
    public function Edificios()
    {
        return $this->hasMany('App\AdmigasEdificios', 'admigas_unidades_id', 'id');
    }
    /**
     * Relacion uno a muchos con edificios
     */
    public function Tanques()
    {
        return $this->hasMany('App\AdmigasTanques', 'admigas_unidades_id', 'id');
    }
}
