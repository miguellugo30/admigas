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
}
