<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdmigasCargosAdicionales extends Model
{
    /**
     * Campos que pueden ser modificados
     */
    protected $fillable = [
        'plazo', 'periodo', 'admigas_servicios_id', 'admigas_departamentos_id'
    ];
    /**
     * Nombre de la tabla
     */
    protected $table = 'admigas_cargos_adicionales';
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
    public function scopeDepto($query, $departamento_id)
    {
        return $query->where('admigas_departamentos_id', $departamento_id);
    }
    /*
    |--------------------------------------------------------------------------
    | RELACIONES DE BASE DE DATOS
    |--------------------------------------------------------------------------
    */
    /**
     * Relacion uno a muchos con Servicios
     */
    public function Servicios()
    {
        return $this->belongsTo('App\AdmigasServicios', 'admigas_servicios_id', 'id');
    }
    /**
     * Relacion uno a muchos con Servicios
     */
    public function Departamentos()
    {
        return $this->belongsTo('App\AdmigasDepartamentos', 'id', 'admigas_departamentos_id');
    }
    /**
     * Relacion uno a muchos con cargos recios
     */
    public function CargosRecibos()
    {
        return $this->belongsToMany('App\AdmigasRecibos', 'admigas_cargos_recibos');
    }
}
