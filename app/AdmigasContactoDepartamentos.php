<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdmigasContactoDepartamentos extends Model
{
    /**
     * Campos que pueden ser modificados
     */
    protected $fillable = [
        'nombre', 'apellidos', 'telefono', 'celular', 'correo_electronico', 'admigas_departamentos_id',
    ];
    /**
     * Nombre de la tabla
     */
    protected $table = 'admigas_contacto_departamentos';
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
    public function Departamento_Contacto()
    {
        return $this->belongsTo('App\AdmigasDepartamentos', 'id', 'admigas_departamentos_id');
    }
}
