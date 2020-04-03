<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdmigasMenus extends Model
{
    /**
     * Campos que pueden ser modificados
     */
    protected $fillable = [
        'nombre', 'ruta', 'icono',
    ];
    /**
     * Nombre de la tabla
     */
    protected $table = 'admigas_menus';
    /**
     * Funcion para obtener solo los registros activos
     */
    public function scopeActive($query)
    {
        return $query->where('activo', 1);
    }
}
