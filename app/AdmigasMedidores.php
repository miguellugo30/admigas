<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdmigasMedidores extends Model
{
        /**
     * Campos que pueden ser modificados
     */
    protected $fillable = [
        'marca', 'numero_serie', 'fecha_instalacion', 'fecha_desintalacion', 'lectura', 'tipo', 'admigas_departamentos_id',
    ];
    /**
     * Nombre de la tabla
     */
    protected $table = 'admigas_medidores';
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
    public function scopeDepartamento($query, $departamentos_id)
    {
        return $query->where('admigas_departamentos_id', $departamentos_id );
    }
    /*
    |--------------------------------------------------------------------------
    | RELACIONES DE BASE DE DATOS
    |--------------------------------------------------------------------------
    */
    /**
     * Relacion uno a uno con Departamentos
     */
    public function Departamento_Medidor()
    {
        return $this->belongsTo('App\AdmigasDepartamentos', 'id', 'admigas_condominios_id');
    }
    /**
     * Relacion uno a muchos con lecturas medidores
     */
    public function Lectura()
    {
        return $this->hasMany('App\AdmigasLecturasMedidores', 'admigas_medidores_id', 'id')->orderBy('fecha_lectura', 'DESC')->limit(1);
    }
}
