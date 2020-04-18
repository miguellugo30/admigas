<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdmigasEmpresas extends Model
{
    /**
     * Campos que pueden ser modificados
     */
    protected $fillable = [
        'razon_social', 'rfc', 'calle', 'numero', 'colonia', 'municipio', 'cp',
    ];
    /**
     * Nombre de la tabla
     */
    protected $table = 'admigas_empresas';
    /**
     * Funcion para obtener solo los registros activos
     */
    public function scopeActive($query)
    {
        return $query->where('activo', 1);
    }
    /*
    |--------------------------------------------------------------------------
    | RELACIONES DE BASE DE DATOS
    |--------------------------------------------------------------------------
    */
    /**
     * Relacion uno a muchos con usuarios
     */
    public function Usuarios()
    {
        return $this->hasMany('App\Users', 'id', 'admigas_empresas_id');

    }
    /**
     * Relacion uno a muchos con mensajes
     */
    public function Mensajes()
    {
        return $this->hasMany('App\AdmigasMensajes', 'id', 'admigas_empresas_id');
    }
    /**
     * Relacion uno a muchos con mensajes
     */
    public function Servicios()
    {
        return $this->hasMany('App\AdmigasServicios', 'id', 'admigas_empresas_id');
    }
    /**
     * Relacion uno a muchos con mensajes
     */
    public function PrecioGas()
    {
        return $this->hasMany('App\AdmigasPrecioGas', 'id', 'admigas_empresas_id');
    }
}
