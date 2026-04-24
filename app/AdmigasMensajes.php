<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdmigasMensajes extends Model
{
    /**
     * Campos que pueden ser modificados
     */
    protected $fillable = [
        'nombre', 'mensaje', 'admigas_empresas_id'
    ];
    /**
     * Nombre de la tabla
     */
    protected $table = 'admigas_mensajes';
    /**
     * Funcion para obtener solo los registros activos
     */
    public function scopeActive($query)
    {
        return $query->where('activo', 1);
    }/**
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
    public function Empresas()
    {
        return $this->belongsTo('App\AdmigasEmpresas', 'admigas_empresas_id', 'id');
    }

    public function Recibos()
    {
        return $this->belongsTo('App\AdmigasRecibos', 'admigas_mensajes_recibos', 'admigas_recibos_id', 'admigas_mensajes_id');
    }
}
