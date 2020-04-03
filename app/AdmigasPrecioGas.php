<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdmigasPrecioGas extends Model
{
        /**
     * Campos que pueden ser modificados
     */
    protected $fillable = [
        'precio', 'fecha', 'activo', 'admigas_empresas_id',
    ];
    /**
     * Nombre de la tabla
     */
    protected $table = 'admigas_precios_gas';
    /**
     * Funcion para obtener solo los registros activos
     */
    public function scopeActive($query)
    {
        return $query->where('activo', 1);
    }
}
