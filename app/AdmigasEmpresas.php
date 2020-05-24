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
        return $this->hasMany('App\Users', 'admigas_empresas_id', 'id');
    }
    /**
     * Relacion uno a muchos con mensajes
     */
    public function Mensajes()
    {
        return $this->hasMany('App\AdmigasMensajes', 'admigas_empresas_id', 'id');
    }
    /**
     * Relacion uno a muchos con servicios
     */
    public function Servicios()
    {
        return $this->hasMany('App\AdmigasServicios', 'admigas_empresas_id', 'id');
    }
    /**
     * Relacion uno a muchos con precio gas
     */
    public function PrecioGas()
    {
        return $this->hasMany('App\AdmigasPrecioGas', 'admigas_empresas_id', 'id');
    }
    /**
     * Relacion uno a muchos con cuentas bancarias
     */
    public function Cuentas()
    {
        return $this->hasOne('App\AdmigasCuentasBancarias', 'admigas_empresas_id', 'id');
    }
    /**
     * Relacion uno a muchos con lecturistas
     */
    public function Lecturistas()
    {
        return $this->hasMany('App\AdmigasLecturistas', 'admigas_empresas_id', 'id');
    }
}
