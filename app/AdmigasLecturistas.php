<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdmigasLecturistas extends Model
{
    /**
     * Campos que pueden ser modificados
     */
    protected $fillable = [
        'nombre', 'apellidos', 'telefono', 'celular', 'correo_electronico', 'admigas_empresas_id',
    ];
    /**
     * Nombre de la tabla
     */
    protected $table = 'admigas_lecturistas';
    /**
     * Funcion para obtener solo los registros activos
     */
    public function scopeActive($query)
    {
        return $query->where('activo', 1);
    }
    /**
     * Funcion para obtener solo los registros de una empresa
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
}
