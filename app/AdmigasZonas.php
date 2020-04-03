<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdmigasZonas extends Model
{
    /**
     * Campos que pueden ser modificados
     */
    protected $fillable = [
        'nombre', 'descripcion', 'ruta_imagen', 'activo', 'admigas_empresas_id',
    ];
    /**
     * Nombre de la tabla
     */
    protected $table = 'admigas_zonas';
    /**
     * Funcion para obtener solo los registros activos
     */
    public function scopeActive($query)
    {
        return $query->where('activo', 1);
    }
}
