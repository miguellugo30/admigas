<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdmigasCatModulos extends Model
{
        /**
     * Campos que pueden ser modificados
     */
    protected $fillable = [
        'nombre', 'activo',
    ];
    /**
     * Nombre de la tabla
     */
    protected $table = 'admigas_cat_modulos';
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
    public function Menus()
    {
        return $this->hasMany('App\AdmigasMenus', 'admigas_cat_modulos_id', 'id');
    }
}
